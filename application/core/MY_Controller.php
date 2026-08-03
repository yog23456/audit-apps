<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property User_model $User_model
 * @property CI_DB_query_builder $db
 */

#[\AllowDynamicProperties]
class MY_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    // Function helper untuk membatasi akses berdasarkan role
    protected function check_role($allowed_roles = [])
    {
        $user_role = $this->session->userdata('role_name');
        if (!in_array($user_role, $allowed_roles)) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses ke aksi tersebut!');
            redirect('dashboard');
        }
    }
}
