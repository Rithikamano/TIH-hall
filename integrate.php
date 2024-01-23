<?php

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />

    <style>
        td {
            cursor: pointer;
        }

        .month {
            border: 1px solid black;
            padding: 5px;
            width: 80px;
            height: 100px;
            text-align: center;
        }

        .th {
            padding: 25px;
        }

        td {
            user-select: none;
        }

        .mon-cal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: black;
            color: white;
            padding: 15px;
        }

        #prevMonth,
        #nextMonth {
            background-color: transparent;
            color: white;
            border: none;
            cursor: pointer;
        }


        table {
            border: 1px solid #ccc;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
            width: 100%;
            table-layout: fixed;
        }

        .day-cal {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .day-cal td {
            border-left: 1px solid #ddd;
        }

        .day-cal-table {
            width: 100%;
            border-collapse: collapse;
        }

        .day-cal-table th {
            background-color: black;
            color: #fff;
            padding: 10px;
            text-align: center;
        }



        .day-cal-table td {
            text-align: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .day-cal-table tr:last-child td {
            border-bottom: none;
        }

        .alertDialog {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 450px;
            height: 550px;
            align-items: center;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 10px;
            display: none;
            z-index: 2;
        }

        .dialog-head {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }

        .dialog-body {
            padding: 0px 15px 0px 15px;

        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
            /* Place overlay above other elements */
        }
    </style>

</head>

<body>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <div class="overlay"></div>
    <div id="main-wrapper">

        <?php
        require "aside.php"
        ?>

        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div>

                            <div class="seven" style="display: flex;justify-content:space-between">
                                <h1 id="hallTitle"></h1>
                            </div>
                            <div class="mon-cal" id="monCal" style="background-color: #fff;">
                                <div class="mon-cal-header">
                                    <button id="prevMonth">Previous</button>
                                    <h2 id="monthName">October 2023</h2>
                                    <button id="nextMonth">Next</button>
                                </div>
                                <table id="mon-table">
                                    <thead id="mon-table-header">
                                        <tr>
                                            <th class="th">sunday</th>
                                            <th class="th">Monday</th>
                                            <th class="th">Tuesday</th>
                                            <th class="th">Wednesday</th>
                                            <th class="th">Thursday</th>
                                            <th class="th">Friday</th>
                                            <th class="th">Saturday</th>
                                        </tr>
                                    </thead>
                                    <tbody id="monTableBody">
                                        <tr class="mon-table-body-row">
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                        </tr>
                                        <tr class="mon-table-body-row">
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                        </tr>
                                        <tr class="mon-table-body-row">
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                        </tr>
                                        <tr class="mon-table-body-row">
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                        </tr>
                                        <tr class="mon-table-body-row">
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                            <td class="month"></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div id="selectedCellInfo"></div>
                                <div style="display:flex;justify-content:end">
                                    <button class="btn btn-secondary" onclick="toggleDayCal()" style="padding: 10px 20px;margin:5px">Select</button>
                                </div>
                            </div>

                            <div class="day-cal" id="dayCal" style="display: none;">
                                <div style="display: flex;justify-content:space-between">
                                    <button class="btn btn-secondary" style="padding: 10px 20px;margin:5px" onclick="toggleMonCal()">Go back</button>
                                    <button class="btn btn-secondary" style="padding: 10px 20px;margin:5px" type="button" id="bookbtn">Book Now</button>
                                </div>
                                <table class="day-cal-table" id="dayTable">
                                    <thead class="day-table-head">
                                        <tr id="dayTableHeadRow">
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dayTableBody">
                                        <!-- <tr>
                                            <td>12 AM - 1 AM</td>
                                        </tr>
                                        <tr>
                                            <td>1 AM - 2 AM</td>
                                        </tr>
                                        <tr>
                                            <td>2 AM - 3 AM</td>
                                        </tr>
                                        <tr>
                                            <td>3 AM - 4 AM</td>
                                        </tr>
                                        <tr>
                                            <td>4 AM - 5 AM</td>
                                        </tr> -->
                                        <tr>
                                            <td>5 AM - 6 AM</td>
                                        </tr>
                                        <tr>
                                            <td>6 AM - 7 AM</td>
                                        </tr>
                                        <tr>
                                            <td>7 AM - 8 AM</td>
                                        </tr>
                                        <tr>
                                            <td>8 AM - 9 AM</td>
                                        </tr>
                                        <tr>
                                            <td>9 AM - 10 AM</td>
                                        </tr>
                                        <tr>
                                            <td>10 AM - 11 AM</td>
                                        </tr>
                                        <tr>
                                            <td>11 AM - 12 PM</td>
                                        </tr>
                                        <tr>
                                            <td>12 PM - 1 PM</td>
                                        </tr>
                                        <tr>
                                            <td>1 PM - 2 PM</td>
                                        </tr>
                                        <tr>
                                            <td>2 PM - 3 PM</td>
                                        </tr>
                                        <tr>
                                            <td>3 PM - 4 PM</td>
                                        </tr>
                                        <tr>
                                            <td>4 PM - 5 PM</td>
                                        </tr>
                                        <tr>
                                            <td>5 PM - 6 PM</td>
                                        </tr>
                                        <tr>
                                            <td>6 PM - 7 PM</td>
                                        </tr>
                                        <tr>
                                            <td>7 PM - 8 PM</td>
                                        </tr>
                                        <!-- <tr>
                                            <td>8 PM - 9 PM</td>
                                        </tr>
                                        <tr>
                                            <td>9 PM - 10 PM</td>
                                        </tr>
                                        <tr>
                                            <td>10 PM - 11 PM</td>
                                        </tr>
                                        <tr>
                                            <td>11 PM - 12 AM</td>
                                        </tr> -->
                                    </tbody>
                                </table>
                                <div id="selectedCellInfo1">

                                </div>


                                <div class="alertDialog" id="alertDialog">
                                    <div class="dialog-head">
                                        <h2>Hall Booking</h2>
                                    </div>
                                    <div class="dialog-body">
                                        <div id="hallData"></div>
                                        <form id="myForm">
                                            <div class="" style="margin-bottom:20px;margin-top:40px;">
                                                <label for="eventLabel" class="form-label" style="font-size: 20px;">Event :</label>
                                                <input type=" text" class="form-control" id="eventLabel" placeholder="Enter event name" name="eventName" required>
                                            </div>
                                            <div class="">
                                                <label for="micType" class="form-label" style="font-size: 20px;">Mic Type :</label>
                                                <br><br>
                                                <select class="form-select" id="micType" name="micType" style="padding: 5px;" required>
                                                    <option value="">Select</option>
                                                    <option value="wired">Wired Mic</option>
                                                    <option value="wireless">Wireless Mic</option>
                                                    <option value="mic">Podium Mic</option>
                                                </select>
                                            </div>
                                            <div style="margin-top: 90px;">
                                                <button class="btn btn-success" type="submit" id="submitButton">Submit</button>
                                                <button class="btn btn-danger" type="button" id="closeBtn">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="dialog-footer">
                                    </div>

                                </div>

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
        document.getElementById("hallTitle").textContent = JSON.parse(sessionStorage.getItem("hallData")).hallName
    </script>

    <script>
        class CustomTime {

            static expand(time) {
                let t = {
                    "5AM": "5AM-6AM",
                    "6AM": "6AM-7AM",
                    "7AM": "7AM-8AM",
                    "8AM": "8AM-9AM",
                    "9AM": "9AM-10AM",
                    "10AM": "10AM-11AM",
                    "11AM": "11AM-12PM",
                    "12PM": "12PM-1PM",
                    "1PM": "1PM-2PM",
                    "2PM": "2PM-3PM",
                    "3PM": "3PM-4PM",
                    "4PM": "4PM-5PM",
                    "5PM": "5PM-6PM",
                    "6PM": "6PM-7PM",
                    "7PM": "7PM-8PM",
                    "8PM": "8PM-9PM"
                }


                let keys = Object.keys(t)

                let from = time.split("-")[0]
                let to = time.split("-")[1]

                let range = []

                let start = keys.indexOf(from)
                let end = keys.indexOf(to) - 1;
                for (let i = start; i <= end; i++) {
                    range.push(t[keys[i]])
                }

                return range;

            }

            static findContinuous(time) {
                let start = time[0].split("-")[0]
                let end;
                let continuous = []
                for (let i = 0; i < time.length; i++) {
                    try {
                        if (time[i].split("-")[1] != time[i + 1].split("-")[0]) {
                            end = time[i].split("-")[1]
                            continuous.push(`${start}-${end}`)
                            start = time[i + 1].split("-")[0]
                        }
                    } catch (e) {
                        end = time[i].split("-")[1]
                        continuous.push(`${start}-${end}`)
                    }
                }
                return continuous;
            }

            static sort(times) {
                let t = ["5AM-6AM", "6AM-7AM", "7AM-8AM", "8AM-9AM", "9AM-10AM", "10AM-11AM", "11AM-12PM", "12PM-1PM", "1PM-2PM", "2PM-3PM", "3PM-4PM", "4PM-5PM", "5PM-6PM", "6PM-7PM", "7PM-8PM", ]
                let sorted = []
                for (let i = 0; i < t.length; i++) {
                    if (times.includes(t[i]))
                        sorted.push(t[i])
                }
                return sorted;
            }

            static group(selectedTimes) {
                let group = {}
                for (let i = 0; i < selectedTimes.length; i++) {
                    let string = selectedTimes[i].replace(/ /g, "")
                    let data = string.split("|")
                    let date = data[1]
                    let time = data[0]
                    if (group[date]) {
                        group[date].push(time)
                    } else {
                        group[date] = [time]
                    }
                }

                let keys = Object.keys(group)

                for (let key of keys) {
                    group[key] = this.findContinuous(this.sort(group[key]))

                }

                return group;
            }
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const prevMonthButton = document.getElementById("prevMonth");
            const nextMonthButton = document.getElementById("nextMonth");
            const currentMonthHeader = document.getElementById("monthName");


            let currentDate = new Date();
            displayCalendar(currentDate);

            prevMonthButton.addEventListener("click", function() {
                currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 1);
                displayCalendar(currentDate);
            });

            // Event listener for next month button
            nextMonthButton.addEventListener("click", function() {
                currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);
                displayCalendar(currentDate);
            });

            function displayCalendar(date) {
                const monthOptions = {
                    year: "numeric",
                    month: "long"
                };
                currentMonthHeader.textContent = date.toLocaleDateString(undefined, monthOptions);

                if (selectedCells.length > 0) {
                    selectedCells.forEach(cell => {
                        cell.style.backgroundColor = 'white';
                    });
                    selectedCells.length = 0
                    updateSelectedCellInfo()
                }

                var table = document.getElementById("mon-table");
                var tbody = table.getElementsByTagName("tbody")[0];

                for (var i = 0, row; row = tbody.rows[i]; i++) {
                    for (var j = 0, cell; cell = row.cells[j]; j++) {
                        cell.innerHTML = ""
                        cell.setAttribute('data-time', '');
                        cell.setAttribute('selected', 'false')
                    }
                }


                // Create a new date object for the first day of the month
                const firstDayOfMonth = new Date(date.getFullYear(), date.getMonth(), 1);

                // Get the number of days in the month
                const daysInMonth = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();

                // Determine the day of the week for the first day of the month (0 = Sunday, 1 = Monday, etc.)
                const firstDayOfWeek = firstDayOfMonth.getDay();

                let d = new Date(date.getFullYear(), date.getMonth(), 1);
                let n = 1;
                for (var i = 0, row; row = tbody.rows[i]; i++) {
                    for (var j = 0, cell; cell = row.cells[j]; j++) {
                        if (i == 0 && j < firstDayOfWeek) {
                            continue;
                        }
                        if (n <= daysInMonth) {
                            d.setDate(d.getDate() + 1);
                            cell.innerHTML = n;
                            cell.setAttribute('data-time', d.toISOString().slice(0, 10));
                            cell.setAttribute('selected', 'false')

                            n++;
                        } else {
                            break;
                        }
                    }
                }

            }

        });
    </script>


    <script>
        const selectedCells = [];
        const cells = document.querySelectorAll('.month');
        const selectedCellInfo = document.getElementById('selectedCellInfo');
        let isMouseDown = false;

        function handleMouseDown(cell) {
            isMouseDown = true
            cell.getAttribute('selected') === 'false' ? cell.setAttribute('selected', true) : cell.setAttribute('selected', false);
            if (cell.getAttribute('selected') === 'true' && cell.getAttribute('data-time')) {
                selectedCells.push(cell);
                cell.style.backgroundColor = 'lightblue';
            } else if (cell.getAttribute('data-time')) {
                let i = selectedCells.indexOf(cell);
                selectedCells.splice(i, 1);
                cell.style.backgroundColor = '#fff';
            }
            updateSelectedCellInfo();
        }

        function handleMouseOver(cell) {
            if (!isMouseDown) return;
            if (cell.getAttribute('selected') === 'false' && !selectedCells.includes(cell) && cell.getAttribute('data-time')) {
                selectedCells.push(cell);
                cell.style.backgroundColor = 'lightblue';
                cell.style.boxShadow = "rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;"
                cell.setAttribute('selected', 'true')
                updateSelectedCellInfo();
            } else if (cell.getAttribute('data-time')) {
                let i = selectedCells.indexOf(cell);
                selectedCells.splice(i, 1);
                cell.style.backgroundColor = '#fff';
                cell.setAttribute('selected', 'false')
                updateSelectedCellInfo();
            }
        }

        function handleMouseUp(cell) {
            isMouseDown = false;


        }
        let selectedTimes = []

        function updateSelectedCellInfo() {
            selectedTimes = selectedCells.map(cell => cell.getAttribute('data-time'));
            selectedCellInfo.innerHTML = `Selected Time Range: ${selectedTimes.join(' - ')}`;
        }

        cells.forEach(cell => {
            cell.addEventListener('mousedown', () => {
                handleMouseDown(cell);
            });

            cell.addEventListener('mouseover', () => {
                handleMouseOver(cell);
            });

            cell.addEventListener('mouseup', () => {
                handleMouseUp(cell);
            });
        });
    </script>

    <script>
        function onSelectDate(date) {
            var table = document.getElementById("dayTable");

            // Iterate through each section of the table (thead and tbody)
            var sections = [table.tHead, table.tBodies[0]]; // Get the first tbody

            sections.forEach(function(section) {
                // Iterate through each row in the section
                for (var i = 0; i < section.rows.length; i++) {
                    // Get the current row
                    var row = section.rows[i];

                    // Iterate through each cell in the row (except the first one)
                    for (var j = row.cells.length - 1; j > 0; j--) {
                        // Remove the cell from the row
                        row.deleteCell(j);
                    }
                }
            });
            let headRow = document.getElementById("dayTableHeadRow")
            for (let i = 0; i < date.length; i++) {
                const th = document.createElement('th');
                // th.textContent = date[i];
                th.innerHTML = `<div><p>${date[i]}</p><input type="checkbox" class="dayColumn" index="${i+1}">select all</input></div>`
                headRow.appendChild(th);
            }

            let tableBody = document.getElementById("dayTableBody")
            for (var i = 0, row; row = tableBody.rows[i]; i++) {
                for (let j = 0; j < date.length; j++) {
                    const newCell = document.createElement('td');
                    newCell.className = 'day'
                    newCell.textContent = '';
                    row.appendChild(newCell)
                }
            }
        }

        // onSelectDate(['2023-10-06', '2023-10-07', '2023-10-08', '2023-10-09'])
    </script>
    <script>
        let selectedCells1 = [];
        async function toggleDayCal() {

            if (selectedTimes.length < 1) {
                alertify.set("notifier", "position", "top-center")
                alertify.error('Please select atleast one Date');
                return;
            }




            document.getElementById("monCal").style.display = 'none'
            document.getElementById("dayCal").style.display = 'block'
            onSelectDate(selectedTimes)



            const bookingData = await fetch("fetch.php", {
                method: "Post",
                body: JSON.stringify({
                    "selectedDate": selectedTimes,
                    "hallName": JSON.parse(sessionStorage.getItem("hallData")).hallName
                })
            }).then(res => res.json()).then((data) => {
                let expanded = []
                for (let row of data) {
                    // console.log(row.time.split("|")[0])
                    let times = CustomTime.expand(row.time.split("|")[0])

                    for (let time of times) {
                        expanded.push({
                            "time": `${time}|${row.time.split("|")[1]}`,
                            "user": row.user,
                            "status": row.status,
                            "event": row.event
                        })
                    }
                }
                return expanded;
            })

            // console.log(bookingData)

            function findObjectByTime(array, time) {
                for (const obj of array) {
                    if (obj.time === time) {
                        return obj; // Found the object with the desired time
                    }
                }
                return null; // If the object with the desired time is not found
            }

            let headRow = document.getElementById("dayTableHeadRow")
            const thElements = headRow.getElementsByTagName('th');
            let tbody = document.getElementById("dayTableBody")
            for (var i = 0, row; row = tbody.rows[i]; i++) {
                let data = row.cells[0].textContent;
                // console.log(data)
                for (var j = 1, cell; cell = row.cells[j]; j++) {

                    const foundObject = findObjectByTime(bookingData, `${data.replace(/ /g,"")}|${thElements[j].getElementsByTagName('p')[0].textContent}`);
                    if (foundObject) {
                        cell.setAttribute('data-userName', foundObject.user)
                        cell.setAttribute('data-status', foundObject.status)
                        cell.setAttribute('data-event', foundObject.event)
                        if (foundObject.status == 'requested')
                            cell.style.backgroundColor = '#e9eb7e';
                        if (foundObject.status == 'approved')
                            cell.style.backgroundColor = '#86e45b';
                        cell.style.borderBottom = "none";
                        cell.innerHTML = `<div><p>${foundObject.event}</p></div>`
                    }

                    cell.setAttribute('data-time', `${data}|${thElements[j].getElementsByTagName('p')[0].textContent}`);
                    cell.setAttribute('selected', 'false')
                }
            }

            const cells1 = document.querySelectorAll('.day');

            cells1.forEach(cell => {
                cell.addEventListener('mousedown', () => {
                    handleMouseDown1(cell);
                });

                cell.addEventListener('mouseover', () => {
                    handleMouseOver1(cell);
                });

                cell.addEventListener('mouseup', () => {
                    handleMouseUp1(cell);
                });
            });


            const columnCheckboxes = document.querySelectorAll('.dayColumn');
            columnCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', selectAll);
            });
        }

        function toggleMonCal() {
            selectedCells1 = []
            document.getElementById("dayCal").style.display = 'none'
            document.getElementById("monCal").style.display = 'block'
            // window.location.href = "integrate.php";

        }






        let selectedTimes1 = []
        let payload = {}




        const selectedCellInfo1 = document.getElementById('selectedCellInfo1');
        let isMouseDown1 = false;

        function handleMouseDown1(cell) {
            isMouseDown1 = true
            // cell.getAttribute('selected') === 'false' ? cell.setAttribute('selected', true) : cell.setAttribute('selected', false);
            if (!cell.getAttribute("data-status") && cell.getAttribute('selected') === 'false' && cell.getAttribute('data-time')) {
                selectedCells1.push(cell);
                cell.style.backgroundColor = 'lightblue';
                cell.style.boxShadow = "rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;"
                // cell.className = "shadow-lg p-3 mb-5 bg-body rounded"
                cell.style.borderBottom = "none";
                cell.setAttribute('selected', 'true')
            } else if (!cell.getAttribute("data-status")) {
                let i = selectedCells1.indexOf(cell);
                selectedCells1.splice(i, 1);
                cell.style.backgroundColor = 'white';
                cell.style.borderBottom = "1px solid #ddd";
                cell.setAttribute('selected', 'false')
            }
            updateSelectedCellInfo1();
        }

        function handleMouseOver1(cell) {
            if (!isMouseDown1) return;
            if (!cell.getAttribute("data-status") && cell.getAttribute('selected') === 'false' && !selectedCells1.includes(cell) && cell.getAttribute('data-time')) {
                selectedCells1.push(cell);
                cell.style.backgroundColor = 'lightblue';
                cell.style.boxShadow = "rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;"
                // cell.className = "shadow-lg p-3 mb-5 bg-body rounded"
                cell.style.borderBottom = "none";
                cell.setAttribute('selected', 'true')
                updateSelectedCellInfo1();
            } else if (!cell.getAttribute('data-status')) {
                let i = selectedCells1.indexOf(cell);
                selectedCells1.splice(i, 1);
                cell.style.backgroundColor = 'white';
                cell.style.borderBottom = "1px solid #ddd";
                cell.setAttribute('selected', 'false')
                updateSelectedCellInfo1();
            }
        }

        function handleMouseUp1(cell) {
            isMouseDown1 = false;

        }


        function updateSelectedCellInfo1() {
            selectedTimes1 = selectedCells1.map(cell => cell.getAttribute('data-time'));
            // selectedCellInfo1.innerHTML = `Selected Time Range: ${selectedTimes1.join(' * ')} ${selectedTimes1.length}`;
            console.log(CustomTime.group(selectedTimes1));
            payload = CustomTime.group(selectedTimes1);
        }





        function selectAll() {

            let tbody = document.getElementById("dayTableBody")
            let rows = tbody.getElementsByTagName("tr");
            if (this.checked) {
                for (let i = 0; i < rows.length; i++) {
                    let cell = rows[i].cells[parseInt(this.getAttribute('index'))];
                    if (cell.getAttribute("data-status")) continue;
                    // cell.getAttribute('selected') === 'false' ? cell.setAttribute('selected', true) : cell.setAttribute('selected', false);
                    if (cell.getAttribute('data-time') && !selectedCells1.includes(cell)) {
                        selectedCells1.push(cell);
                        cell.style.backgroundColor = 'lightblue';
                        cell.style.boxShadow = "rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;"
                        // cell.className = "shadow-lg p-3 mb-5 bg-body rounded"
                        cell.style.borderBottom = "none";
                        cell.setAttribute('selected', 'true')

                        updateSelectedCellInfo1();
                    }
                }
            } else {
                for (let i = 0; i < rows.length; i++) {
                    let cell = rows[i].cells[parseInt(this.getAttribute('index'))];
                    if (cell.getAttribute("data-status")) continue;
                    // cell.getAttribute('selected') === 'false' ? cell.setAttribute('selected', true) : cell.setAttribute('selected', false);
                    let ind = selectedCells1.indexOf(cell);
                    selectedCells1.splice(ind, 1);
                    cell.style.backgroundColor = 'white';
                    cell.style.borderBottom = "1px solid #ddd";
                    cell.setAttribute('selected', 'false')

                    updateSelectedCellInfo1();
                }
            }
        }


        // Retrieve the JSON data from session storage
        const jsonData = sessionStorage.getItem("hallData");

        if (jsonData) {
            const data = JSON.parse(jsonData);

            // Render the data on the page
            const outputDiv = document.getElementById("hallData");
            outputDiv.innerHTML = `<p><strong>Booked By:</strong> ${data.userName} <br><br></p><p><strong>Hall Name:</strong> ${data.hallName}</p>`;
        }

        const myForm = document.getElementById('myForm')

        myForm.addEventListener('submit', async function(e) {
            e.preventDefault(); // Prevent the default form submission behavior

            console.log("event")

            // Get the form data
            const formData = new FormData(this);

            // Create an array
            const myArray = [];

            let keeys = Object.keys(payload);

            for (let key of keeys) {
                let value = payload[key];
                for (let i = 0; i < value.length; i++) {
                    myArray.push(`${value[i]}|${key}`)
                }
            }



            const hallData = JSON.parse(sessionStorage.getItem("hallData"));

            formData.set('myArray', JSON.stringify(myArray));

            formData.set('userName', hallData.userName);
            formData.set('hallName', hallData.hallName);

            const url = 'book.php';

            formData.append("bookingRequest", true)

            try {
                const resData = await fetch(url, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())

                alertify.set("notifier", "position", "top-center")
                if (resData.status == '200')
                    alertify.success(resData.message);
                else if (resData.status == '500')
                    alertify.error(resData.message);
            } catch (error) {
                console.log(error)
            }
            selectedCells1 = []
            updateSelectedCellInfo1()
            closeModal()
            toggleDayCal()
        });





        // Get references to the modal and button
        const modal = document.getElementById('alertDialog');
        const openModalBtn = document.getElementById('bookbtn');
        const closeModalBtn = document.getElementById('closeBtn');
        const overlay = document.querySelector('.overlay');
        // Function to open the modal
        function openModal() {
            if (selectedTimes1.length < 1) {
                alertify.set("notifier", "position", "top-right")
                alertify.error('Please select atleast one time slot');
                return;
            }
            modal.style.display = 'block';
            overlay.style.display = 'block';
            // Disable scrolling on the body
            document.body.style.overflow = 'hidden';
        }

        // Function to close the modal
        function closeModal() {
            modal.style.display = 'none';
            overlay.style.display = 'none';
            // Enable scrolling on the body
            document.body.style.overflow = 'auto';
        }

        if (!openModalBtn.getAttribute("data-eventAdded") && !closeModalBtn.getAttribute("data-eventAdded") && !overlay.getAttribute("data-eventAdded")) {
            // Event listeners
            openModalBtn.addEventListener('click', openModal);
            closeModalBtn.addEventListener('click', closeModal);

            // Close the modal when clicking outside the modal content or on the overlay
            overlay.addEventListener('click', closeModal);
            openModalBtn.setAttribute("data-eventAdded", 'true')
            closeModalBtn.setAttribute("data-eventAdded", 'true')
            overlay.setAttribute("data-eventAdded", 'true')
        }
    </script>

</body>

</html>