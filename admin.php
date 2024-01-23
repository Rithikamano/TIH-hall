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
$allowed_roles = ['admin'];
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
        .table-nav {
            margin-bottom: 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 7px;
        }

        .table-nav button {
            margin: 10px;
        }

        .table-nav select {
            margin: 10px;
        }

        .table-nav p {
            margin: 10px;
        }
    </style>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
</head>

<body>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <div id="main-wrapper">
        <?php
        require "aside.php"
        ?>

        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <div class="table-nav">
                                <form style="display: flex;" id="filterForm">
                                    <p><b>Filter by :</b></p>
                                    <select class="form-select" id="hallSelect" name="hall">
                                        <option selected value="Valluvar Hall">Hall Name</option>
                                        <option value="Valluvar Hall">Valluvar Hall</option>
                                        <option value="Bharathiyar Hall">Bharathiyar Hall</option>
                                        <option value="Sir C.V. Raman Hall">Sir C.V. Raman Hall</option>
                                        <option value="G.D. Naidu Hall">G.D. Naidu Hall</option>
                                        <option value="Ramanujan Hall">Ramanujan Hall</option>
                                        <option value="Visvesvaraya Hall">Visvesvaraya Hall</option>
                                        <option value="Vivekananda Hall">Vivekananda Hall</option>
                                    </select>
                                    <select class="form-select" id="statusSelect" name="status">
                                        <option selected value="requested">Status</option>
                                        <option value="approved">Approved</option>
                                        <option value="requested">Requested</option>
                                    </select>
                                    <button class="btn btn-secondary" type="submit" id="filterBtn">Filter</button>
                                </form>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="reasonModal" tabindex="-1" role="dialog" aria-labelledby="reasonModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="reasonModalLabel">Enter Reason</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="text" class="form-control" id="reasonInput" placeholder="Enter reason">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="submitReason">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- table -->
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><b>S.no</b></th>
                                        <th><b>UserName</b></th>
                                        <th><b>HallName</b></th>
                                        <th><b>Time</b></th>
                                        <th><b>Event</b></th>
                                        <th><b>Requirements</b></th>

                                        <th align="center"><b>Action</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php


                                    $query = "SELECT * FROM booking where status='requested'";
                                    $query_run = mysqli_query($db, $query);

                                    if (mysqli_num_rows($query_run) > 0) {
                                        $sn = 1;
                                        foreach ($query_run as $row) {

                                    ?>
                                            <tr>
                                                <td><?= $sn ?></td>
                                                <td><?= $row['user'] ?></td>
                                                <td><?= $row['hall'] ?></td>
                                                <td><?= $row['time'] ?></td>
                                                <td><?= $row['event'] ?></td>
                                                <td><?= $row['req'] ?></td>
                                                <td>
                                                    <button class="btn btn-success" type="button" onclick="handleApproval(<?= $row['id']; ?>)" id="approveBtn">Approve</button>
                                                    <!-- <button class="btn btn-danger" type="button" onclick="handleRejection(<?= $row['id']; ?>)" id="rejectBtn">Reject</button> -->
                                                    <button class="btn btn-danger" data-toggle="modal" data-target="#reasonModal" id="rejectBtn" data-id=<?= $row['id'] ?>>Reject</button>
                                                </td>
                                            </tr>
                                    <?php
                                            $sn = $sn + 1;
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
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
        async function handleApproval(id) {

            let form = new FormData()
            form.append('approve', true)
            form.append('id', id)
            const response = await fetch('handleApproval.php', {
                method: 'POST',
                body: form

            });
            const data = await response.json();
            console.log(data);
            if (data.status == 200) {
                alertify.set("notifier", "position", "top-right")
                alertify.success(data.message);
                $('#myTable').load(location.href + " #myTable");
            } else {
                alertify.set("notifier", "position", "top-right")
                alertify.error(data.message);
            }
        }

        let id;
        $('#reasonModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget); // Button that triggered the modal
            id = button.data('id'); // Extract ID from data-id attribute

        });


        document.getElementById("submitReason").addEventListener("click", function() {
            const reason = document.getElementById("reasonInput").value;
            handleRejection(id, reason);
            $('#reasonModal').modal('hide');
        });

        async function handleRejection(id, reason) {

            let form = new FormData()
            form.append('reject', true)
            form.append('id', id)
            form.append('reason', reason)
            const response = await fetch('handleApproval.php', {
                method: 'POST',
                body: form

            });
            const data = await response.json();
            console.log(data);
            if (data.status == 200) {
                alertify.set("notifier", "position", "top-right")
                alertify.success(data.message);
                $('#myTable').load(location.href + " #myTable");
            } else {
                alertify.set("notifier", "position", "top-right")
                alertify.error(data.message);
            }
        }
    </script>

    <script>
        let table = document.getElementById("myTable");

        let tbody = table.getElementsByTagName("tbody")[0];

        document.getElementById("filterForm").addEventListener('submit', async function(e) {
            e.preventDefault();

            while (tbody.firstChild) {
                tbody.removeChild(tbody.firstChild);
            }

            let formData = new FormData(this);
            formData.append('filter', true)
            let response = await fetch('handleApproval.php', {
                method: 'POST',
                body: formData
            })
            let data = await response.json();
            let sNo = 1;

            console.log(data)

            if (data.length < 1) {
                tbody.innerHTML = "<p>No records fond</p>"
                return;
            }

            for (let row of data) {
                let tr = document.createElement('tr')
                let td1 = document.createElement('td')
                td1.textContent = sNo;
                tr.appendChild(td1)
                sNo += 1;
                let td2 = document.createElement('td')
                td2.textContent = row['user']
                tr.appendChild(td2);
                let td3 = document.createElement('td')
                td3.textContent = row['hall']
                tr.appendChild(td3);
                let td4 = document.createElement('td')
                td4.textContent = row['time']
                tr.appendChild(td4);
                let td5 = document.createElement('td')
                td5.textContent = row['event']
                tr.appendChild(td5);
                let td6 = document.createElement('td')
                td6.textContent = row['req']
                tr.appendChild(td6);

                // let td7 = document.createElement('td')
                let newCell = tr.insertCell()
                newCell.innerHTML = `  <button class="btn btn-success" type="button" onclick="handleApproval(${row['id']})" id="approveBtn" ${row['status']==='approved'?'disabled':''}>Approve</button>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#reasonModal" id="rejectBtn" data-id=${row['id']}>Reject</button>`


                tbody.appendChild(tr)

            }
        })
    </script>

</body>

</html>