<?php
require_once "config.php";

$customer_id = $_REQUEST["id"];

$sql = "SELECT date_of_transaction, total_cost FROM transactions WHERE customer_id = $customer_id";

$sql2 = "SELECT first_name , last_name FROM customers WHERE id = $customer_id";

$sql3 = "SELECT id, address_street, address_number, city FROM stores";

if ($result2 = mysqli_query($link, $sql2)) {
    $row2 = mysqli_fetch_array($result2);
} else {
    header("location: error.php");
    exit();
}

if ($result3 = mysqli_query($link, $sql3)) {
    $row3 = mysqli_fetch_array($result3);
} else {
    header("location: error.php");
    exit();
}






$avg_cost_per_month = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$total_cost_per_month = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$total_months_frequency = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

$avg_cost_per_week = array(0, 0, 0, 0);
$total_cost_per_week = array(0, 0, 0, 0);
$total_weeks_frequency = array(0, 0, 0, 0);

if ($result = mysqli_query($link, $sql)) {
    $row = mysqli_fetch_array($result);
} else {
    header("location: error.php");
    exit();
}

do {
    $dateExploded = explode("-", $row["date_of_transaction"]);
    if (count($dateExploded) == 3) {
        $day = $dateExploded[2];
        if ($day >= 1 && $day <= 8) {
            $total_weeks_frequency[0] += 1;
            $total_cost_per_week[0] += $row["total_cost"];
        } elseif ($day <= 15) {
            $total_weeks_frequency[1] += 1;
            $total_cost_per_week[1] += $row["total_cost"];
        } elseif ($day <= 23) {
            $total_weeks_frequency[2] += 1;
            $total_cost_per_week[2] += $row["total_cost"];
        } else {
            $total_weeks_frequency[3] += 1;
            $total_cost_per_week[3] += $row["total_cost"];
        }
        $month = $dateExploded[1];
        $total_months_frequency[$month - 1] += 1;
        $total_cost_per_month[$month - 1] += $row["total_cost"];
    }
} while ($row = mysqli_fetch_array($result));

//months
for ($x = 0; $x < 12; $x++) {
    if ($total_months_frequency[$x] != 0)
        $avg_cost_per_month[$x] = $total_cost_per_month[$x] / $total_months_frequency[$x];
    else
        $avg_cost_per_month[$x] = 0;
}
//weeks
for ($x = 0; $x < 4; $x++) {
    if ($total_weeks_frequency[$x] != 0)
        $avg_cost_per_week[$x] = $total_cost_per_week[$x] / $total_weeks_frequency[$x];
    else
        $avg_cost_per_week[$x] = 0;
}
?>


