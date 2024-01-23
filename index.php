<?php
require 'config.php';


session_start();

$name = $_SESSION['user_name'];

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

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="sty.css">
    <style>
        img {
            border-radius: 20px;
            box-shadow: 12px 12px 12px rgba(0, 0, 0, 0.2);
            animation: fadeIn 2s ease-in-out;
            border: 2px solid black;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .icon-button {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            color: #333333;
            background: #dddddd;
            border: none;
            outline: none;
            border-radius: 50%;
        }

        .icon-button:hover {
            cursor: pointer;
        }

        .icon-button:active {
            background: #cccccc;
        }

        .icon-button__badge {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 25px;
            height: 25px;
            background: red;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div id="main-wrapper">

        <?php
        require "aside.php"
        ?>

        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <div style="display: flex;justify-content:flex-end">
                                <a>
                                    <button type="button" class="icon-button" id="notificationBtn">

                                        <span class="material-icons">notifications</span>
                                        <span class="icon-button__badge" id="notificationCount">
                                            <?php
                                            $query = "SELECT * FROM notifications WHERE user = '$name'  AND viewed=1";
                                            $result = mysqli_query($db, $query);
                                            $count = mysqli_num_rows($result);
                                            echo $count;
                                            ?>
                                        </span>
                                    </button>
                                </a>

                            </div>
                            <div class='px-3'>
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center col-auto pb-md-0 pb-3">
                                        <!-- Column for the image -->
                                        <img src="assets/images/Valluvar.jpg" width="250" height="150">
                                    </div>
                                    <div class="col-md-6 col-sm-auto pb-md-0 pb-3">
                                        <h3>Valluvar Hall</h3> <br>
                                        <h5>IN APJ BLOCK</h5>
                                        <!-- Column for the content (text) -->

                                        <div class="lead text-dark">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center col-sm-auto pb-md-0 pb-3">
                                        <!-- Column for the button -->
                                        <button type="submit" class="btn btn-outline-success  btn-rounded shadow  px-5 font-weight-bold yeahbutton" name="book" hallName="Valluvar Hall" onclick="book(this)">Book Now.!</button>
                                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                        <br>
                                    </div>
                                </div>

                                <hr class="hr  ">


                            </div>
                            <div class='px-3'>
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center col-auto pb-md-0 pb-3">
                                        <!-- Column for the image -->
                                        <img src="assets/images/Bharathiyar Hall.jpg" width="250" height="150">
                                    </div>
                                    <div class="col-md-6 col-sm-auto pb-md-0 pb-3">
                                        <h3>Bharathiyar Hall</h3> <br>
                                        <h5>IN APJ BLOCK</h5>
                                        <div class="lead text-dark">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center col-sm-auto pb-md-0 pb-3">
                                        <!-- Column for the button -->
                                        <button type="submit" class="btn btn-outline-success  btn-rounded shadow  px-5 font-weight-bold yeahbutton" name="book" hallName="Bharathiyar Hall" onclick="book(this)">Book Now.!</button>
                                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                        <br>
                                    </div>
                                </div>

                                <hr class="hr  ">


                            </div>
                            <div class='px-3'>
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center col-auto pb-md-0 pb-3">
                                        <!-- Column for the image -->
                                        <img src="assets/images/Sir C.V. Raman Hall.jpg" width="250" height="150">
                                    </div>
                                    <div class="col-md-6 col-sm-auto pb-md-0 pb-3">
                                        <h3>Sir C.V. Raman Hall</h3> <br>
                                        <h5>IN APJ BLOCK</h5>
                                        <!-- Column for the content (text) -->

                                        <div class="lead text-dark">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center col-sm-auto pb-md-0 pb-3">
                                        <!-- Column for the button -->
                                        <button type="submit" class="btn btn-outline-success  btn-rounded shadow  px-5 font-weight-bold yeahbutton" name="book" hallName="Sir C.V. Raman Hall" onclick="book(this)">Book Now.!</button>
                                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                        <br>
                                    </div>
                                </div>

                                <hr class="hr  ">


                            </div>
                            <div class='px-3'>
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center col-auto pb-md-0 pb-3">
                                        <!-- Column for the image -->
                                        <img src="assets/images/G.D. Naidu Hall.jpg" width="250" height="150">
                                    </div>
                                    <div class="col-md-6 col-sm-auto pb-md-0 pb-3">
                                        <!-- Column for the content (text) -->
                                        <h3>G.D. Naidu Hall</h3> <br>
                                        <h5>IN APJ BLOCK</h5>
                                        <div class="lead text-dark">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center col-sm-auto pb-md-0 pb-3">
                                        <!-- Column for the button -->
                                        <button type="submit" class="btn btn-outline-success  btn-rounded shadow  px-5 font-weight-bold yeahbutton" name="book" hallName="G.D. Naidu Hall" id="GD-book" onclick="book(this)">Book Now.!</button>
                                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                        <br>
                                    </div>
                                </div>

                                <hr class="hr  ">


                            </div>
                            <div class='px-3'>
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center col-auto pb-md-0 pb-3">
                                        <!-- Column for the image -->
                                        <img src="assets/images/Ramanujan Hall.jpg" width="250" height="150">
                                    </div>
                                    <div class="col-md-6 col-sm-auto pb-md-0 pb-3">
                                        <!-- Column for the content (text) -->
                                        <h3>Ramanujan Hall</h3> <br>
                                        <h5>IN APJ BLOCK</h5>
                                        <div class="lead text-dark">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center col-sm-auto pb-md-0 pb-3">
                                        <!-- Column for the button -->
                                        <button type="submit" class="btn btn-outline-success  btn-rounded shadow  px-5 font-weight-bold yeahbutton" name="book" hallName="Ramanujan Hall" onclick="book(this)">Book Now.!</button>
                                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                        <br>
                                    </div>
                                </div>

                                <hr class="hr  ">


                            </div>
                            <div class='px-3'>
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center col-auto pb-md-0 pb-3">
                                        <!-- Column for the image -->
                                        <img src="assets/images/Visvesvaraya Hall.jpg" width="250" height="150">
                                    </div>
                                    <div class="col-md-6 col-sm-auto pb-md-0 pb-3">
                                        <!-- Column for the content (text) -->
                                        <h3>Visvesvaraya Hall</h3> <br>
                                        <h5>IN APJ BLOCK</h5>
                                        <div class="lead text-dark">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center col-sm-auto pb-md-0 pb-3">
                                        <!-- Column for the button -->
                                        <button type="submit" class="btn btn-outline-success  btn-rounded shadow  px-5 font-weight-bold yeahbutton" name="book" hallName="Visvesvaraya Hall" onclick="book(this)">Book Now.!</button>
                                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                        <br>
                                    </div>
                                </div>

                                <hr class="hr  ">


                            </div>
                            <div class='px-3'>
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center col-auto pb-md-0 pb-3">
                                        <!-- Column for the image -->
                                        <img src="assets/images/Visvesvaraya Hall.jpg" width="250" height="150">
                                    </div>
                                    <div class="col-md-6 col-sm-auto pb-md-0 pb-3">
                                        <!-- Column for the content (text) -->
                                        <h3>Vivekananda Hall</h3> <br>
                                        <h5>IN APJ BLOCK</h5>
                                        <div class="lead text-dark">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center col-sm-auto pb-md-0 pb-3">
                                        <!-- Column for the button -->
                                        <button type="submit" class="btn btn-outline-success  btn-rounded shadow  px-5 font-weight-bold yeahbutton" name="book" hallName="Vivekananda Hall" onclick="book(this)">Book Now.!</button>
                                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                        <br>
                                    </div>
                                </div>

                                <hr class="hr  ">


                            </div>
                            <div class='px-3'>
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center col-auto pb-md-0 pb-3">
                                        <!-- Column for the image -->
                                        <img src="assets/images/Visvesvaraya Hall.jpg" width="250" height="150">
                                    </div>
                                    <div class="col-md-6 col-sm-auto pb-md-0 pb-3">
                                        <!-- Column for the content (text) -->
                                        <h3>Valluvar Hall</h3> <br>
                                        <h5>IN APJ BLOCK</h5>
                                        <div class="lead text-dark">
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center col-sm-auto pb-md-0 pb-3">
                                        <!-- Column for the button -->
                                        <button type="submit" class="btn btn-outline-success  btn-rounded shadow  px-5 font-weight-bold yeahbutton" name="book" hallName="Valluvar Hall" onclick="book(this)">Book Now.!</button>
                                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                        <br>
                                    </div>
                                </div>

                                <hr class="hr  ">


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        // sessionStorage.setItem("userName", "Mukesh")

        function book(button) {

            let hallNAme = button.getAttribute("hallName");
            var sendData = {
                hallName: hallNAme,
                userName: sessionStorage.getItem("userName")
            };

            // Convert the data to a JSON string and encode it for URL
            sessionStorage.setItem("hallData", JSON.stringify(sendData));

            // Redirect to the receiver page with the data as a URL parameter
            window.location.href = "integrate.php";
        }
    </script>
    <script>
        document.getElementById("notificationBtn").addEventListener('click', async (e) => {
            let reqBody = new FormData()
            reqBody.append('notify', true)
            reqBody.append('userName', "<?php echo $name ?>")
            let res = await fetch("handleApproval.php", {
                method: "POST",
                body: reqBody
            })
            let data = await res.json()

            console.log(data)

            function displayNotifications(index) {
                if (index < data.length) {
                    alertify.notify(data[index], 'success', 1, function() {
                        // Callback function to display the next notification after the delay
                        displayNotifications(index + 1);
                    });
                }
            }

            alertify.set('notifier', 'position', 'top-right');
            displayNotifications(0);
            document.getElementById("notificationCount").innerText = '0'
        })
    </script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
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

</body>

</html>