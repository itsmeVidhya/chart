<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_contro extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('cart');
        $this->load->library('session');
 

    }

    // ✅ Show cart
    public function index() {
        $data['cart_items'] = $this->cart->contents();
        $data['grand_total'] = $this->cart->total();
        $this->load->view('cart', $data);
    }

    // ✅ Add product to cart via AJAX
    public function add_to_cart() {
        $products_id = $this->input->post('id', true);
        $products_name = $this->input->post('name', true);
        $products_price = $this->input->post('price', true);
        $products_image = $this->input->post('image', true);

        $found = false;
        foreach ($this->cart->contents() as $item) {
            if ($item['id'] == $products_id) {
                $this->cart->update([
                    'rowid' => $item['rowid'],
                    'qty'   => $item['qty'] + 1
                ]);
                $found = true;
                break;
            }
        }

        if (!$found) {
            $this->cart->insert([
                'id'      => $products_id,
                'name'    => $products_name,
                'price'   => $products_price,
                'qty'     => 1,
                'options' => ['image' => $products_image]
            ]);
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Product added to cart',
            'cart_total' => $this->cart->total(),
            'items_count' => $this->cart->total_items()
        ]);
    }

    // ✅ Update cart
    public function update_cart() {
        $rowids = $this->input->post('rowid');
        $quantities = $this->input->post('qty');

        foreach ($rowids as $index => $rowid) {
            $qty = (int)$quantities[$index];

            if ($this->input->post('increase_qty') === $rowid) {
                $qty += 1;
            } elseif ($this->input->post('decrease_qty') === $rowid) {
                $qty = max(1, $qty - 1);
            } elseif ($this->input->post('remove_item') === $rowid) {
                $this->cart->remove($rowid);
                continue;
            }

            $this->cart->update([
                'rowid' => $rowid,
                'qty'   => $qty
            ]);
        }

        redirect('cart_contro');
    }

    // ✅ Clear entire cart
    public function destroy() {
        $this->cart->destroy();
        redirect('cart_contro');
    }

    // ✅ Remove specific item
    public function remove_item() {
        $rowid = $this->input->post('rowid');
        if ($rowid) {
            $this->cart->remove($rowid);
        }
        redirect('cart_contro');
    }

    // ✅ Checkout page (bill preview)
    public function checkout() {
    $cart_items = $this->cart->contents();
    $grand_total = $this->cart->total();

    $data = [
        'bill_id' => strtoupper(uniqid('BILL_')),
        'date' => date('Y-m-d'),
        'items' => $cart_items,
        'grand_total' => $grand_total,
        'gst_rate' => 3
    ];

    $this->load->view('bill_list', $data); // this view includes download button
}
   public function download_pdf() {
    // Get cart data
    $cart_items = $this->cart->contents();
    $grand_total = $this->cart->total();

    // Prepare data for the view
    $data = [
        'bill_id' => strtoupper(uniqid('BILL_')),
        'date' => date('Y-m-d'),
        'items' => $cart_items,
        'grand_total' => $grand_total,
        'gst_rate' => 3
    ];

    // Load HTML view as string
    $html = $this->load->view('pdf_bill_template', $data, true);

    // Load mPDF
    require_once FCPATH . 'vendor/autoload.php';

    // Path to font directory (ensure this path is correct and font is present)
    $fontDir = APPPATH . 'fonts';

    // Check if font file exists
    if (!file_exists($fontDir . '/NotoSansMalayalam-Regular.ttf')) {
        show_error('Font file NotoSansMalayalam-Regular.ttf is missing. Please add it to ' . $fontDir);
        return;
    }

    // Create mPDF instance with Malayalam font support
    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'fontDir' => [__DIR__ . '/../fonts'],  // Make sure this matches where the font is stored
        'fontdata' => [
            'notosansmalayalam' => [
                'R' => 'NotoSansMalayalam-Regular.ttf',
            ]
        ],
        'default_font' => 'notosansmalayalam'
    ]);

    // Write HTML to PDF
    $mpdf->WriteHTML($html);
    $mpdf->Output("Invoice_{$data['bill_id']}.pdf", 'D');
}
    public function view_cart() {
        $this->load->view('cart_view');
    }
}
