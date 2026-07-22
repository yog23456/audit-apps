<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Dashboard_model');

        // Jika session tidak ada/false, kembalikan ke login
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu!');
            redirect('auth'); // Atau redirect('login');
        }
    }

    /**
     * Menampilkan Halaman Dashboard Utama (SSR / View CodeIgniter)
     */
    public function index()
    {
        $data['user']           = [
            'name'      => $this->session->userdata('name'),
            'username'  => $this->session->userdata('username'),
            'role_name' => $this->session->userdata('role_name')
        ];

        // Tangkap parameter filter GET
        $filters = [
            'auditor'  => $this->input->get('auditor', TRUE),
            'kategori' => $this->input->get('kategori', TRUE),
            'stage'    => $this->input->get('stage', TRUE),
            'sumber'   => $this->input->get('sumber', TRUE),
            'search'   => $this->input->get('search', TRUE)
        ];

        $data['summary']        = $this->Dashboard_model->get_summary_cards($filters);
        $data['pipeline']       = $this->Dashboard_model->get_pipeline_counts($filters);
        $data['stage_stats']    = $this->Dashboard_model->get_cases_per_stage();
        $data['recent_audits']  = $this->Dashboard_model->get_recent_audits(null, $filters); // Ambil semua data terfilter

        // Ambil data untuk pilihan dropdown
        $data['auditors']       = $this->Dashboard_model->get_all_auditors();
        $data['categories']     = $this->Dashboard_model->get_all_categories();
        $data['stages']         = $this->Dashboard_model->get_all_stages();
        $data['sources']        = $this->Dashboard_model->get_all_sources();
        $data['projects']       = $this->Dashboard_model->get_all_projects();
        
        // Kirim filter aktif kembali ke view
        $data['filters']        = $filters;

        // Memuat view dashboard beserta header/footer jika ada
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Optional: Endpoint API JSON untuk AJAX / SPA Dashboard Updates
     */
    public function get_stats_json()
    {
        $response = [
            'status' => true,
            'data'   => [
                'summary'       => $this->Dashboard_model->get_summary_cards(),
                'stage_stats'   => $this->Dashboard_model->get_cases_per_stage(),
                'recent_audits' => $this->Dashboard_model->get_recent_audits(5)
            ]
        ];

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
