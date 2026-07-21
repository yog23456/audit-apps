<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Mengambil ringkasan statistik (KPI Cards)
     */
    public function get_summary_cards() {
        return [
            'total_case'    => $this->db->count_all('audit'),
            'total_nilai'   => $this->db->select_sum('nilai')->get('audit')->row()->nilai ?? 0,
            'completed'     => $this->db->where('id_stage', 5)->from('audit')->count_all_results(),
            'in_progress'   => $this->db->where('id_stage <', 5)->from('audit')->count_all_results()
        ];
    }

    /**
     * Jumlah audit yang sedang berjalan per Stage
     */
    public function get_cases_per_stage() {
        $this->db->select('ms.id, ms.nama_stage as stage_name, ms.progress_value, COUNT(a.id) as total_case');
        $this->db->from('master_stage ms');
        $this->db->join('audit a', 'ms.id = a.id_stage', 'left');
        $this->db->group_by('ms.id, ms.nama_stage, ms.progress_value');
        $this->db->order_by('ms.id', 'ASC');
        
        return $this->db->get()->result_array();
    }

    /**
     * Mengambil daftar audit terbaru untuk tabel di dashboard
     */
    public function get_recent_audits($limit = 5) {
        $this->db->select('a.*, ms.nama_stage as stage_name, ms.progress_value, ms.role_akses as stage_role');
        $this->db->from('audit a');
        $this->db->join('master_stage ms', 'a.id_stage = ms.id', 'left');
        $this->db->order_by('a.id', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result_array();
    }
}