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
                width: 690px;
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
                            <h2 class="pull-left">Supermarkets</h2>
                            <a href="create-supermarket.php" class="btn btn-success pull-right">Add new store</a>
                            <a href="charts-conclusions.php" class="btn btn-primary pull-right" style="margin-right: 10px" title="Charts from supermarket's data" data-toggle='tooltip'>Conclusions</a>
                            <a href="best-stores.php" class="btn btn-primary pull-right" style="margin-right: 10px" title="Stores with most sales!" data-toggle='tooltip'>Best stores</a>
                        </div>
                        <?php
                        // Include config file
                        require_once "config.php";

                        // Attempt select query execution
                        $sql = "SELECT * FROM stores";
                        if ($result = mysqli_query($link, $sql)) {
                            if (mysqli_num_rows($result) > 0) {
                                echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Address</th>";
                                echo "<th>Action</th>";
                                //echo "<th>Action</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    //echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['address_street'] . " " . $row['address_number'] . "</td>";
                                    //echo "<td>" . $row['salary'] . "</td>";
                                    echo "<td>";
                                    echo "<a href='read-supermarket.php?id=" . $row['id'] . "' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                    echo "<a href='update-supermarket.php?id=" . $row['id'] . "' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                    echo "<a href='delete-supermarket.php?id=" . $row['id'] . "' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                    echo "<a href='transactions.php?id=" . $row['id'] . "' title='Shop Transactions' data-toggle='tooltip'><span class='glyphicon glyphicon-shopping-cart'></span></a>";
                                    echo "<a href='popular-positions.php?id=" . $row['id'] . "' title='Most Popular Positions for Products' data-toggle='tooltip'><span class='glyphicon glyphicon-star-empty'></span></a>";
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
                        <a href="customers.php" class="btn btn-primary">View Customers</a>
                        <a href="products.php" class="btn btn-primary">View Products</a>
                        <a href="view-sales.php" class="btn btn-primary">Sales per store per category</a>
                        <a href="view-customer.php" class="btn btn-primary">Customer's Personal Details</a>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>