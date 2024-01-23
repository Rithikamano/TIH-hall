<?php
require 'config.php';

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

if (isset($_POST['bookingRequest'])) {
    $userName = $_POST['userName'];
    $hallName = $_POST['hallName'];
    $eventName = $_POST['eventName'];
    $micType = $_POST['micType'];

    $myArray = json_decode($_POST['myArray']);

    foreach ($myArray as $cell) {
        $query = "SELECT * FROM booking WHERE hall = '$hallName' AND time = '$cell'";
        $query_run = mysqli_query($db, $query);
        if (mysqli_num_rows($query_run) > 0) {
            $res = [
                'status' => 500,
                'message' => 'Time slots already booked!'
            ];
            echo json_encode($res);
            return;
        }
    }

    foreach ($myArray as $time) {
        $query = " INSERT INTO booking(	user,hall,time,event,req,status) VALUES('$userName','$hallName','$time','$eventName','$micType','requested')";
        $query_run = mysqli_query($db, $query);
    }


    if ($query_run) {
        $res = [
            'status' => 200,
            'message' => 'Hall booked Successfully'
        ];
        echo json_encode($res);
        return;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Error in booking Hall'
        ];
        echo json_encode($res);
        return;
    }
}
