<?php
$store_id = $_REQUEST["id"];

$sql = "SELECT shelf, corridor, COUNT(products_transactions.`product_id`) AS counter
FROM products_transactions, transactions, store_products
WHERE products_transactions.transaction_id = transactions.id AND transactions.store_id = store_products.store_id AND products_transactions.product_id = store_products.product_id
AND transactions.store_id = $store_id
GROUP BY shelf, corridor
ORDER BY counter DESC
LIMIT 3";

//$query = "Select first_name, last_name from customers
//where customers.id = $customer_id;";
?>

<!DOCTYPE html>
<meta charset="utf-8">


<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>View Record</title>
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
                            <?php
//                            require_once "config.php";
//                            $result = mysqli_query($link, $query);
//                            $row = mysqli_fetch_array($result);
                            ?>

                            <h2>3 most popular positions for store : <?php echo $store_id?></h2>
                        </div>

                        <?php
                        require_once "config.php";
                        if ($result = mysqli_query($link, $sql)) {
                            //echo $result -> num_rows;
                            if (mysqli_num_rows($result) > 0) {
                                echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>Corridor</th>";
                                echo "<th>Shelf</th>";
                                echo "<th>Times Bought</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";

                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['corridor'] . "</td>";
                                    echo "<td>" . $row['shelf'] . "</td>";
                                    echo "<td>" . $row['counter'] . "</td>";
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
                        <p><a href="index.php" class="btn btn-primary">Back</a></p>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>
