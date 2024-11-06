<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu {
    protected $CI = NULL;

    public function __construct() {
        // Get CI instance
        $this->CI =& get_instance();
    }

    public function tampil_sidebar() {
        // Load 'usermodel'
        $this->CI->load->model('usermodel');

        // Get user level from session
        $level = $this->CI->session->userdata('level');

        // Fetch menu from the database based on user level
        $data['menu'] = $this->CI->usermodel->get_menu_for_level($level);
        $data['level'] = $level;

        // Display the sidebar view with menu data
        $this->CI->load->view('sidebar-nav', $data);
    }
}
