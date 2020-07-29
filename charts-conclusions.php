<?php
$category_err = "";
$sql = "";
$category_id = "";
?>



<html>
    <body>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            .wrapper{
                width: 700px;
                margin: 0 auto;
            }
        </style>
        <style type="text/css">
            .wrapper2{
                width: 700px;
                margin: 0 auto;
            }
        </style>
        <style type="text/css">
            .wrapper3{
                width: 930px;
                margin: 0 auto;
            }
        </style>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header clearfix">
                            <h2 class="pull-left">Charts from supermarket's data</h2>
                        </div>
                        <?php echo "<form action='charts-conclusions.php?id=" . $category_id . "' method='post'>"; ?>    
                        <div class="form-group">
                            <label>Choose Category to see the percentage(%) of loyalty in private labeled products</label>
                            <select type="number" name="category" class="form-control" value="<?php echo $category_id; ?>">
                                <option value = "1"> Fresh products </option> 
                                <option value = "2"> Fridge items </option>
                                <option value = "3"> Drinks </option> 
                                <option value = "4"> Personal care items </option>
                                <option value = "5"> Home items </option> 
                                <option value = "6"> Pet items </option>
                            </select>
                        </div>
                        <br>
                        <input type = "submit" class="btn btn-primary" value = "Search">
                        </form>

                        <?php
                        require_once "config.php";

                        // Processing form data when form is submitted

                        if (!empty($_POST['category'])) {
                            $category_id = $_POST["category"];
                            $sql = "SELECT tag, COUNT(tag) AS counter FROM products_transactions, products
                                    WHERE products_transactions.product_id = products.id AND products.category_id = '$category_id'
                                    GROUP BY tag";

                            if (!$result = mysqli_query($link, $sql)) {
                                header("location: error.php");
                                exit();
                            }

                            $row = array(0, 0);
                            while ($x = mysqli_fetch_array($result)) {
                                if ($x['tag'] == 0)
                                    $row[0] = $x['counter'];
                                else
                                    $row[1] = $x['counter'];
                            }
                        }
                        $sql2 = "SELECT AVG(total_cost) AS avg, inter FROM 
                                (SELECT A.total_cost, CASE WHEN A.hours BETWEEN 8 AND 12 THEN 'first' 
                                WHEN A.hours BETWEEN 12 AND 15 THEN 'second'
                                WHEN A.hours BETWEEN 15 AND 18 THEN 'third'
                                ELSE 'forth' END AS inter FROM 
                                (SELECT total_cost, HOUR(date_of_transaction) AS hours FROM transactions) AS A) AS B
                                GROUP BY B.inter";
                        if (!$result2 = mysqli_query($link, $sql2)) {
                            header("location: error.php");
                            exit();
                        }
                        $row2 = array(0, 0, 0, 0);
                        while ($x = mysqli_fetch_array($result2)) {
                            if ($x['inter'] == 'first')
                                $row2[0] = $x['avg'];
                            elseif ($x['inter'] == 'second')
                                $row2[1] = $x['avg'];
                            elseif ($x['inter'] == 'third')
                                $row2[2] = $x['avg'];
                            else
                                $row2[3] = $x['avg'];
                        }

                        $sql3 = "SELECT COUNT(*) AS counter, E.interv, E.ageinterv FROM (
                                SELECT C.age_inter AS ageinterv, D.inter AS interv FROM (
                                SELECT customers.id AS customer, CASE WHEN YEAR(birth_date) BETWEEN 0 AND 1965 THEN 'elder'
                                WHEN YEAR(birth_date) BETWEEN 1960 AND 1990 THEN 'middleaged'
                                ELSE 'young' END AS age_inter FROM customers) AS C
                                JOIN
                                (
                                SELECT customer, inter FROM    
                                (SELECT A.customer_id AS customer, CASE WHEN A.hours BETWEEN 8 AND 12 THEN 'first' 
                                WHEN A.hours BETWEEN 12 AND 15 THEN 'second'
                                WHEN A.hours BETWEEN 15 AND 18 THEN 'third'
                                ELSE 'forth' END AS inter FROM 
                                (SELECT customer_id, HOUR(date_of_transaction) AS hours FROM transactions) AS A) AS B) AS D
                                ON C.customer = D.customer) AS E
                                GROUP BY E.ageinterv, E.interv";

                        $row3 = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

                        if (!$result3 = mysqli_query($link, $sql3)) {
                            header("location: error.php");
                            exit();
                        }
                        while ($x = mysqli_fetch_array($result3)) {
                            $y = $x['counter'];
                            if ($x['interv'] == 'first') {
                                if ($x['ageinterv'] == 'young')
                                    $row3[0] = $y;
                                if ($x['ageinterv'] == 'middleaged')
                                    $row3[1] = $y;
                                if ($x['ageinterv'] == 'elder')
                                    $row3[2] = $y;
                            }

                            elseif ($x['interv'] == 'second') {
                                if ($x['ageinterv'] == 'young')
                                    $row3[3] = $y;
                                if ($x['ageinterv'] == 'middleaged')
                                    $row3[4] = $y;
                                if ($x['ageinterv'] == 'elder')
                                    $row3[5] = $y;
                            }
                            elseif ($x['interv'] == 'third') {
                                if ($x['ageinterv'] == 'young')
                                    $row3[6] = $y;
                                if ($x['ageinterv'] == 'middleaged')
                                    $row3[7] = $y;
                                if ($x['ageinterv'] == 'elder')
                                    $row3[8] = $y;
                            }
                            else {
                                if ($x['ageinterv'] == 'young')
                                    $row3[9] = $y;
                                if ($x['ageinterv'] == 'middleaged')
                                    $row3[10] = $y;
                                if ($x['ageinterv'] == 'elder')
                                    $row3[11] = $y;
                            }
                        }

                        $sum3 = array(0, 0, 0, 0);
                        $sum3[0] = $row3[0] + $row3[1] + $row3[2];
                        $sum3[1] = $row3[3] + $row3[4] + $row3[5];
                        $sum3[2] = $row3[6] + $row3[7] + $row3[8];
                        $sum3[3] = $row3[9] + $row3[10] + $row3[11];
                        ?>

                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                            google.charts.load('current', {'packages': ['corechart']});
                            google.charts.setOnLoadCallback(drawChart);

                            function drawChart() {

                                var data = google.visualization.arrayToDataTable([
                                    ['Label', 'average'],
                                    ['Private labeled', <?php echo $row[1] ?>],
                                    ['Brand labeled', <?php echo $row[0] ?>]
                                ]);

                                var options = {
                                    title: '', 'width': 750, 'height': 400
                                };

                                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                                chart.draw(data, options);
                            }
                        </script>
                        <div id="piechart" style="width: 900px; height: 360px;"></div>

                        <br><br><br><br>
                    </div>
                </div>        
            </div>
        </div>
        <div class="wrapper3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                            google.charts.load("current", {packages: ['corechart']});
                            google.charts.setOnLoadCallback(drawChartWeeks);

                            function drawChartWeeks() {
                                var data = google.visualization.arrayToDataTable([
                                    ["Hours", "average", {role: "style"}],
                                    ["Hours(8:00 - 12:00)", <?php echo $row2[0] ?>, "cadetblue"],
                                    ["Hours(12:00 - 15:00)", <?php echo $row2[1] ?>, "teal"],
                                    ["Hours(15:00 - 18:00)", <?php echo $row2[2] ?>, "darkgreen"],
                                    ["Hours(18:00 - 21:00)", <?php echo $row2[3] ?>, "darkrodenrod"]
                                ]);

                                var view = new google.visualization.DataView(data);
                                view.setColumns([0, 1,
                                    {calc: "stringify",
                                        sourceColumn: 1,
                                        type: "string",
                                        role: "annotation"},
                                    2]);

                                var options = {
                                    title: "Average cost of transaction per hour",
                                    width: 1000,
                                    height: 400,
                                    bar: {groupWidth: "40%"},
                                    legend: {position: "none"},
                                };
                                var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values_week"));
                                chart.draw(view, options);
                            }
                        </script>
                        <div id="columnchart_values_week" style="width: 900px; height: 400px;"></div>
                        <br><br><br><br><br><br><br>
                    </div>
                </div>        
            </div>
        </div>
        <div class="wrapper2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                            google.charts.load('current', {'packages': ['bar']});
                            google.charts.setOnLoadCallback(drawChart);

                            function drawChart() {
                                var data = google.visualization.arrayToDataTable([
                                    ['Hours', 'Young(<30)', 'Middle Aged(30-60)', 'Elder(>60)'],
                                    ['Hours(8:00 - 12:00)', <?php echo 100 * $row3[0] / $sum3[0]; ?>, <?php echo 100 * $row3[1] / $sum3[0]; ?>, <?php echo 100 * $row3[2] / $sum3[0]; ?>],
                                    ['Hours(12:00 - 15:00)', <?php echo 100 * $row3[3] / $sum3[1]; ?>, <?php echo 100 * $row3[4] / $sum3[1]; ?>, <?php echo 100 * $row3[5] / $sum3[1]; ?>],
                                    ['Hours(15:00 - 18:00)', <?php echo 100 * $row3[6] / $sum3[2]; ?>, <?php echo 100 * $row3[7] / $sum3[2]; ?>, <?php echo 100 * $row3[8] / $sum3[2]; ?>],
                                    ['Hours(18:00 - 21:00)', <?php echo 100 * $row3[9] / $sum3[3]; ?>, <?php echo 100 * $row3[10] / $sum3[3]; ?>, <?php echo 100 * $row3[11] / $sum3[3]; ?>]
                                ]);

                                var options = {
                                    chart: {
                                        title: 'Percentage(%) of transactions during working hours by age groups',
                                        subtitle: 'Young, Middle Aged, Elder',
                                        width: 1000,
                                        height: 400,
                                    }
                                };

                                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                                chart.draw(data, google.charts.Bar.convertOptions(options));
                            }
                        </script>
                        <div id="columnchart_material" style="width: 900px; height: 400px; text-align: center;"></div>

                        <br><br><br><br>

                        <?php
                        $sql4 = "SELECT products1.`name` AS name1, products2.`name` AS name2, B.counter FROM (
                                (SELECT A.pr1 AS p1, A.pr2 AS p2, COUNT(*) AS counter  FROM ( 
                                SELECT prodtrans1.product_id AS pr1, prodtrans2.product_id AS pr2 FROM products_transactions AS prodtrans1, products_transactions AS prodtrans2 
                                WHERE prodtrans1.transaction_id = prodtrans2.transaction_id AND prodtrans1.product_id <> prodtrans2.product_id) AS A
                                GROUP BY p1, p2)) AS B JOIN
                                products AS products1 ON products1.id = p1
                                JOIN products AS products2 ON products2.id = p2
                                ORDER BY counter DESC
                                LIMIT 20";

                        echo "<h3>Top 10 popular pair of poducts</h3><br>";
                        
                        if ($result4 = mysqli_query($link, $sql4)) {
                            if (mysqli_num_rows($result4) > 0) {
                                echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>Product 1</th>";
                                echo "<th>Product 2</th>";
                                echo "<th>Pair's transactions</th>";
                                //echo "<th>Action</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($row4 = mysqli_fetch_array($result4)) {
                                    echo "<tr>";
                                    echo "<td>" . $row4['name1'] . "</td>";
                                    //echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row4['name2'] . "</td>";
                                    echo "<td>" . $row4['counter'] . "</td>";

                                    echo "</tr>";
                                    $row4 = mysqli_fetch_array($result4);
                                }
                                echo "</tbody>";
                                echo "</table>";
                                // Free result set
                                mysqli_free_result($result4);
                            } else {
                                echo "<p class='lead'><em>No records were found.</em></p>";
                            }
                        } else {
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                        }
                        ?>
                        <p><a href="index.php" class="btn btn-primary">Back</a></p>
                        <br><br><br><br>
                    </div>
                </div>
            </div>        
        </div>
    </body>
</html>