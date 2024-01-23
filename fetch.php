<?php
require "config.php";


session_start();

// Check if the user is authenticated
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    // Redirect to the login page if not authenticated
    header("Location: login.php");
    exit();
}

// Check user role for authorization
$allowed_roles = ['faculty'];
if (!in_array($_SESSION['role'], $allowed_roles)) {
    header("Location: unauthorized.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    if ($data === null) {
        // JSON parsing failed
        echo "Error parsing JSON data.";
    } else {
        $selectedDates = $data["selectedDate"];
        $hallName = $data["hallName"];

        $dataarray = array(); // Initialize an empty array to store the rows

        foreach ($selectedDates as $date) {
            $query = "SELECT * FROM booking WHERE hall = '$hallName' AND time LIKE '%$date'";
            $result = mysqli_query($db, $query);


            while ($row = mysqli_fetch_assoc($result)) {
                $dataarray[] = $row;
            }
        }

        header("Content-Type: application/json");
        echo json_encode($dataarray);
    }
}
