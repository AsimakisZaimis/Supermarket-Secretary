<?php
require_once "config.php";

$store_id = $_REQUEST["id"];

$sql2 = "SELECT * FROM stores WHERE id = '$store_id'";

if ($result = mysqli_query($link, $sql2)) {
    $row = mysqli_fetch_array($result);
} else {
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>View Record</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            .wrapper{
                width: 800px;
                margin: 0 auto;
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h1>Supermarket Details</h1>
                        </div>
                        <table class='table table-bordered table-striped'>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Open Hours</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Postal Code</th>
                                    <th>Square Meters</th>
                                </tr>
                            </thead>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["opening_hour"] . " - " . $row["closing_hour"]; ?></td>
                                <td><?php echo $row["address_street"] . " " . $row["address_number"]; ?></td>
                                <td><?php echo $row["city"]; ?></td>
                                <td><?php echo $row["address_postal_code"]; ?></td>
                                <td><?php echo $row["square_meters"]; ?></td>
                            </tr>
                        </table>
                        <div>
                            <p><a href="index.php" class="btn btn-primary">Back</a></p>
                        </div>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>