<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$cart_count = $this->cart->total_items();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Product List</title>

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(145deg, rgba(76, 124, 185, 0.66), #ee9ca7);
      min-height: 100vh;
      padding-top: 60px;
    }

    .cart-btn {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1050;
      background-color: white;
      border: 2px solid rgba(75, 102, 255, 0.42);
      border-radius: 50%;
      width: 55px;
      height: 55px;
      display: flex;
      justify-content: center;
      align-items: center;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease-in-out;
    }

    .cart-btn:hover {
      background-color: rgba(75, 189, 255, 0.62);
    }

    .card-img-top {
      height: 220px;
      object-fit: cover;
    }
  </style>
</head>
<body>

<!-- Floating Cart Button -->
<div class="position-fixed top-0 end-0 p-3">
  <a href="<?= site_url('cart_contro'); ?>" class="cart-btn position-relative" title="View Cart">
    <i class="bi bi-cart2"></i>
    <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
      <?= $cart_count ?>
    </span>
  </a>
</div>

<!-- Product List -->
<div class="container">
  <h1 class="text-center text-white fw-bold mb-5">All Products</h1>
  <div class="row">
    <?php if (!empty($product)): ?>
      <?php foreach ($product as $p): ?>
        <div class="col-md-4 col-sm-6 mb-4">
          <div class="card h-100 shadow-sm">
            <img src="<?= base_url('uploads/' . $p->image); ?>" class="card-img-top" alt="<?= $p->name ?>">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= $p->name ?></h5>
              <p class="card-text"><?= $p->description ?></p>
              <p class="price-tag text-success fw-semibold">₹<?= number_format($p->price, 2) ?></p>

              <button class="btn btn-primary mt-auto add-to-cart-btn w-100"
                      data-id="<?= $p->id ?>"
                      data-name="<?= $p->name ?>"
                      data-price="<?= $p->price ?>"
                      data-image="<?= $p->image ?>">
                <i class="bi bi-cart-plus"></i> Add to Cart
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12">
        <p class="text-center text-white">No products found.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- JS: jQuery + Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
  $('.add-to-cart-btn').on('click', function (e) {
    e.preventDefault();

    const product = {
      id: $(this).data('id'),
      name: $(this).data('name'),
      price: $(this).data('price'),
      image: $(this).data('image')
    };

    $.ajax({
      url: "<?= base_url('cart_contro/add_to_cart') ?>",
      type: "POST",
      data: product,
      dataType: "json",
      success: function (res) {
        if (res.status === 'success') {
          alert(res.message);
          $('#cart-count').text(res.items_count);
        } else {
          alert('Error: ' + res.message);
        }
      },
      error: function (xhr) {
        console.error(xhr.responseText);
        alert('AJAX error occurred.');
      }
    });
  });
});
</script>
</body>
</html>
