<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h2 class="display-6 my-5">Welcome to your dashboard, <?php echo $_SESSION['name']; ?>!</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Appointments</div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php
                            // Fetch total appointments from the database
                            $stmt = $pdo->query("SELECT COUNT(*) AS total FROM appointments where user_id = {$_SESSION['user-id']}");
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $row['total'];
                            ?>
                        </h5>
                        <p class="card-text">You have <?php echo $row['total']; ?> appointments scheduled or pending approval.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Upcoming Appointments</div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php
                            // Fetch upcoming appointments from the database
                            $stmt = $pdo->query("SELECT COUNT(*) AS upcoming FROM appointments WHERE status='upcoming' and user_id = {$_SESSION['user-id']}");
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $row['upcoming'];
                            ?>
                        </h5>
                        <p class="card-text">You have <?php echo $row['upcoming']; ?> upcoming appointments.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Pending Approvals</div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php
                            // Fetch pending approvals from the database
                            $stmt = $pdo->query("SELECT COUNT(*) AS pending FROM appointments WHERE status='pending' and user_id = {$_SESSION['user-id']}");
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $row['pending'];
                            ?>
                        </h5>
                        <p class="card-text">You have <?php echo $row['pending']; ?> appointments pending approval.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <?php
                // Fetch recent appointments from the database
                $stmt = $pdo->query("SELECT * FROM appointments where user_id = {$_SESSION['user-id']} and status = 'upcoming' ORDER BY time LIMIT 5");
                if ($stmt->rowCount() > 0) {
                    echo '
                    <h3 class="display-6">Upcoming Appointments</h3>
                    <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Date and Time</th>
                        <th scope="col">Title</th>
                    </tr>
                    </thead>
                    <tbody>';
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $row['time'] . "</td>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "</tr>";
                    }
                    echo '</tbody>
                </table>';
                } else {
                    echo '<p class="display-6 my-4">You have no upcoming appointments.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>