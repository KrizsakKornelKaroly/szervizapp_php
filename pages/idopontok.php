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
    $appointments = [];
    require('../db.php');
    $appointments = apiRequest('GET', 'appointments');

    if (isset($_GET['id'])) {
        $appointment = apiRequest('GET', 'appointments', $_GET['id']);
        if ($appointment) {
            $newAppointment = $appointment;
        }
    }

    $customers = apiRequest('GET', 'customers');
    $services = apiRequest('GET', 'services');

    function getCustomerName($customerId, $customers) {
        foreach ($customers as $customer) {
            if ($customer['id'] == $customerId) {
                return $customer['name'];
            }
        }
        return 'N/A';
    }

    function getServiceName($serviceId, $services) {
        foreach ($services as $service) {
            if ($service['id'] == $serviceId) {
                return $service['name'];
            }
        }
        return 'N/A';
    }

    function getStatus($status) {
        switch ($status) {
            case 'pending':
                return 'Függőben';
            case 'confirmed':
                return 'Megerősítve';
            case 'done':
                return 'Befejezve';
            case 'canceled':
                return 'Törölve';
            default:
                return 'Ismeretlen';
        }
    }

?>


<body data-bs-theme="dark">
    <div class="container mt-5 bg-secondary-subtle p-4 rounded">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Szervíz PHP</h1>
            <a href="../index.php" class="btn btn-secondary my-0">Vissza a főoldalra</a>
        </div>

        <h2> Időpontok</h2>

        
        <div class="bg-dark p-4 rounded col-12 col-lg-6 mx-auto">
            <h4><?php echo isset($newAppointment) ? 'Időpont módosítása' : 'Új időpont hozzáadása'; ?></h4>
            <form action="<?php echo isset($newAppointment) ? '../actions/appointments/updateAppointment.php' : '../actions/appointments/newAppointment.php'; ?>" method="POST">

                <!--Rejtett mező az ID-nak -->
                <input type="hidden" name="id" value="<?php echo isset($newAppointment) ? $newAppointment['id'] : ''; ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Név</label>
                    <select class="form-select" id="customer_id" name="customer_id" required>
                        <option value="">Válassz ügyfelet</option>
                        <?php foreach ($customers as $customer): ?>
                            <option value="<?php echo $customer['id']; ?>" <?php echo (isset($newAppointment) && $newAppointment['customer_id'] == $customer['id']) ? 'selected' : ''; ?>>
                                <?php echo $customer['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="service_id" class="form-label">Szolgáltatás</label>
                    <select class="form-select" id="service_id" name="service_id" required>
                        <option value="">Válassz szolgáltatást</option>
                        <?php foreach ($services as $service): ?>
                            <option value="<?php echo $service['id']; ?>" <?php echo (isset($newAppointment) && $newAppointment['service_id'] == $service['id']) ? 'selected' : ''; ?>>
                                <?php echo $service['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <div class="mb-3">
                    <label for="appointment_date" class="form-label">Dátum</label>
                    <input type="date" class="form-control" id="appointment_date" name="appointment_date" value="<?php echo isset($newAppointment) ? $newAppointment['appointment_date'] : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="appointment_time" class="form-label">Időpont</label>
                    <input type="time" class="form-control" id="appointment_time" name="appointment_time" value="<?php echo isset($newAppointment) ? $newAppointment['appointment_time'] : ''; ?>" required>
                </div>


                <div class="mb-3">
                    <label for="status" class="form-label">Státusz</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="">Válassz státuszt</option>
                        <option value="pending" <?php echo (isset($newAppointment) && $newAppointment['status'] == 'pending') ? 'selected' : ''; ?>>Függőben</option>
                        <option value="confirmed" <?php echo (isset($newAppointment) && $newAppointment['status'] == 'confirmed') ? 'selected' : ''; ?>>Megerősítve</option>
                        <option value="done" <?php echo (isset($newAppointment) && $newAppointment['status'] == 'done') ? 'selected' : ''; ?>>Befejezve</option>
                        <option value="canceled" <?php echo (isset($newAppointment) && $newAppointment['status'] == 'canceled') ? 'selected' : ''; ?>>Törölve</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">Megjegyzések</label>
                    <textarea class="form-control" id="note" name="note" rows="3"><?php echo isset($newAppointment) ? $newAppointment['note'] : ''; ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary" 
                    name="<?php echo isset($newAppointment) ? 'updateBtn' : 'saveBtn'; ?>">
                    <?php echo isset($newAppointment) ? 'Módosítás' : 'Hozzáadás'; ?>
                </button>
                <?php
                if (isset($newAppointment)) {
                    echo '<a href="../pages/idopontok.php" class="btn btn-secondary">Mégse</a>';
                }
                ?>
            </form>
        </div>

        <div class="mt-4">
            <h2>Időpontok listája</h2>

            <table class="table table-striped table-hover mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Név</th>
                        <th>Szolgáltatás</th>
                        <th>Időpont</th>
                        <th>Státusz</th>
                        <th class="text-end">Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?php echo ++$i; ?></td>
                            <td><?php echo getCustomerName($appointment['customer_id'], $customers); ?></td>
                            <td><?php echo getServiceName($appointment['service_id'], $services); ?></td>
                            <td><?php echo $appointment['appointment_date']; ?> <?php echo $appointment['appointment_time']; ?></td>
                            <td><?php echo getStatus($appointment['status']); ?></td>
                            <td class="text-end">
                                <a href="../pages/idopontok.php?id=<?php echo $appointment['id']; ?>" class="btn btn-sm btn-warning">Szerkesztés</a>
                                <a href="../actions/appointments/deleteAppointment.php?id=<?php echo $appointment['id']; ?>" class="btn btn-sm btn-danger">Törlés</a>
                                <button class="btn btn-sm btn-info">Részletek</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="text-end">Összesen: <?php echo count($appointments); ?> db</td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</body>

</html>