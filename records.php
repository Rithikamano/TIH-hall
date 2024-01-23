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
    <!-- table to pdf  -->
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>

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
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
</head>

<body>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <div id="main-wrapper">
        <?php
        require "adminAside.php"
        ?>

        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <div class="table-nav">
                                <button class="btn btn-primary" id="downloadBtn">Download</button>

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


                                    $query = "SELECT * FROM booking where status='approved'";
                                    $query_run = mysqli_query($db, $query);
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
        document.getElementById("downloadBtn").addEventListener("click", function() {
            const element = document.getElementById("myTable");
            html2pdf(element);
            console.log("downloading...")
        });
    </script>
    <script>
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
                reloadTable()
            } else {
                alertify.set("notifier", "position", "top-right")
                alertify.error(data.message);
            }
        }
    </script>

    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        let data = <?php echo json_encode($query_run->fetch_all(MYSQLI_ASSOC)); ?>;

        // Function to populate the DataTable
        function populateDataTable(data) {
            let table = new DataTable('#myTable', {
                data: data,
                columns: [{
                        title: 'S.no',
                        data: 'id'
                    },
                    {
                        title: 'UserName',
                        data: 'user'
                    },
                    {
                        title: 'HallName',
                        data: 'hall'
                    },
                    {
                        title: 'Time',
                        data: 'time'
                    },
                    {
                        title: 'Event',
                        data: 'event'
                    },
                    {
                        title: 'Requirements',
                        data: 'req'
                    },
                    {
                        title: 'Action',
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return `<button class="btn btn-success" type="button" onclick="handleApproval(${data})" id="approveBtn" ${row['status']==='approved'?'disabled':''}>Approve</button>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#reasonModal" id="rejectBtn" data-id=${data}>Reject</button>`
                        }
                    }
                ]
            });
        }

        // Initial table population
        populateDataTable(data);
    </script>

    <script>
        async function reloadTable() {
            let reqbody = new FormData()
            reqbody.append('reload', true)
            reqbody.append("status", "approved")
            let req = await fetch("handleApproval.php", {
                method: "POST",
                body: reqbody
            })
            let data = await req.json()
            $('#myTable').DataTable().destroy();
            populateDataTable(data)
        }
    </script>


</body>

</html>