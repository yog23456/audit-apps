<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Mengambil ringkasan statistik (KPI Cards)
     */
    public function get_summary_cards($filters = [])
    {
        // Ambil ID stage terakhir (urutan ke-8 / final) dari master_stage
        $final_stage = $this->db->get_where('master_stage', ['urutan' => 8])->row();
        $final_stage_id = $final_stage ? $final_stage->id : 8;

        // Base query untuk total_case & total_nilai dengan filter
        $this->db->from('audit a');
        $this->apply_filters($filters);
        $total_case = $this->db->count_all_results();

        $this->db->select_sum('a.nilai');
        $this->db->from('audit a');
        $this->apply_filters($filters);
        $total_nilai = $this->db->get()->row()->nilai ?? 0;

        $this->db->from('audit a');
        $this->db->where('a.id_stage', $final_stage_id);
        $this->apply_filters($filters);
        $completed = $this->db->count_all_results();

        $this->db->from('audit a');
        $this->db->join('master_stage ms', 'a.id_stage = ms.id', 'left');
        $this->db->where('ms.urutan <', 8);
        $this->apply_filters($filters);
        $in_progress = $this->db->count_all_results();

        return [
            'total_case'    => $total_case,
            'total_nilai'   => $total_nilai,
            'completed'     => $completed,
            'in_progress'   => $in_progress
        ];
    }

    /**
     * Helper privat untuk menerapkan query filter pencarian & dropdown
     */
    private function apply_filters($filters)
    {
        if (!empty($filters['auditor'])) {
            $this->db->where('a.id_user', $filters['auditor']);
        }
        if (!empty($filters['kategori'])) {
            $this->db->where('a.kategori', $filters['kategori']);
        }
        if (!empty($filters['stage'])) {
            $this->db->where('a.id_stage', $filters['stage']);
        }
        if (!empty($filters['sumber'])) {
            $this->db->where('a.sumber', $filters['sumber']);
        }
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $this->db->group_start();
            $this->db->like('a.no_invoice', $search);
            $this->db->or_like('a.project_name', $search);

            // Subquery untuk mencocokkan nama auditee
            $this->db->or_where("a.id IN (
                SELECT ad.id_audit FROM auditee ad 
                JOIN user u ON ad.id_user = u.id 
                WHERE u.role_name = 'auditee' AND u.name LIKE " . $this->db->escape('%' . $search . '%') . "
            )", NULL, FALSE);

            $this->db->group_end();
        }
    }

    /**
     * Menghitung total kasus per stage secara dinamis berdasarkan filter
     */
    public function get_pipeline_counts($filters = [])
    {
        $stages = [
            'investigasi' => 1,
            'review_spv'  => 2,
            'review_head' => 3,
            'konfirmasi'  => 4,
            'telaah'      => 5,
            'terbit_ba'   => 6,
            'feedback'    => 7,
            'closed'      => 8
        ];

        $counts = [];
        foreach ($stages as $key => $urutan) {
            $this->db->from('audit a');
            $this->db->join('master_stage ms', 'a.id_stage = ms.id', 'left');
            $this->db->where('ms.urutan', $urutan);
            $this->apply_filters($filters);
            $count = $this->db->count_all_results();

            $counts[$key] = $count;
            // Statistik buatan (ontime/late) untuk visualisasi
            $counts[$key . '_ontime'] = round($count * 0.84);
            $counts[$key . '_late'] = $count - $counts[$key . '_ontime'];
        }

        return $counts;
    }

    /**
     * Jumlah audit yang sedang berjalan per Stage
     */
    public function get_cases_per_stage()
    {
        $this->db->select('ms.id, ms.nama_stage as stage_name, ms.progress_value, ms.urutan, COUNT(a.id) as total_case');
        $this->db->from('master_stage ms');
        $this->db->join('audit a', 'ms.id = a.id_stage', 'left');
        $this->db->group_by('ms.id, ms.nama_stage, ms.progress_value, ms.urutan');
        $this->db->order_by('ms.urutan', 'ASC');

        return $this->db->get()->result_array();
    }

    /**
     * Mengambil daftar audit terbaru untuk tabel di dashboard (beserta filter & JOIN auditor PIC)
     */
    public function get_recent_audits($limit = 10, $filters = [], $offset = 0)
    {
        $this->db->select('
            a.id,
            a.no_invoice,
            a.sumber,
            a.kategori,
            a.project_name,
            a.nilai,
            a.id_stage,
            a.deadline,
            a.progress,
            a.target_aktual,
            a.created_at,
            a.updated_at,
            ms.nama_stage as stage_name, 
            ms.progress_value, 
            ms.role_akses as stage_role,
            ms.urutan as stage_urutan,
            u_auditor.name as auditor_pic,
            (
            SELECT u.name
            FROM auditee ad
            JOIN user u ON ad.id_user = u.id
            WHERE ad.id_audit = a.id
            LIMIT 1
            ) as nama_auditee
        ');
        $this->db->from('audit a');
        $this->db->join('master_stage ms', 'a.id_stage = ms.id', 'left');
        $this->db->join('user u_auditor', 'a.id_user = u_auditor.id AND u_auditor.role_name = "auditor"', 'left');

        $this->apply_filters($filters);

        $this->db->order_by('a.id', 'DESC');
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result_array();
    }

    // Helper options untuk Dropdowns
    public function get_all_auditors()
    {
        return $this->db->get_where('user', ['role_name' => 'auditor'])->result();
    }

    public function get_all_categories()
    {
        $this->db->distinct();
        $this->db->select('kategori');
        $this->db->where('kategori !=', '');
        return $this->db->get('audit')->result_array();
    }

    public function get_all_stages()
    {
        $this->db->order_by('urutan', 'ASC');
        return $this->db->get('master_stage')->result();
    }

    public function get_all_sources()
    {
        $this->db->distinct();
        $this->db->select('sumber');
        $this->db->where('sumber !=', '');
        return $this->db->get('audit')->result_array();
    }

    public function get_all_projects()
    {
        $this->db->select('a1.project_name, a1.nilai');
        $this->db->from('audit a1');
        $this->db->join('(SELECT project_name, MAX(id) as max_id FROM audit WHERE project_name != "" GROUP BY project_name) a2', 'a1.id = a2.max_id');
        $this->db->order_by('a1.project_name', 'ASC');
        return $this->db->get()->result_array();
    }
}
