<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Audit_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Ambil semua data audit beserta nama stage-nya
    public function get_all_audit()
    {
        $this->db->select('audit.*, master_stage.nama_stage, master_stage.progress_value, master_stage.urutan');
        $this->db->from('audit');
        $this->db->join('master_stage', 'master_stage.id = audit.id_stage', 'left');
        $this->db->order_by('audit.id', 'DESC');
        return $this->db->get()->result();
    }

    // Ambil detail 1 audit
    public function get_audit_by_id($id_audit)
    {
        $this->db->select('audit.*, master_stage.nama_stage, master_stage.progress_value, master_stage.urutan');
        $this->db->from('audit');
        $this->db->join('master_stage', 'master_stage.id = audit.id_stage', 'left');
        $this->db->where('audit.id', $id_audit);
        return $this->db->get()->row();
    }

    // Ambil histori/berkas dari seluruh stage untuk detail audit
    public function get_audit_history($id_audit)
    {
        return [
            'investigasi'  => $this->db->get_where('investigasi', ['id_audit' => $id_audit])->row(),
            'review_spv'   => $this->db->get_where('review_spv', ['id_audit' => $id_audit])->row(),
            'review_head'  => $this->db->get_where('review_head', ['id_audit' => $id_audit])->row(),
            'auditee'      => $this->db->get_where('auditee', ['id_audit' => $id_audit])->row(),
            'telaah'       => $this->db->get_where('telaah', ['id_audit' => $id_audit])->row(),
            'berita_acara' => $this->db->get_where('berita_acara', ['id_audit' => $id_audit])->row(),
            'feedback'     => $this->db->get_where('feedback', ['id_audit' => $id_audit])->row(),
        ];
    }

    // Auto-generate Next Invoice Number (AUD-Year-Sequence incremented)
    public function generate_next_invoice()
    {
        $year = date('Y');
        $prefix = "AUD-" . $year . "-";

        // Cari no invoice terbesar dengan awalan prefix tahun ini
        $this->db->select('no_invoice');
        $this->db->like('no_invoice', $prefix, 'after');
        $this->db->order_by('no_invoice', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('audit');

        if ($query->num_rows() > 0) {
            $last_invoice = $query->row()->no_invoice;
            $parts = explode('-', $last_invoice);
            $last_num = (int) end($parts);
            $next_num = $last_num + 1;
        } else {
            $next_num = 1;
        }

        return $prefix . sprintf('%03d', $next_num);
    }

    // Insert Data Audit Baru
    public function insert_audit($data)
    {
        $this->db->insert('audit', $data);
        return $this->db->insert_id();
    }

    // Helper untuk mengambil Master Stage berdasarkan Kolom URUTAN
    public function get_stage_by_urutan($urutan)
    {
        return $this->db->get_where('master_stage', ['urutan' => $urutan])->row();
    }

    // Insert File Investigasi
    public function insert_investigasi($data)
    {
        return $this->db->insert('investigasi', $data);
    }

    // Insert File Auditee
    public function insert_auditee($data)
    {
        return $this->db->insert('auditee', $data);
    }

    // Save Berita Acara
    public function save_berita_acara($data)
    {
        return $this->db->insert('berita_acara', $data);
    }

    /**
     * Pindah Stage berdasarkan Kolom 'URUTAN' di master_stage
     * & Otomatis Update Progress
     */
    public function advance_stage_by_urutan($id_audit, $target_urutan)
    {
        // Cari data stage berdasarkan urutan
        $stage = $this->get_stage_by_urutan($target_urutan);

        if ($stage) {
            $this->db->where('id', $id_audit);
            return $this->db->update('audit', [
                'id_stage'   => $stage->id,
                'progress'   => $stage->progress_value,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        return false;
    }

    // Ambil daftar nama proyek unik buat dropdown
    public function get_distinct_projects()
    {
        $this->db->distinct();
        $this->db->select('project_name');
        $this->db->order_by('project_name', 'ASC');
        return $this->db->get('audit')->result();
    }

    // Ambil user berdasarkan role tertentu (misal: 'auditee')
    public function get_users_by_role($role)
    {
        return $this->db->get_where('user', ['role_name' => $role])->result();
    }
}
