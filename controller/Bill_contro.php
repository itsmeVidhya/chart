<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bill_contro extends CI_Controller {

    public function __construct() {
        parent::__construct();
    
        $this->load->helper('url');
        $this->load->library('session');
        
    }

    // ✅ Show bill details
    public function index() {
  
        $this->load->view('bill_list');
    }

    // ✅ Add a new bill
   
}