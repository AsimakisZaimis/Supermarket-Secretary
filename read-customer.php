<?php
require_once "config.php";

$customer_id = $_REQUEST["id"];

$sql2 = "SELECT * FROM customers WHERE id = '$customer_id'";

if ($result = mysqli_query($link, $sql2)) {
    $row = mysqli_fetch_array($result);
} else {
    header("location: error.php");
    exit();
}

$marital_status;
if($row['marital_status_id'] == '1')
    $marital_status = "Married";
else if($row['marital_status_id'] == '2')
    $marital_status = "Engaged";
else if($row['marital_status_id'] == '3')
    $marital_status = "Single";
else if($row['marital_status_id'] == '4')
    $marital_status = "Divorced";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Customer</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            .wrapper{
                width: 900px;
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
                            <h1>Customer's Details</h1>
                        </div>
                        <table class='table table-bordered table-striped'>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Date of birth</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Postal code</th>
                                    <th>Number of kids</th>
                                    <th>Marital status</th>
                                </tr>
                            </thead>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["first_name"] . " " . $row["last_name"]; ?></td>
                                <td><?php echo $row["birth_date"]; ?></td>
                                <td><?php echo $row["address_street"] . " " . $row["address_number"]; ?></td>
                                <td><?php echo $row["city"]; ?></td>
                                <td><?php echo $row["address_postal_code"]; ?></td>
                                <td><?php echo $row["number_of_kids"]; ?></td>
                                <td><?php echo $marital_status; ?></td>
                            </tr>
                        </table>
                        <div>
                            <p><a href="customers.php" class="btn btn-primary">Back</a></p>
                        </div>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>