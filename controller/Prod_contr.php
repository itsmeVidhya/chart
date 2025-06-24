<?php
class Prod_contr extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this ->load->model('product_model');
        $this->load->helper('url');
        $this->load->library('cart');
        $this->load->library('session');

        
    }
    public function index() {
        $data['product'] = $this->product_model->get_all_products();
        $this->load->view('pro_list', $data);
        
    }

}