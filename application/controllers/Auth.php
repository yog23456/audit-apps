<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[\AllowDynamicProperties]
class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Memanggil model, library, dan helper yang dibutuhkan
        $this->load->model('User_model');
        $this->load->library(['form_validation', 'session']);
        $this->load->helper('url');
    }

    // Menampilkan Halaman Login
    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard'); // <-- Ubah dari 'dashboard/index' ke 'dashboard'
        }
        $this->load->view('auth/login');
    }

    // Memproses Input Login
    public function process_login()
    {
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        // Memanggil method dari User_model
        $user = $this->User_model->get_user_by_username($username);

        if ($user && password_verify($password, $user->password)) {
            $session_data = [
                'id_user'   => $user->id,
                'username'  => $user->username,
                'name'      => $user->name,
                'role_name' => $user->role_name,
                'logged_in' => TRUE
            ];
            $this->session->set_userdata($session_data);
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Username atau Password salah!');
            redirect('auth');
        }
    }

    // Memproses Logout / Keluar
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
