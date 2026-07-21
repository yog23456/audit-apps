<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Audit_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Audit_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
    }

    /**
     * Helper privat untuk respon JSON
     */
    private function json_response($data, $status_code = 200)
    {
        $this->output
            ->set_status_header($status_code)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
            ->_display();
        exit;
    }

    /**
     * GET: Detail Audit beserta Relasi Stage
     */
    public function detail($id)
    {
        $audit = $this->Audit_model->get_audit_detail($id);

        if (!$audit) {
            $this->json_response(['status' => false, 'message' => 'Data audit tidak ditemukan'], 404);
        }

        $this->json_response(['status' => true, 'data' => $audit], 200);
    }

    /**
     * POST: STAGE 1 - Buat Audit Baru
     */
    public function create()
    {
        $this->form_validation->set_rules('no_invoice', 'No Invoice', 'required');
        $this->form_validation->set_rules('sumber', 'Sumber', 'required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');
        $this->form_validation->set_rules('project_name', 'Nama Project', 'required');
        $this->form_validation->set_rules('nilai', 'Nilai', 'required|numeric');
        $this->form_validation->set_rules('deadline', 'Deadline', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->json_response(['status' => false, 'errors' => $this->form_validation->error_array()], 400);
        }

        $data = [
            'no_invoice'    => $this->input->post('no_invoice'),
            'sumber'        => $this->input->post('sumber'),
            'kategori'      => $this->input->post('kategori'),
            'project_name'  => $this->input->post('project_name'),
            'nilai'         => $this->input->post('nilai'),
            'deadline'      => $this->input->post('deadline'),
            'target_aktual' => $this->input->post('target_aktual'),
            'id_stage'      => 1 // Default awal
        ];

        $insert_id = $this->Audit_model->insert_audit($data);
        $this->json_response(['status' => true, 'message' => 'Audit berhasil ditambahkan', 'id' => $insert_id], 201);
    }

    /**
     * POST: STAGE 2 - Submit Berkas Investigasi
     */
    public function upload_investigasi($id_audit)
    {
        $config['upload_path']   = './uploads/investigasi/';
        $config['allowed_types'] = 'pdf|doc|docx';
        $config['max_size']      = 5120; // 5MB
        $config['encrypt_name']  = TRUE;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('upload_file')) {
            $this->json_response(['status' => false, 'error' => $this->upload->display_errors('', '')], 400);
        } else {
            $file_data = $this->upload->data();

            $data_investigasi = [
                'id_audit'    => $id_audit,
                'upload_file' => $file_data['file_name'],
                'id_user'     => $this->input->post('id_user')
            ];

            $result = $this->Audit_model->insert_investigasi($data_investigasi, $id_audit);

            if ($result) {
                $this->json_response(['status' => true, 'message' => 'Laporan investigasi berhasil disimpan & stage diperbarui']);
            } else {
                $this->json_response(['status' => false, 'message' => 'Gagal memperbarui stage audit'], 500);
            }
        }
    }

    /**
     * POST: STAGE 3 - Submit Tanggapan Auditee
     */
    public function upload_auditee($id_audit)
    {
        $config['upload_path']   = './uploads/auditee/';
        $config['allowed_types'] = 'pdf|doc|docx';
        $config['max_size']      = 5120;
        $config['encrypt_name']  = TRUE;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('upload_file')) {
            $this->json_response(['status' => false, 'error' => $this->upload->display_errors('', '')], 400);
        } else {
            $file_data = $this->upload->data();

            $data_auditee = [
                'id_audit'    => $id_audit,
                'upload_file' => $file_data['file_name'],
                'id_user'     => $this->input->post('id_user')
            ];

            $result = $this->Audit_model->insert_auditee($data_auditee, $id_audit);

            if ($result) {
                $this->json_response(['status' => true, 'message' => 'Tanggapan auditee berhasil disimpan']);
            } else {
                $this->json_response(['status' => false, 'message' => 'Gagal memperbarui stage audit'], 500);
            }
        }
    }

    /**
     * POST: STAGE 4 & 5 - Review Supervisor / Head of Audit (Berita Acara)
     */
    public function review_berita_acara($id_audit)
    {
        $this->form_validation->set_rules('keputusan_spv', 'Keputusan SPV', 'required');
        $this->form_validation->set_rules('target_stage', 'Target Stage', 'required|in_list[4,5]');
        $this->form_validation->set_rules('id_user', 'ID User', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->json_response(['status' => false, 'errors' => $this->form_validation->error_array()], 400);
        }

        $data_ba = [
            'id_audit'      => $id_audit,
            'keputusan_spv' => $this->input->post('keputusan_spv'),
            'catatan'       => $this->input->post('catatan'),
            'id_user'       => $this->input->post('id_user')
        ];

        $target_stage = $this->input->post('target_stage');

        $result = $this->Audit_model->save_berita_acara($data_ba, $id_audit, $target_stage);

        if ($result) {
            $this->json_response(['status' => true, 'message' => 'Review Berita Acara berhasil disimpan']);
        } else {
            $this->json_response(['status' => false, 'message' => 'Gagal memperbarui Review Berita Acara'], 500);
        }
    }

    // Ambil semua data audit beserta nama stage-nya
    public function get_all_audit()
    {
        $this->db->select('audit.*, master_stage.stage_name, master_stage.progress_value');
        $this->db->from('audit');
        $this->db->join('master_stage', 'master_stage.id = audit.id_stage', 'left');
        $this->db->order_by('audit.id', 'DESC');
        return $this->db->get()->result();
    }

    // Ambil detail 1 audit beserta relasi stage
    public function get_audit_by_id($id)
    {
        $this->db->select('audit.*, master_stage.stage_name, master_stage.progress_value');
        $this->db->from('audit');
        $this->db->join('master_stage', 'master_stage.id = audit.id_stage', 'left');
        $this->db->where('audit.id', $id);
        return $this->db->get()->row();
    }

    // Ambil histori/berkas dari seluruh stage untuk detail audit
    public function get_audit_history($id_audit)
    {
        return [
            'telaah'       => $this->db->get_where('telaah', ['id_audit' => $id_audit])->row(),
            'investigasi'  => $this->db->get_where('investigasi', ['id_audit' => $id_audit])->row(),
            'auditee'      => $this->db->get_where('auditee', ['id_audit' => $id_audit])->row(),
            'review_spv'   => $this->db->get_where('review_spv', ['id_audit' => $id_audit])->row(),
            'review_head'  => $this->db->get_where('review_head', ['id_audit' => $id_audit])->row(),
            'berita_acara' => $this->db->get_where('berita_acara', ['id_audit' => $id_audit])->row(),
        ];
    }

    public function insert_audit($data)
    {
        $this->db->insert('audit', $data);
        return $this->db->insert_id();
    }

    public function advance_stage($id_audit, $next_stage_id)
    {
        $this->db->where('id', $id_audit);
        return $this->db->update('audit', ['id_stage' => $next_stage_id]);
    }
}
