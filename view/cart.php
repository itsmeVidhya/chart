<!-- Cart View -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(145deg, rgba(76, 124, 185, 0.66), #ee9ca7);
      min-height: 100vh;
      padding-top: 60px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
      max-width: 900px;
      background-color: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .product-img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 6px;
      border: 1px solid #ddd;
      margin-top: 5px;
    }
  </style>
</head>
<body class="p-3 p-md-5">

<div class="container">
  <h2 class="mb-4">Shopping chart</h2>
  <div class="row mb-4">
   
  </div>

  <h2 class="mb-4">Your Cart</h2>

  <div class="mb-3">
    Items: <span id="cart-count"><?= count($cart_items ?? []) ?></span> |
    Total: ₹<span id="cart-total"><?= number_format($grand_total ?? 0, 2) ?></span>
  </div>

  <?php if (!empty($cart_items)): ?>
    <form action="<?= site_url('cart_contro/update_cart'); ?>" method="post">
      <table class="table table-bordered table-striped align-middle">
        <thead>
          <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($cart_items as $item): ?>
            <tr>
              <td>
                <strong><?= $item['name'] ?></strong><br>
                <?php if (!empty($item['options']['image'])): ?>
                  <img src="<?= base_url('uploads/' . $item['options']['image']); ?>" alt="Product Image" class="product-img">
                <?php endif; ?>
              </td>
              <td>
                <input type="hidden" name="rowid[]" value="<?= $item['rowid'] ?>">
                <div class="input-group input-group-sm justify-content-center">
                  <button type="submit" name="decrease_qty" value="<?= $item['rowid'] ?>" class="btn btn-outline-secondary">−</button>
                  <input type="text" name="qty[]" value="<?= $item['qty'] ?>" class="form-control text-center mx-1" style="max-width: 60px;">
                  <button type="submit" name="increase_qty" value="<?= $item['rowid'] ?>" class="btn btn-outline-secondary">+</button>
                </div>
              </td>
              <td>₹<?= number_format($item['price'], 2) ?></td>
              <td>₹<?= number_format($item['subtotal'], 2) ?></td>
              <td>
                <button type="submit" name="remove_item" value="<?= $item['rowid'] ?>" class="btn btn-danger btn-sm">Remove</button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3" class="text-end fw-bold">Grand Total</td>
            <td class="fw-bold">₹<?= number_format($grand_total, 2) ?></td>
            <td></td>
          </tr>
        </tfoot>
      </table>
    </form>

    <div class="d-flex justify-content-between mt-4 flex-wrap gap-2">
      <a href="<?= site_url('cart_contro/destroy'); ?>" class="btn btn-danger">Clear Cart</a>
      <div>
        <a href="<?= site_url('/'); ?>" class="btn btn-secondary me-2">Back to Products</a>
        <a href="<?= site_url('cart_contro/checkout'); ?>" class="btn btn-success">Checkout</a>
      </div>
    </div>
  <?php else: ?>
    <div class="text-center mt-4">
      <p class="fs-5">Your cart is empty.</p>
      <a href="<?= site_url('/'); ?>" class="btn btn-primary mt-3">Shop Now</a>
    </div>
  <?php endif; ?>
</div>



</body>
</html>
