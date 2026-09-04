<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper(array('url', 'dashboard'));
        $this->load->model(array('Dashboard_model', 'Audit_model'));

        // Proteksi halaman dashboard
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata(
                'error',
                'Silakan login terlebih dahulu!'
            );

            redirect('auth');
        }
    }

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | DATA USER LOGIN
        |--------------------------------------------------------------------------
        */
        $data['user'] = array(
            'name'      => $this->session->userdata('name'),
            'username'  => $this->session->userdata('username'),
            'role_name' => $this->session->userdata('role_name')
        );


        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */
        $filters = array(
            'auditor'  => $this->input->get('auditor', TRUE),
            'kategori' => $this->input->get('kategori', TRUE),
            'stage'    => $this->input->get('stage', TRUE),
            'sumber'   => $this->input->get('sumber', TRUE),
            'search'   => $this->input->get('q', TRUE)
        );


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */
        $per_page = 7;

        $page = (int) $this->input->get('page');

        if ($page < 1) {
            $page = 1;
        }

        $offset = ($page - 1) * $per_page;


        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA DARI MODEL BACKEND
        |--------------------------------------------------------------------------
        */
        $summary = $this->Dashboard_model->get_summary_cards($filters);

        $pipeline = $this->Dashboard_model->get_pipeline_counts($filters);

        $stages = $this->Dashboard_model->get_cases_per_stage();

        $recent_audits = $this->Dashboard_model->get_recent_audits(
            $per_page,
            $filters,
            $offset
        );


        /*
        |--------------------------------------------------------------------------
        | JUDUL UNTUK VIEW FRONTEND
        |--------------------------------------------------------------------------
        */
        $data['page_title'] = 'Audit Finance Dashboard';

        $data['page_subtitle'] = 'Temuan Anomali & Rekap Piutang';


        /*
        |--------------------------------------------------------------------------
        | PIPELINE SUMMARY
        | Mengubah data backend agar sesuai format frontend
        |--------------------------------------------------------------------------
        */
        $data['pipeline_summary'] = array();

        $icons = array(
            'bi-file-earmark-text',
            'bi-x-circle',
            'bi-check-circle',
            'bi-chat-square-text',
            'bi-search',
            'bi-person-vcard',
            'bi-chat-heart',
            'bi-list-check'
        );

        foreach ($stages as $index => $stage) {

            $stage_key = array(
                'investigasi',
                'review_spv',
                'review_head',
                'konfirmasi',
                'telaah',
                'terbit_ba',
                'feedback',
                'closed'
            );

            $key = isset($stage_key[$index])
                ? $stage_key[$index]
                : null;

            $total = $key && isset($pipeline[$key])
                ? $pipeline[$key]
                : 0;

            $ontime = $key && isset($pipeline[$key . '_ontime'])
                ? $pipeline[$key . '_ontime']
                : 0;

            $late = $key && isset($pipeline[$key . '_late'])
                ? $pipeline[$key . '_late']
                : 0;

            $data['pipeline_summary'][] = array(
                'role'    => isset($stage['stage_role'])
                    ? $stage['stage_role']
                    : '',

                'label'   => isset($stage['stage_name'])
                    ? $stage['stage_name']
                    : '',

                'icon'    => isset($icons[$index])
                    ? str_replace('bi-', '', $icons[$index])
                    : 'circle',

                'total'   => $total,
                'ontime'  => $ontime,
                'late'    => $late
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CASE LIST
        | Mengubah nama field backend → nama field frontend
        |--------------------------------------------------------------------------
        */
        $data['case_list'] = array();

        foreach ($recent_audits as $row) {

            $progress = isset($row['progress'])
                ? (int) $row['progress']
                : 0;


            /*
            | Warna stage
            */
            $stage_color = 'bg-gray-500';

            switch (strtolower($row['stage_name'] ?? '')) {

                case 'investigasi':
                    $stage_color = 'bg-orange-500';
                    break;

                case 'review spv':
                    $stage_color = 'bg-yellow-500';
                    break;

                case 'review head':
                case 'review head unit':
                    $stage_color = 'bg-blue-500';
                    break;

                case 'konfirmasi':
                case 'konfirmasi auditee':
                    $stage_color = 'bg-purple-500';
                    break;

                case 'telaah':
                    $stage_color = 'bg-indigo-500';
                    break;

                case 'terbit ba':
                    $stage_color = 'bg-cyan-600';
                    break;

                case 'feedback':
                    $stage_color = 'bg-teal-500';
                    break;

                case 'closed':
                    $stage_color = 'bg-green-600';
                    break;
            }


            /*
            | Warna progress
            */
            if ($progress >= 75) {

                $progress_color =
                    'bg-green-500 text-green-600';

            } elseif ($progress >= 40) {

                $progress_color =
                    'bg-blue-500 text-blue-600';

            } else {

                $progress_color =
                    'bg-orange-500 text-orange-600';
            }


            /*
            | Format row agar cocok dengan frontend
            */
            $data['case_list'][] = array(

                'invoice' =>
                    $row['no_invoice'] ?? '-',

                'sumber' =>
                    $row['sumber'] ?? '-',

                'kategori' =>
                    $row['kategori'] ?? '-',

                'proyek' =>
                    $row['project_name'] ?? '-',

                'auditee' =>
                    $row['nama_auditee'] ?? '-',

                'nilai' =>
                    $row['nilai'] ?? 0,

                'stage' =>
                    $row['stage_name'] ?? '-',

                'stage_color' =>
                    $stage_color,

                'deadline' =>
                    $row['deadline'] ?? '-',

                'progress' =>
                    $progress,

                'progress_color' =>
                    $progress_color,

                'auditor_pic' =>
                    $row['auditor_pic'] ?? '-',

                'target_actual' =>
                    $row['target_aktual'] ?? '-',

                'expanded' => false
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL CASE
        |--------------------------------------------------------------------------
        */
        $data['total_case'] =
            isset($summary['total_case'])
                ? $summary['total_case']
                : 0;

        $data['current_page'] = $page;
        $data['per_page']     = $per_page;
        $data['total_pages']  = ($data['total_case'] > 0) ? (int) ceil($data['total_case'] / $per_page) : 1;
        /*
        |--------------------------------------------------------------------------
        | FILTER UNTUK VIEW
        |--------------------------------------------------------------------------
        |
        | Frontend menggunakan $filters['q']
        | sedangkan model backend menggunakan "search".
        |
        */
        $data['filters'] = array(
            'auditor' =>
                $filters['auditor'],

            'kategori' =>
                $filters['kategori'],

            'stage' =>
                $filters['stage'],

            'sumber' =>
                $filters['sumber'],

            'q' =>
                $filters['search']
        );


        /*
        |--------------------------------------------------------------------------
        | DATA DROPDOWN
        |--------------------------------------------------------------------------
        */
        $data['auditors'] =
            $this->Dashboard_model->get_all_auditors();

        $data['categories'] =
            $this->Dashboard_model->get_all_categories();

        $data['stages'] =
            $this->Dashboard_model->get_all_stages();

        $data['sources'] =
            $this->Dashboard_model->get_all_sources();

        $data['projects'] =
            $this->Dashboard_model->get_all_projects();


        /*
        |--------------------------------------------------------------------------
        | LOAD LAYOUT FRONTEND
        |--------------------------------------------------------------------------
        */
        $data['content'] = 'dashboard/index';

        $this->load->view(
            'layouts/template',
            $data
        );
    }


    /*
    |--------------------------------------------------------------------------
    | API DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function get_stats_json()
    {
        $response = array(
            'status' => true,

            'data' => array(

                'summary' =>
                    $this->Dashboard_model
                        ->get_summary_cards(),

                'stage_stats' =>
                    $this->Dashboard_model
                        ->get_cases_per_stage(),

                'recent_audits' =>
                    $this->Dashboard_model
                        ->get_recent_audits(5)
            )
        );

        $this->output
            ->set_status_header(200)
            ->set_content_type(
                'application/json',
                'utf-8'
            )
            ->set_output(
                json_encode(
                    $response,
                    JSON_PRETTY_PRINT |
                    JSON_UNESCAPED_UNICODE
                )
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN CASE MANUAL (AJAX & POST)
    |--------------------------------------------------------------------------
    */
    public function store_case_manual()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('sumber', 'Sumber Informasi', 'required');
        $this->form_validation->set_rules('kategori', 'Kategori Case', 'required');

        $project_name = $this->input->post('project_name');
        if (empty($project_name)) {
            $project_name = $this->input->post('proyek');
        }
        if (empty($project_name)) {
            $project_name = 'Umum';
        }

        $judul_case = $this->input->post('judul_case');
        if (empty($judul_case)) {
            $judul_case = $project_name;
        }

        $target_actual = $this->input->post('target_actual');
        if (empty($target_actual)) {
            $target_actual = date('Y-m-d', strtotime('+14 days'));
        }

        $first_stage = $this->db->get_where('master_stage', ['urutan' => 1])->row();
        $no_invoice  = $this->Audit_model->generate_next_invoice();

        $auditor_pic = $this->input->post('auditor_pic');
        $id_user = $this->session->userdata('id_user');
        if (!empty($auditor_pic)) {
            $user_match = $this->db->get_where('user', ['name' => $auditor_pic])->row();
            if ($user_match) {
                $id_user = $user_match->id;
            }
        }
        if (empty($id_user)) {
            $id_user = 1;
        }

        $data = [
            'no_invoice'         => $no_invoice,
            'judul_case'         => $judul_case,
            'deskripsi'          => $this->input->post('deskripsi', TRUE),
            'catatan_head_audit' => $this->input->post('catatan_head_audit', TRUE),
            'sumber'             => $this->input->post('sumber', TRUE),
            'kategori'           => $this->input->post('kategori', TRUE),
            'project_name'       => $project_name,
            'nilai'              => (float) $this->input->post('nilai'),
            'deadline'           => $target_actual,
            'id_user'            => $id_user,
            'target_aktual'      => $target_actual,
            'id_stage'           => $first_stage ? $first_stage->id : 1,
            'progress'           => $first_stage ? $first_stage->progress_value : 15,
            'created_at'         => date('Y-m-d H:i:s'),
            'updated_at'         => date('Y-m-d H:i:s')
        ];

        $insert_id = $this->Audit_model->insert_audit($data);

        $is_ajax = $this->input->is_ajax_request() ||
                   ($this->input->get_request_header('X-Requested-With') === 'XMLHttpRequest');

        if ($is_ajax) {
            $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'status'     => 'success',
                    'message'    => 'Case baru berhasil didaftarkan ke tracking dengan nomor ' . $no_invoice,
                    'id'         => $insert_id,
                    'no_invoice' => $no_invoice
                ]));
            return;
        }

        $this->session->set_flashdata('success', 'Kasus Audit ' . $no_invoice . ' berhasil ditambahkan!');
        redirect('dashboard');
    }
}