<!DOCTYPE html>
<html lang="en-US">
    <body>
        <h2 style="text-align: center">Charts for : <?php echo $row2["first_name"] . " " . $row2["last_name"]; ?></h2>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {packages: ['corechart']});
            google.charts.setOnLoadCallback(drawChartMonths);
            google.charts.setOnLoadCallback(drawChartWeeks);
            function drawChartMonths() {
                var data = google.visualization.arrayToDataTable([
                    ["Month", "Average Cost", {role: "style"}],
                    ["January",<?php echo $avg_cost_per_month[0] ?>, "cadetblue"],
                    ["February", <?php echo $avg_cost_per_month[1] ?>, "teal"],
                    ["March", <?php echo $avg_cost_per_month[2] ?>, "darkgreen"],
                    ["April", <?php echo $avg_cost_per_month[3] ?>, "darkrodenrod"],
                    ["May", <?php echo $avg_cost_per_month[4] ?>, "darksalmon"],
                    ["June", <?php echo $avg_cost_per_month[5] ?>, "silver"],
                    ["July", <?php echo $avg_cost_per_month[6] ?>, "green"],
                    ["August", <?php echo $avg_cost_per_month[7] ?>, "mediumpurple"],
                    ["September", <?php echo $avg_cost_per_month[8] ?>, "indianred"],
                    ["October", <?php echo $avg_cost_per_month[9] ?>, "lightseagreen"],
                    ["November", <?php echo $avg_cost_per_month[10] ?>, "olive"],
                    ["December", <?php echo $avg_cost_per_month[11] ?>, "maroon"]

                ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                    {calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation"},
                    2]);

                var options = {
                    title: "Average cost of transactions per month",
                    width: 1500,
                    height: 400,
                    bar: {groupWidth: "95%"},
                    legend: {position: "none"},
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values_month"));
                chart.draw(view, options);
            }

            function drawChartWeeks() {
                var data = google.visualization.arrayToDataTable([
                    ["Weeks", "Average Cost", {role: "style"}],
                    ["First Week(1-8)",<?php echo $avg_cost_per_week[0] ?>, "cadetblue"],
                    ["Second Week(9-15)", <?php echo $avg_cost_per_week[1] ?>, "teal"],
                    ["Third Week(16-23)", <?php echo $avg_cost_per_week[2] ?>, "darkgreen"],
                    ["Fourth Week(24-31)", <?php echo $avg_cost_per_week[3] ?>, "darkrodenrod"]
                ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                    {calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation"},
                    2]);

                var options = {
                    title: "Average cost of transactions per week",
                    width: 1500,
                    height: 400,
                    bar: {groupWidth: "40%"},
                    legend: {position: "none"},
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values_week"));
                chart.draw(view, options);
            }

        </script>
        <div id="columnchart_values_month" style="width: 900px; height: 300px;"></div>
        <br><br><br><br><br><br><br>
        <div id="columnchart_values_week" style="width: 900px; height: 300px;"></div>
        <br><br><br><br><br><br><br>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            .wrapper{
                width: 500px;
                margin: 0 auto;
            }
        </style>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class='wrapper'>
                        <h3>Choose store</h3>
                        <?php echo "<form action='charts-customers.php?id=" . $customer_id . "' method='post'>"; ?>    

                        <label for="store_id">Stores</label>
                        <select type="number" name="store_id" class="form-control">
                            <?php
                            do {
                                echo '<option value = "' . $row3['id'] . '">' . $row3['city'] . ' ' . $row3['address_street'] . ' ' . $row3['address_number'] . '</option>' . '</td>';
                            } while ($row3 = mysqli_fetch_array($result3));
                            ?>
                        </select>
                        <br>
                        <input type = "submit" class="btn btn-primary" value = "Search">
                        </form>


                        <?php
                        require_once "config.php";

                        if (!empty($_POST['store_id'])) {
                            $store_id = $_POST["store_id"];
                            $sql4 = "SELECT date_of_transaction FROM transactions WHERE customer_id = '$customer_id' AND store_id = '$store_id'";


                            if (!$result4 = mysqli_query($link, $sql4)) {
                                header("location: error.php");
                                exit();
                            }

                            $total_hours_frequency = array(0, 0, 0, 0);

                            //hours
                            while ($row4 = mysqli_fetch_array($result4)) {
                                $dateExploded = $row4["date_of_transaction"];
                                $hour = (int) date('H', strtotime($dateExploded));
                                if ($hour >= 8 && $hour <= 12) {
                                    $total_hours_frequency[0] += 1;
                                } elseif ($hour <= 15) {
                                    $total_hours_frequency[1] += 1;
                                } elseif ($hour <= 18) {
                                    $total_hours_frequency[2] += 1;
                                } else {
                                    $total_hours_frequency[3] += 1;
                                }
                            }
                        }
                        ?>

                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Hours', 'average'],
                    ['Hours(8:00 - 12:00)', <?php echo $total_hours_frequency[0] ?>],
                    ['Hours(12:00 - 15:00)', <?php echo $total_hours_frequency[1] ?>],
                    ['Hours(15:00 - 18:00)', <?php echo $total_hours_frequency[2] ?>],
                    ['Hours(18:00 - 21:00)', <?php echo $total_hours_frequency[3] ?>]
                ]);

                var options = {
                    title: 'Average visits per hour', 'width': 550, 'height': 400
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
            }
                        </script>
                        <div id="piechart" style="width: 900px; height: 500px;"></div>
                        <p><a href="customers.php" class="btn btn-primary">Back</a></p>
                        <br><br><br>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>