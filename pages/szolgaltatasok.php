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
    $services = [];
    require('../db.php');
    $services = apiRequest('GET', 'services');

    if (isset($_GET['id'])) {
        $service = apiRequest('GET', 'services', $_GET['id']);
        if ($service) {
            $newService = $service;
        }
    }
?>


<body data-bs-theme="dark">
    <div class="container mt-5 bg-secondary-subtle p-4 rounded">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Szervíz PHP</h1>
            <a href="../index.php" class="btn btn-secondary my-0">Vissza a főoldalra</a>
        </div>

        <h2>Szolgáltatások</h2>


        <div class="bg-dark p-4 rounded col-12 col-lg-6 mx-auto">
            <h4><?php echo isset($newService) ? 'Szolgáltatás módosítása' : 'Új szolgáltatás hozzáadása'; ?></h4>
            <form action="<?php echo isset($newService) ? '../actions/services/updateService.php' : '../actions/services/newService.php'; ?>" method="POST">

                <!--Rejtett mező az ID-nak -->
                <input type="hidden" name="id" value="<?php echo isset($newService) ? $newService['id'] : ''; ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Megnevezés</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($newService) ? $newService['name'] : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Ár</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?php echo isset($newService) ? $newService['price'] : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="duration_minutes" class="form-label">Hossz (perc)</label>
                    <input type="number" class="form-control" id="duration_minutes" name="duration_minutes" value="<?php echo isset($newService) ? $newService['duration_minutes'] : ''; ?>" required>
                </div>


                <button type="submit" class="btn btn-primary"
                    name="<?php echo isset($newService) ? 'updateBtn' : 'saveBtn'; ?>">
                    <?php echo isset($newService) ? 'Módosítás' : 'Hozzáadás'; ?>
                </button>
                <?php
                if (isset($newService)) {
                    echo '<a href="../pages/szolgaltatasok.php" class="btn btn-secondary">Mégse</a>';
                }
                ?>
            </form>
        </div>

        <div class="mt-4">
            <h2>Szolgáltatások listája</h2>

            <table class="table table-striped table-hover mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Név</th>
                        <th>Ár</th>
                        <th>Hossz (perc)</th>
                        <th class="text-end">Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td><?php echo ++$i; ?></td>
                            <td><?php echo $service['name']; ?></td>
                            <td><?php echo $service['price']; ?></td>
                            <td><?php echo $service['duration_minutes']; ?></td>
                            <td class="text-end">
                                <a href="../pages/szolgaltatasok.php?id=<?php echo $service['id']; ?>" class="btn btn-sm btn-warning">Szerkesztés</a>
                                <a href="../actions/services/deleteService.php?id=<?php echo $service['id']; ?>" class="btn btn-sm btn-danger">Törlés</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-end">Összesen: <?php echo count($services); ?> db</td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</body>

</html>