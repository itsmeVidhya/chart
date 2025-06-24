<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
   

    public function get_all_products() {
        return $this->db->get('products')->result();
    }
}
