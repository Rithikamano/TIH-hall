<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>
</head>

</html>
<?php
include("config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($db, $_POST['loginemail']);
    $password = mysqli_real_escape_string($db, $_POST['loginpassword']);
    $role = mysqli_real_escape_string($db, $_POST['radioOption']);

    $sql = "SELECT * FROM login WHERE userId = '$email' and pass = '$password' AND role = '$role'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $uName = $row['name'];

    $count = mysqli_num_rows($result);



    if ($count == 1) {
        $_SESSION['user_id'] = $row['userId'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['user_name'] = $row['name'];
        if ($role == "faculty") {
            $loc = "index.php";
        } else {
            $loc = "admin2.php";
        }
?>
        <script>
            swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Login Successful'
            }).then(function() {
                window.location = "<?php echo $loc ?>";
                sessionStorage.setItem("userName", "<?php echo $uName ?>")
            });
        </script>
    <?php
    } else {
    ?>
        <script>
            swal.fire({
                icon: 'error',
                title: 'Login Failure',
                text: 'Check login credentials'
            }).then(function() {
                window.location = "login.php";
            });
        </script>
<?php
    }
}




?>
<html dir="ltr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>MKCE Hall Booking</title>
</head>

<body style="background-color: #33363b;">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <div class="w-100 position-absolute top-0 bottom-0 " style="color: wheat;">
        <div class="position-absolute top-50 start-50 translate-middle rounded">
            <div class="container shadow " style="display: table-cell; vertical-align: middle;">
                <div class="row">
                    <div class="col">
                        <DIV class="d-flex align-items-center" style="margin-top:30px;justify-content:center">
                            <img src="assets/images/srms.png">
                        </DIV>
                        <!-- </div>
                    <div class="col"> -->
                        <form class="container login" action="#" method="post">
                            <label for="loginemail" class="form-label mt-3 mb-3">User Name</label>
                            <input type="text" class="form-control" placeholder="Enter your name" id="loginemail" name="loginemail" required>
                            <label for="loginpassword" class="form-label mt-3 mb-3">Password</label>
                            <input type="password" class="form-control" placeholder="Enter your password" id="loginpassword" name="loginpassword" required>
                            <div class="mt-3">
                                <span class="me-3">
                                    <input class="form-check-input" type="radio" name="radioOption" id="option1" value="faculty" checked>

                                    <label class="form-check-label" for="option2">
                                        faculty
                                    </label>
                                </span>
                                <span>
                                    <input class="form-check-input" type="radio" name="radioOption" id="option2" value="admin">
                                    <label class="form-check-label" for="option2">
                                        admin
                                    </label>
                                </span>
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary mt-3 mb-3" type="submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>