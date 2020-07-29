<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
        <style type="text/css">
            .wrapper{
                width: 650px;
                margin: 0 auto;
            }
            .page-header h2{
                margin-top: 0;
            }
            table tr td:last-child a{
                margin-right: 15px;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </head>
    <body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header clearfix">
                            <h2 class="pull-left">Customers</h2>
                            <a href="create-customer.php" class="btn btn-success pull-right">Add new customer</a>
                            <a href="best-customers.php" class="btn btn-primary pull-right" style="margin-right: 10px" title="Top 10 customers with most transactions!" data-toggle='tooltip'>Best customers</a>
                        </div>
                        <?php
                        // Include config file
                        require_once "config.php";

                        // Attempt select query execution
                        $sql = "SELECT * FROM customers";
                        if ($result = mysqli_query($link, $sql)) {
                            if (mysqli_num_rows($result) > 0) {
                                echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Name</th>";
                                //echo "<th>Last Name</th>";
                                echo "<th>Action</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    //echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                                    //echo "<td>" . $row['salary'] . "</td>";
                                    echo "<td>";
                                    echo "<a href='read-customer.php?id=" . $row['id'] . "' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                    echo "<a href='update-customer.php?id=" . $row['id'] . "' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                    echo "<a href='delete-customer.php?id=" . $row['id'] . "' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                    echo "<a href='popular-products.php?id=" . $row['id'] . "' title='10 Most Popular Products' data-toggle='tooltip'><span class='glyphicon glyphicon-shopping-cart'></span></a>";
                                    echo "<a href='visitedstores.php?id=" . $row['id'] . "' title='Stores visited' data-toggle='tooltip'><span class='glyphicon glyphicon-map-marker'></span></a>";
                                    echo "<a href='charts-customers.php?id=" . $row['id'] . "' title='Charts' data-toggle='tooltip'><span class='glyphicon glyphicon-signal'></span></a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                echo "</table>";
                                // Free result set
                                mysqli_free_result($result);
                            } else {
                                echo "<p class='lead'><em>No records were found.</em></p>";
                            }
                        } else {
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                        }

                        // Close connection
                        mysqli_close($link);
                        ?>
                        <a href="index.php" class="btn btn-primary">Back to stores</a>
                        <br><br><br>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>