<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user-id'])) {
    header('Location: index.php');
    $_SESSION['login-error'] = 'You need to login first!';
    exit();
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
    <style>
        .custom-day-header {
            background-color: #f0f0f0;
            border-bottom: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h2 class="display-6 my-5">Welcome to your dashboard, <?php echo $_SESSION['name']; ?>!</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Upcoming Appointments</div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php
                            // Fetch upcoming appointments from the database
                            $stmt = $pdo->query("SELECT COUNT(*) AS upcoming FROM appointments WHERE status='upcoming' AND user_id = {$_SESSION['user-id']} AND WEEK(time) = WEEK(CURDATE())");
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $row['upcoming'];
                            ?>
                        </h5>
                        <p class="card-text">You have <?php echo $row['upcoming']; ?> upcoming appointment/s this week.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Completed Appointments</div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php
                            // Fetch completed appointments from the database
                            $stmt = $pdo->query("SELECT COUNT(*) AS completed FROM appointments WHERE status='completed' AND user_id = {$_SESSION['user-id']} AND WEEK(time) = WEEK(CURDATE())");
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $row['completed'];
                            ?>
                        </h5>
                        <p class="card-text">You have completed <?php echo $row['completed']; ?> appointment/s this week.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Cancelled Appointments</div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php
                            // Fetch cancelled appointments from the database
                            $stmt = $pdo->query("SELECT COUNT(*) AS cancelled FROM appointments WHERE status='cancelled' AND user_id = {$_SESSION['user-id']} AND WEEK(time) = WEEK(CURDATE())");
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo $row['cancelled'];
                            ?>
                        </h5>
                        <p class="card-text">You have cancelled <?php echo $row['cancelled']; ?> appointment/s this week.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <h3 class="display-6">Appointments This Week</h3>
                <div id="calendar" class="mb-5"></div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    dayHeaderFormat: {
                        weekday: 'short',
                        month: 'short',
                        day: 'numeric'
                    },
                    dayHeaderClassNames: 'custom-day-header',
                    height: 400,
                    initialView: 'dayGridWeek',
                    events: [
                        <?php
                        // Fetch upcoming appointments from the database
                        $stmt = $pdo->query("SELECT * FROM appointments WHERE user_id = {$_SESSION['user-id']} and status = 'upcoming'");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "{";
                            echo "title: '" . $row['title'] . "',";
                            echo "start: '" . $row['time'] . "'";
                            echo "},";
                        }
                        ?>
                    ]
                });
                calendar.render();
            });
        </script>
    </div>
</body>

</html>