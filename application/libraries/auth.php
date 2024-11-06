<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth {
    protected $CI = NULL;

    public function __construct() {
        // Get CI instance
        $this->CI =& get_instance();
    }

    // Login validation function
    public function do_login($username, $password) {
        // Check in the database for matching credentials
        $this->CI->db->from('user');
        $this->CI->db->where('user_username', $username);
        $this->CI->db->where('user_password = MD5("' . $password . '")', '', false);

        $result = $this->CI->db->get();

        if ($result->num_rows() == 0) {
            // Username and password not found
            return false;
        } else {
            // User found, retrieve information from the database
            $userdata = $result->row();
            $session_data = array(
                'user_id'   => $userdata->user_id,
                'nama'      => $userdata->user_nama,
                'alamat'    => $userdata->user_alamat,
                'kota'      => $userdata->user_kota,
                'kodepos'   => $userdata->user_kodepos,
                'telepon'   => $userdata->user_telepon,
                'email'     => $userdata->user_email,
                'username'  => $userdata->user_username,
                'role'      => $userdata->user_role,
                'level'     => $userdata->user_level
            );

            // Create session data
            $this->CI->session->set_userdata($session_data);
            return true;
        }
    }

    // Check if user is logged in
    public function is_logged_in() {
        return $this->CI->session->userdata('user_id') !== '';
    }

    // Restrict access to authenticated users
    public function restrict() {
        if ($this->is_logged_in() == false) {
            redirect('home');
        }
    }

    // Check menu access for specific user level
    public function cek_menu($idmenu) {
        $this->CI->load->model('usermodel');
        $status_user = $this->CI->session->userdata('level');
        $allowed_level = $this->CI->usermodel->get_array_menu($idmenu);

        if (!in_array($status_user, $allowed_level)) {
            die("Sorry, you do not have access to this page.");
        }
    }

    // Logout function
    public function do_logout() {
        $this->CI->session->sess_destroy();
    }
}
