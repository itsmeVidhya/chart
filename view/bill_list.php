<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice <?= $bill_id ?></title>
    <style>
        @font-face {
            font-family: 'NotoSansMalayalam';
            src: url('<?= base_url("assets/fonts/NotoSansMalayalam-Regular.ttf") ?>') format('truetype');
        }

        body {
            font-family: 'NotoSansMalayalam', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            color: #333;
            margin: 40px;
            font-size: 14px;
        }

        h2 {
            color: #2c3e50;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: #fff;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .summary {
            margin-top: 25px;
            text-align: right;
            font-weight: bold;
            font-size: 16px;
        }

        .actions {
            margin-top: 35px;
            text-align: center;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin: 5px;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 50px;
            color: #888;
        }
    </style>
</head>
<body>

<h2>ബിൽ (Invoice)</h2>

<div class="invoice-info">
    <p><strong>ബിൽ ഐഡി:</strong> <?= $bill_id ?></p>
    <p><strong>തീയതി:</strong> <?= $date ?></p>
</div>

<table>
    <thead>
        <tr>
            <th>ഉൽപ്പന്നം</th>
            <th>അളവ്</th>
            <th>വില (₹)</th>
            <th>ഉപമൊത്തം (₹)</th>
            <th>ജി.എസ്.ടി (3%)</th>
            <th>ആകെ (₹)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $item): 
            $gst = $item['subtotal'] * ($gst_rate / 100);
            $total_with_gst = $item['subtotal'] + $gst;
        ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= $item['qty'] ?></td>
            <td><?= number_format($item['price'], 2) ?></td>
            <td><?= number_format($item['subtotal'], 2) ?></td>
            <td><?= number_format($gst, 2) ?></td>
            <td><?= number_format($total_with_gst, 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="summary">
    മൊത്തം തുക (ജി.എസ്.ടി ഉൾപ്പെടെ): ₹<?= number_format($grand_total * 1.03, 2) ?>
</div>

<div class="actions">
    <a href="<?= site_url('cart_contro/download_pdf') ?>" class="btn btn-success">📄 പി.ഡി.എഫ് ഡൗൺലോഡ്</a>
    <a href="<?= site_url('Prod_contr') ?>" class="btn btn-secondary">← ഷോപ്പിലേക്ക് മടങ്ങുക</a>
</div>

<div class="footer">
    ഞങ്ങളുമായി വ്യാപാരം നടത്തിയത് നന്ദി! വീണ്ടും സന്ദർശിക്കുക!
</div>

</body>
</html>
