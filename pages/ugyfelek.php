<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Szervíz PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>

<?php
    $customers = [];
    require('../db.php');
    $customers = apiRequest('GET', 'customers');

    if (isset($_GET['id'])) {
        $customer = apiRequest('GET', 'customers', $_GET['id']);
        if ($customer) {
            $newCustomer = $customer;
        }
    }
?>


<body data-bs-theme="dark">
    <div class="container mt-5 bg-secondary-subtle p-4 rounded">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Szervíz PHP</h1>
            <a href="../index.php" class="btn btn-secondary my-0">Vissza a főoldalra</a>
        </div>

        <p class="fs-5">Ügyfelek</p>


        <div class="bg-dark p-4 rounded col-12 col-lg-8">
            <form action="<?php echo isset($newCustomer) ? '../actions/customers/updateCustomer.php' : '../actions/customers/newCustomer.php'; ?>" method="POST">

                <!--Rejtett mező az ID-nak -->
                <input type="hidden" name="id" value="<?php echo isset($newCustomer) ? $newCustomer['id'] : ''; ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Név</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($newCustomer) ? $newCustomer['name'] : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($newCustomer) ? $newCustomer['email'] : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Telefonszám</label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo isset($newCustomer) ? $newCustomer['phone'] : ''; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary" 
                    name="<?php echo isset($newCustomer) ? 'updateBtn' : 'saveBtn'; ?>">
                    <?php echo isset($newCustomer) ? 'Módosítás' : 'Hozzáadás'; ?>
                </button>
                <?php
                if (isset($newCustomer)) {
                    echo '<a href="../pages/ugyfelek.php" class="btn btn-secondary">Mégse</a>';
                }
                ?>
            </form>
        </div>

        <div class="mt-4">
            <h2>Ügyfelek listája</h2>

            <table class="table table-striped table-hover mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Név</th>
                        <th>Email</th>
                        <th>Telefonszám</th>
                        <th class="text-end">Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?php echo ++$i; ?></td>
                            <td><?php echo $customer['name']; ?></td>
                            <td><?php echo $customer['email']; ?></td>
                            <td><?php echo $customer['phone']; ?></td>
                            <td class="text-end">
                                <a href="../pages/ugyfelek.php?id=<?php echo $customer['id']; ?>" class="btn btn-sm btn-warning">Szerkesztés</a>
                                <a href="../actions/customers/deleteCustomer.php?id=<?php echo $customer['id']; ?>" class="btn btn-sm btn-danger">Törlés</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-end">Összesen: <?php echo count($customers); ?> db</td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</body>

</html>