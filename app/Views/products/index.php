<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Product Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: rgb(31 41 55 / var(--tw-bg-opacity, 1));
            padding-top: 30px;
        }
        .container {
            margin-top: 30px;
        }
        h1 {
            text-align: center;
            margin: 20px 0;
            font-family: Arial, sans-serif;
            color: white !important;
        }
       
        .table-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .table-title {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 30px;
        }
        .table {
            margin: 0 auto;
            width: auto;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .btn-custom {
            margin-right: 10px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .action-buttons {
            display: flex;
            justify-content: space-between;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="table-title">Ecommerce Product Management</h1>
                <div class="table-container">
                    <a href="/products/create" class="btn btn-primary mb-3" style="margin-left: 700px;">Add New Product</a>
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Variants</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($products) && !empty($products)): ?>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?= esc($product['id']); ?></td>
                                        <td><?= esc($product['name']); ?></td>
                                        <td><?= esc($product['description']); ?></td>
                                        <td><?= esc($product['price']); ?></td>
                                        <td><?= esc($product['category_name']); ?></td>
                                        <td>
                                            <?php if (!empty($product['variants'])): ?>
                                                <ul class="list-unstyled">
                                                    <?php foreach ($product['variants'] as $variant): ?>
                                                        <li><?= esc($variant['variant_name']); ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else: ?>
                                                <em>No variants</em>
                                            <?php endif; ?>
                                        </td>
                                        <td class="action-buttons">
                                            <a href="/products/edit/<?= esc($product['id']); ?>" class="btn btn-warning btn-sm btn-custom">Edit</a>
                                            <form action="/products/delete/<?= esc($product['id']); ?>" method="post" onsubmit="return confirm('Are you sure you want to delete this product?');" style="display:inline;">
                                                <?= csrf_field(); ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-danger btn-sm btn-custom">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No products found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
