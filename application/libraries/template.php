<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Template Library
 * 
 * Provides a simple templating functionality for CodeIgniter.
 * 
 * @author Jérôme Jaglale
 * @url http://maestric.com/doc/php/codeigniter_template
 */
class Template {
    protected $template_data = array();

    // Set template variable
    public function set($name, $value) {
        $this->template_data[$name] = $value;
    }

    // Load the template and view
    public function load($template = '', $view = '', $view_data = array(), $return = FALSE) {
        $this->CI =& get_instance();
        
        // Set view content in 'contents' key
        $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
        
        // Load the template with template data
        return $this->CI->load->view($template, $this->template_data, $return);
    }
}

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */
