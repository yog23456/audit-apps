<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Audit extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Audit_model');
        $this->load->library(['form_validation', 'upload']);
    }

    public function index()
    {
        $data['title']  = 'Daftar Audit';
        $data['audits'] = $this->Audit_model->get_all_audit();

        $this->load->view('templates/header', $data);
        $this->load->view('audit/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->check_role(['auditor']);
        $data['title']        = 'Tambah Audit Baru';
        $data['next_invoice'] = $this->Audit_model->generate_next_invoice();
        $data['projects']     = $this->Audit_model->get_distinct_projects();
        $data['auditees']     = $this->Audit_model->get_users_by_role('auditee');

        $this->load->view('templates/header', $data);
        $this->load->view('audit/create', $data);
        $this->load->view('templates/footer');
    }

    public function store()
    {
        $this->check_role(['auditor']);

        $no_invoice = $this->Audit_model->generate_next_invoice();

        $this->form_validation->set_rules('sumber', 'Sumber', 'required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');

        $project_name = $this->input->post('project_name');
        if ($project_name === 'new_project') {
            $this->form_validation->set_rules('new_project_name', 'Nama Proyek Baru', 'required');
            $project_name = $this->input->post('new_project_name');
        } else {
            $this->form_validation->set_rules('project_name', 'Nama Proyek', 'required');
        }

        $this->form_validation->set_rules('nilai', 'Nilai', 'required|numeric');
        // $this->form_validation->set_rules('nilai_proyek', 'Nilai Proyek', 'required|numeric');

        if ($this->input->post('deadline') !== null && $this->input->post('deadline') !== '') {
            $this->form_validation->set_rules('deadline', 'Deadline', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            $referrer = $this->input->server('HTTP_REFERER');
            if ($referrer && strpos($referrer, 'dashboard') !== false) {
                $this->session->set_flashdata('error', 'Gagal menambahkan kasus audit: ' . validation_errors(' ', ' '));
                redirect('dashboard');
            } else {
                $this->create();
            }
        } else {
            $first_stage = $this->db->get_where('master_stage', ['urutan' => 1])->row();

            $judul_case = $this->input->post('judul_case');
            if (empty($judul_case)) {
                $judul_case = $project_name;
            }

            $deadline = $this->input->post('deadline');
            if (empty($deadline)) {
                $deadline = date('Y-m-d', strtotime('+14 days'));
            }

            $nilai = $this->input->post('nilai');
            if (empty($nilai)) {
                $nilai = 0;
            }

            // $nilai_proyek = $this->input->post('nilai_proyek');
            // if (empty($nilai_proyek)) {
            //     $nilai_proyek = 0;
            // }

            // Kalau auditee di-assign, pakai itu; kalau nggak, default ke auditor yang login
            $id_user_post = $this->input->post('id_user');
            if ($id_user_post !== null && trim((string) $id_user_post) !== '') {
                $id_user = (int) $id_user_post;
            } else {
                $id_user = $this->session->userdata('id_user');
            }

            $data = [
                'no_invoice'         => $no_invoice,
                'judul_case'         => $judul_case,
                'deskripsi'          => $this->input->post('deskripsi'),
                'catatan_head_audit' => $this->input->post('catatan_head_audit'),
                'sumber'             => $this->input->post('sumber'),
                'kategori'           => $this->input->post('kategori'),
                'project_name'       => $project_name,
                'nilai'              => $nilai,
                // 'nilai_proyek'       => $nilai_proyek,
                'deadline'           => $deadline,
                'id_user'            => $id_user,
                'target_aktual'      => $this->input->post('target_actual') ? $this->input->post('target_actual') : date('Y-m-d'),
                'id_stage'           => $first_stage ? $first_stage->id : 1,
                'progress'           => $first_stage ? $first_stage->progress_value : 15
            ];

            $this->Audit_model->insert_audit($data);
            $this->session->set_flashdata('success', 'Kasus Audit berhasil ditambahkan dengan nomor ' . $no_invoice);
            redirect('dashboard');
        }
    }

    public function detail($id_audit)
    {
        $data['audit']   = $this->Audit_model->get_audit_by_id($id_audit);
        $data['history'] = $this->Audit_model->get_audit_history($id_audit);

        if (!$data['audit']) {
            show_404();
        }

        $no_invoice    = is_array($data['audit']) ? $data['audit']['no_invoice'] : $data['audit']->no_invoice;
        $data['title'] = 'Detail Audit - ' . $no_invoice;

        $this->load->view('templates/header', $data);
        $this->load->view('audit/detail', $data);
        $this->load->view('templates/footer');
    }

    // Helper privat untuk memindahkan stage berdasarkan URUTAN
    private function _move_to_urutan($id_audit, $target_urutan)
    {
        $stage = $this->db->get_where('master_stage', ['urutan' => $target_urutan])->row();
        if ($stage) {
            $this->db->where('id', $id_audit);
            $this->db->update('audit', [
                'id_stage'   => $stage->id,
                'progress'   => $stage->progress_value,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    // Helper privat untuk unggah berkas
    private function _do_upload($field_name, $folder)
    {
        $config['upload_path']   = './uploads/' . $folder . '/';
        $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
        $config['max_size']      = 10240; // Max 10MB
        $config['encrypt_name']  = TRUE;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }

        $this->upload->initialize($config);

        if ($this->upload->do_upload($field_name)) {
            return ['status' => true, 'file_name' => $this->upload->data('file_name')];
        }
        return ['status' => false, 'error' => $this->upload->display_errors('', '')];
    }

    // Helper privat untuk memverifikasi role dan kecocokan stage aktif
    private function _check_stage_and_role($id_audit, $allowed_role, $expected_urutan)
    {
        $audit = $this->Audit_model->get_audit_by_id($id_audit);
        if (!$audit) {
            $this->session->set_flashdata('error', 'Data audit tidak ditemukan!');
            redirect('dashboard');
        }

        $user_role = $this->session->userdata('role_name');
        if ($user_role !== $allowed_role) {
            $this->session->set_flashdata('error', 'Role Anda tidak memiliki akses untuk memproses stage ini!');
            redirect('audit/detail/' . $id_audit);
        }

        if ($audit->urutan != $expected_urutan) {
            $this->session->set_flashdata('error', 'Aksi tidak valid untuk stage audit saat ini!');
            redirect('audit/detail/' . $id_audit);
        }

        return $audit;
    }

    // Stage 1: Investigasi (Role: auditor) -> Lanjut ke Stage 2 (Review SPV)
    public function submit_investigasi()
    {
        $id_audit = $this->input->post('id_audit');
        $this->_check_stage_and_role($id_audit, 'auditor', 1);

        $upload = $this->_do_upload('upload_file', 'investigasi');
        if ($upload['status']) {
            $this->db->insert('investigasi', [
                'id_audit'    => $id_audit,
                'upload_file' => 'uploads/investigasi/' . $upload['file_name'],
                'id_user'     => $this->session->userdata('id_user')
            ]);

            $this->_move_to_urutan($id_audit, 2);
            $this->session->set_flashdata('success', 'Dokumen Investigasi berhasil dikirim ke Supervisor.');
        } else {
            $this->session->set_flashdata('error', $upload['error']);
        }
        redirect('audit/detail/' . $id_audit);
    }

    // Stage 2: Review SPV (Role: spv_audit) -> Lanjut ke Stage 3 (Review Head) atau Balik ke Stage 1 (Investigasi)
    public function submit_review_spv()
    {
        $id_audit  = $this->input->post('id_audit');
        $this->_check_stage_and_role($id_audit, 'spv_audit', 2);

        $keputusan = $this->input->post('keputusan');

        $this->db->insert('review_spv', [
            'id_audit'  => $id_audit,
            'keputusan' => $keputusan,
            'catatan'   => $this->input->post('catatan'),
            'id_user'   => $this->session->userdata('id_user')
        ]);

        if ($keputusan == 'approved') {
            $this->_move_to_urutan($id_audit, 3);
            $this->session->set_flashdata('success', 'Review SPV disetujui. Laporan diteruskan ke Head of Audit.');
        } else {
            $this->_move_to_urutan($id_audit, 1);
            $this->session->set_flashdata('warning', 'Review SPV menolak. Status dikembalikan ke Investigasi.');
        }
        redirect('audit/detail/' . $id_audit);
    }

    // Stage 3: Review Head (Role: head_audit) -> Lanjut ke Stage 4 (Konfirmasi) atau Balik ke Stage 2 (Review SPV)
    public function submit_review_head()
    {
        $id_audit  = $this->input->post('id_audit');
        $this->_check_stage_and_role($id_audit, 'head_audit', 3);

        $keputusan = $this->input->post('keputusan');

        $this->db->insert('review_head', [
            'id_audit'      => $id_audit,
            'keputusan_spv' => $keputusan,
            'catatan'       => $this->input->post('catatan'),
            'id_user'       => $this->session->userdata('id_user')
        ]);

        if ($keputusan == 'approved') {
            $this->_move_to_urutan($id_audit, 4);
            $this->session->set_flashdata('success', 'Review Head disetujui. Kasus diteruskan ke Auditee untuk Konfirmasi.');
        } else {
            $this->_move_to_urutan($id_audit, 2);
            $this->session->set_flashdata('warning', 'Review Head menolak. Status dikembalikan ke Review SPV.');
        }
        redirect('audit/detail/' . $id_audit);
    }

    // Stage 4: Konfirmasi (Role: auditee) -> Lanjut ke Stage 5 (Telaah)
    public function submit_auditee()
    {
        $id_audit = $this->input->post('id_audit');
        $this->_check_stage_and_role($id_audit, 'auditee', 4);

        $upload = $this->_do_upload('upload_file', 'auditee');
        if ($upload['status']) {
            $this->db->insert('auditee', [
                'id_audit'    => $id_audit,
                'upload_file' => 'uploads/auditee/' . $upload['file_name'],
                'id_user'     => $this->session->userdata('id_user')
            ]);

            $this->_move_to_urutan($id_audit, 5);
            $this->session->set_flashdata('success', 'Konfirmasi berhasil dikirim. Menunggu Telaah oleh Auditor.');
        } else {
            $this->session->set_flashdata('error', $upload['error']);
        }
        redirect('audit/detail/' . $id_audit);
    }

    // Stage 5: Telaah (Role: auditor) -> Lanjut ke Stage 6 (Terbit Berita Acara)
    public function submit_telaah()
    {
        $id_audit = $this->input->post('id_audit');
        $this->_check_stage_and_role($id_audit, 'auditor', 5);

        $upload = $this->_do_upload('upload_file', 'telaah');
        if ($upload['status']) {
            $this->db->insert('telaah', [
                'id_audit'    => $id_audit,
                'upload_file' => 'uploads/telaah/' . $upload['file_name'],
                'id_user'     => $this->session->userdata('id_user')
            ]);

            $this->_move_to_urutan($id_audit, 6);
            $this->session->set_flashdata('success', 'Telaah dokumen berhasil disubmit. Menunggu Terbit Berita Acara.');
        } else {
            $this->session->set_flashdata('error', $upload['error']);
        }
        redirect('audit/detail/' . $id_audit);
    }

    // Stage 6: Terbit Berita Acara (Role: spv_audit) -> Lanjut ke Stage 7 (Feedback)
    public function submit_berita_acara()
    {
        $id_audit  = $this->input->post('id_audit');
        $this->_check_stage_and_role($id_audit, 'spv_audit', 6);

        $this->db->insert('berita_acara', [
            'id_audit'      => $id_audit,
            'keputusan_spv' => 'published',
            'catatan'       => $this->input->post('catatan'),
            'id_user'       => $this->session->userdata('id_user')
        ]);

        $this->_move_to_urutan($id_audit, 7);
        $this->session->set_flashdata('success', 'Berita Acara berhasil diterbitkan. Menunggu Feedback dari Auditee.');
        redirect('audit/detail/' . $id_audit);
    }

    // Stage 7: Feedback (Role: auditee) -> Lanjut ke Stage 8 (Closed)
    public function submit_feedback()
    {
        $id_audit = $this->input->post('id_audit');
        $this->_check_stage_and_role($id_audit, 'auditee', 7);

        $file_path = null;
        if (!empty($_FILES['upload_file']['name'])) {
            $upload = $this->_do_upload('upload_file', 'feedback');
            if ($upload['status']) {
                $file_path = 'uploads/feedback/' . $upload['file_name'];
            } else {
                $this->session->set_flashdata('error', $upload['error']);
                redirect('audit/detail/' . $id_audit);
                return;
            }
        }

        $this->db->insert('feedback', [
            'id_audit'    => $id_audit,
            'upload_file' => $file_path,
            'catatan'     => $this->input->post('catatan'),
            'id_user'     => $this->session->userdata('id_user')
        ]);

        $this->_move_to_urutan($id_audit, 8);
        $this->session->set_flashdata('success', 'Feedback berhasil dikirim. Kasus Audit sekarang CLOSED.');
        redirect('audit/detail/' . $id_audit);
    }
}
