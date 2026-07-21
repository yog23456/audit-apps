<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property Audit_model $Audit_model
 * @property upload $upload
 * @property CI_DB_query_builder $db
 */

class Audit extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Audit_model');
        $this->load->library(['form_validation', 'upload']);
    }

    // Menampilkan daftar kasus audit
    public function index() {
        $data['title'] = 'Daftar Audit';
        $data['audits'] = $this->Audit_model->get_all_audit();
        $this->load->view('templates/header', $data);
        $this->load->view('audit/index', $data);
        $this->load->view('templates/footer');
    }

    // Detail Kasus & Form Aksi sesuai Stage Saat Ini
    public function detail($id_audit) {
        $data['audit'] = $this->Audit_model->get_audit_by_id($id_audit);
        
        if (!$data['audit']) {
            show_404();
        }

        $data['title'] = 'Detail Audit - ' . $data['audit']->no_invoice;

        $this->load->view('templates/header', $data);
        $this->load->view('audit/detail', $data);
        $this->load->view('templates/footer');
    }

    // Contoh Proses Upload Berkas Telaah (Stage 1 -> Stage 2)
    public function submit_telaah() {
        $this->check_role(['auditor']); // Hanya Auditor yang bisa submit telaah

        $id_audit = $this->input->post('id_audit');

        // Config Upload File
        $config['upload_path']   = './uploads/telaah/';
        $config['allowed_types'] = 'pdf|doc|docx';
        $config['max_size']      = 5120; // 5MB
        $config['file_name']     = 'telaah_' . time();

        $this->upload->initialize($config);

        if ($this->upload->do_upload('file_telaah')) {
            $file_data = $this->upload->data();
            
            // 1. Simpan data ke tabel `telaah`
            $data_telaah = [
                'id_audit'  => $id_audit,
                'file_path' => 'uploads/telaah/' . $file_data['file_name'],
                'catatan'   => $this->input->post('catatan')
            ];
            $this->db->insert('telaah', $data_telaah);

            // 2. Naikkan stage audit ke stage selanjutnya (misal: ID Stage 2)
            $next_stage_id = 2; 
            $this->Audit_model->advance_stage($id_audit, $next_stage_id);

            $this->session->set_flashdata('success', 'Tahap Telaah berhasil diselesaikan!');
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
        }

        redirect('audit/detail/' . $id_audit);
    }

    // Contoh Proses Review SPV (Stage Review -> Stage Berikutnya)
    public function submit_review_spv() {
        $this->check_role(['spv_audit']); // Hanya SPV yang bisa review

        $id_audit = $this->input->post('id_audit');
        $keputusan = $this->input->post('keputusan'); // 'approved' / 'rejected'

        $data_spv = [
            'id_audit'  => $id_audit,
            'keputusan' => $keputusan,
            'catatan'   => $this->input->post('catatan'),
            'id_user'   => $this->session->userdata('id_user')
        ];
        $this->db->insert('review_spv', $data_spv);

        if ($keputusan == 'approved') {
            // Lanjut ke stage berikutnya (misal: Head Audit / ID 5)
            $this->Audit_model->advance_stage($id_audit, 5);
            $this->session->set_flashdata('success', 'Review SPV disetujui.');
        } else {
            // Jika dikembalikan/direvisi, sesuaikan logika ID stage revisinya
            $this->session->set_flashdata('warning', 'Review SPV menolak / meminta revisi.');
        }

        redirect('audit/detail/' . $id_audit);
    }
}