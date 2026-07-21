<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
        $this->load->library('pagination');
        $this->load->helper(array('url', 'dashboard'));
    }

    public function index()
    {
        // --- Filter dari query string ---
        $filters = array(
            'auditor'  => $this->input->get('auditor'),
            'kategori' => $this->input->get('kategori'),
            'stage'    => $this->input->get('stage'),
            'sumber'   => $this->input->get('sumber'),
            'q'        => $this->input->get('q'),
        );

        // --- Pagination ---
        $per_page = 7;
        $page = (int) $this->input->get('page');
        $page = $page > 0 ? $page : 1;
        $offset = ($page - 1) * $per_page;

        $total_case = $this->Dashboard_model->count_case_list($filters);

        $config['base_url']             = site_url('dashboard');
        $config['total_rows']           = $total_case;
        $config['per_page']             = $per_page;
        $config['page_query_string']    = TRUE;
        $config['query_string_segment'] = 'page';
        $config['num_links']            = 3;
        $config['full_tag_open']        = '<ul class="pagination pagination-sm mb-0">';
        $config['full_tag_close']       = '</ul>';
        $config['attributes']           = array('class' => 'page-link');
        $config['cur_tag_open']         = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']        = '</span></li>';
        $config['num_tag_open']         = '<li class="page-item">';
        $config['num_tag_close']        = '</li>';
        $config['prev_tag_open']        = '<li class="page-item">';
        $config['prev_tag_close']       = '</li>';
        $config['next_tag_open']        = '<li class="page-item">';
        $config['next_tag_close']       = '</li>';
        $config['first_tag_open']       = '<li class="page-item">';
        $config['first_tag_close']      = '</li>';
        $config['last_tag_open']        = '<li class="page-item">';
        $config['last_tag_close']       = '</li>';
        $this->pagination->initialize($config);

        $data['page_title']       = 'Audit Finance Dashboard';
        $data['page_subtitle']    = 'Temuan Anomali & Rekap Piutang';
        $data['pipeline_summary'] = $this->Dashboard_model->get_pipeline_summary();
        $data['case_list']        = $this->Dashboard_model->get_case_list($filters, $per_page, $offset);
        $data['total_case']       = $total_case;
        $data['pagination_links'] = $this->pagination->create_links();
        $data['filters']          = $filters;

        // Layout project ini pakai pola: layouts/template.php butuh $content = nama view
        $data['content'] = 'dashboard/index';
        $this->load->view('layouts/template', $data);
    }

    /**
     * Endpoint AJAX untuk reload baris tabel sesuai filter tanpa reload halaman.
     */
    public function filter_ajax()
    {
        $filters = array(
            'auditor'  => $this->input->post('auditor'),
            'kategori' => $this->input->post('kategori'),
            'stage'    => $this->input->post('stage'),
            'sumber'   => $this->input->post('sumber'),
            'q'        => $this->input->post('q'),
        );

        $case_list = $this->Dashboard_model->get_case_list($filters, 7, 0);

        $this->load->view('dashboard/_table_rows', array('case_list' => $case_list));
    }

    /**
     * Simpan case manual baru dari modal "+ Case Manual".
     */
    public function store_case_manual()
    {
        if ($this->input->method() !== 'post') {
            show_404();
        }

        $data = array(
            'invoice'       => $this->input->post('invoice', TRUE),
            'sumber'        => $this->input->post('sumber', TRUE),
            'kategori'      => $this->input->post('kategori', TRUE),
            'proyek'        => $this->input->post('proyek', TRUE),
            'auditee'       => $this->input->post('auditee', TRUE),
            'nilai'         => $this->input->post('nilai', TRUE),
            'stage'         => $this->input->post('stage', TRUE),
            'auditor_pic'   => $this->input->post('auditor_pic', TRUE),
            'target_actual' => $this->input->post('target_actual', TRUE),
        );

        $ok = $this->Dashboard_model->insert_case_manual($data);

        echo json_encode(array('status' => $ok ? 'success' : 'error'));
    }
}