<?php
// Include config file
require_once "config.php";

$sql2 = "SELECT id, address_street, address_number, city FROM stores";

$sql = "SELECT date_of_transaction, total_cost, first_name, last_name, method FROM sales_view";

if ($result2 = mysqli_query($link, $sql2)) {
    $row2 = mysqli_fetch_array($result2);
} else {
    header("location: error.php");
    exit();
}


if (!empty($_POST['store_id'])) {
    $store_id = $_POST["store_id"];
    $sql .= " WHERE sales_view.store_id = '$store_id'";
}

if (!empty($_POST['category_id'])) {
    $category_id = $_POST["category_id"];
        $sql .= " AND sales_view.cat_id ='$category_id'";
}

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
                            <h1>Sales by store and category</h1>
                        </div>

                        <form action='view-sales.php?id=" .<?php $store_id ?>. "' method='post'>     
                            <div class="form-group">
                                <label for="store_id">Stores</label>
                                <select type="number" name="store_id" class="form-control">
                                    <?php
                                    do {
                                        echo '<option value = "' . $row2['id'] . '">' . $row2['city'] . ' ' . $row2['address_street'] . ' ' . $row2['address_number'] . '</option>' . '</td>';
                                    } while ($row2 = mysqli_fetch_array($result2));
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">    
                                <label for="Categories">Categories :</label>
                                <select name = "category_id" class="form-control">
                                    <option value = "1"> Fresh Products </option> 
                                    <option value = "2"> Fridge Items </option>
                                    <option value = "3"> Drinks </option>
                                    <option value = "4"> Personal Care Items </option>
                                    <option value = "5"> Home Items </option>
                                    <option value = "6"> Pet Items </option>
                                </select>
                            </div>

                            <input type = "submit" value = "Search">
                        </form>
                        <br>
                        <?php

                        // Attempt select query execution
                        if ($result = mysqli_query($link, $sql)) {
                            if (mysqli_num_rows($result) > 0) {
                                echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>Transaction's date</th>";
                                echo "<th>Customer's name</th>";
                                echo "<th>Total cost</th>";
                                echo "<th>Payment method</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";

                                 while ($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                    echo "<td>" . $row['date_of_transaction'] . "</td>";
                                    echo "<td>" . $row['first_name'] . ' '. $row['last_name'] ."</td>";
                                    echo "<td>" . $row['total_cost'] . "</td>";
                                    echo "<td>" . $row['method'] . "</td>";
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
                        <br><br><br>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>