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
?>


<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>Matrix Template - The Ultimate Multipurpose admin template</title>
    <!-- Custom CSS -->
    <link href="assets/libs/flot/css/float-chart.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <style>
        /* Style the card container */
        .msg-box {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 15px;
            display: flex;
            flex-direction: column;
        }

        /* Style the header (Hall Name) */
        .msg-hall-event h3 {
            font-size: 18px;
            margin: 0;
        }

        /* Style the event and reason text */
        .msg-hall-event p,
        .msg-reason p {
            font-size: 16px;
            margin: 0;
            padding: 5px 0;
        }

        /* Style the time and status text */
        .msg-time-status p {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            padding: 5px 0;
            color: #333;
            background-color: #f5f5f5;
            border-radius: 3px;
            display: inline-block;
            padding: 3px 10px;
        }

        /* Style the status text for different statuses */
        .msg-time-status p.status-pending {
            background-color: #f1c40f;
            /* Yellow background for pending status */
            color: #fff;
        }

        .msg-time-status p.status-rejected {
            background-color: #e74c3c;
            /* Red background for rejected status */
            color: #fff;
        }
    </style>
</head>

<body>
    <div id="main-wrapper">

        <?php
        require 'aside.php';
        ?>

        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <div class="notifications" id="notifications">
                                <?php

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="assets/extra-libs/sparkline/sparkline.js"></script>
    <script src="dist/js/waves.js"></script>
    <script src="dist/js/sidebarmenu.js"></script>
    <script src="dist/js/custom.min.js"></script>
    <script src="assets/libs/flot/excanvas.js"></script>
    <script src="assets/libs/flot/jquery.flot.js"></script>
    <script src="assets/libs/flot/jquery.flot.pie.js"></script>
    <script src="assets/libs/flot/jquery.flot.time.js"></script>
    <script src="assets/libs/flot/jquery.flot.stack.js"></script>
    <script src="assets/libs/flot/jquery.flot.crosshair.js"></script>
    <script src="assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="dist/js/pages/chart/chart-page-init.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            let notifications = document.getElementById('notifications')

            let form = new FormData();
            form.append('getNotifications', true);
            form.append('user', sessionStorage.getItem('userName'));

            let response = await fetch('handleApproval.php', {
                method: 'POST',
                body: form
            })

            let data = await response.json();

            for (let i = data.length - 1; i >= 0; i--) {
                let div = document.createElement('div');
                div.innerHTML = `<div class="msg-box" ${data[i]['viewed']==1?`style=${data[i]['status']==='rejected'?'background-color:#ffa1a1':'background-color:#6dffa5'}`:""}>
                        <div class="msg-hall-event">
                            <h3>Hall Name:${data[i]["hall"]}</h3>
                            <p>event Name:${data[i]['event']}</p>
                        </div>
                        <div class="msg-time-status">
                            <p>time:${data[i]['time']}</p>
                            <p style="background-color:${data[i]['status']==='approved'?'green':'red'}">status:${data[i]['status']}</p>
                        </div>
                        <div class="msg-reason">
                            <p>reason: ${data[i]['reason']}</p>
                        </div>
                    </div>`
                notifications.appendChild(div);
            }
        });
    </script>

</body>

</html>