<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[\AllowDynamicProperties]
class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Fungsi untuk mengambil data user berdasarkan username
    public function get_user_by_username($username)
    {
        return $this->db->get_where('user', ['username' => $username])->row();
    }

    public function get_user_by_id($id)
    {
        return $this->db->get_where('user', ['id' => $id])->row();
    }
}
