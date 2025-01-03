<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Appointment Dashboard</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Client Name</th>
            <th>Appointment Date</th>
            <th>Status</th>
        </tr>
        <tr>
            <td>1</td>
            <td>John Doe</td>
            <td>2023-10-01</td>
            <td>Confirmed</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Jane Smith</td>
            <td>2023-10-02</td>
            <td>Pending</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Bob Johnson</td>
            <td>2023-10-03</td>
            <td>Cancelled</td>
        </tr>
    </table>
    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</body>

</html>