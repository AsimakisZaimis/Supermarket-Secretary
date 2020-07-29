<?php
require_once "config.php";

$product_id = $_REQUEST["id"];

$sql2 = "SELECT `date`, `new_price`, `old_price` FROM price_history WHERE product_id = '$product_id'";

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
        <title>Products</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            .wrapper{
                width: 700px;
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
                            <h1>Product's price history</h1>
                        </div>
                        <table class='table table-bordered table-striped'>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>New price</th>
                                    <th>Old price</th>
                                </tr>
                            </thead>
                            <tr>
                                <?php
                                do {
                                    echo "<tr>";
                                    echo "<td>" . $row["date"] . "</td>";
                                    echo "<td>" . $row["new_price"] . "</td>";
                                    echo "<td>" . $row["old_price"] . "</td>";
                                    echo "</tr>";
                                } while ($row = mysqli_fetch_array($result))
                                ?>
                            </tr>
                        </table>                        
                        <div>
                            <p><a href="products.php" class="btn btn-primary">Back</a></p>
                        </div>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>