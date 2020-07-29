<?php
$store_id = $_REQUEST["id"];

$sql = "SELECT * FROM transactions WHERE store_id = $store_id";

if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $sql .= " and date_of_transaction between '$start_date' and '$end_date'";
}

if (!empty($_POST['payment_method'])) {
    $payment_method = $_POST["payment_method"];
    if ($payment_method != "none") {
        $sql .= " and payment_methods_id ='$payment_method'";
    }
}
if (!empty($_POST['number_of_products'])) {
    $number_of_products = $_POST["number_of_products"];
    $sql .= " and number_of_products > '$number_of_products'";
}
if (!empty($_POST['total_cost'])) {
    $total_cost = $_POST['total_cost'];
    $sql .= " and total_cost > '$total_cost'";
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
                width: 500px;
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
                            <h1>Transactions</h1>
                        </div>

                        <?php echo "<form action='transactions.php?id=" . $store_id . "' method='post'>"; ?>
                        <label for="start">Start date:</label>
                        <input type="date" name="start_date" class="form-control"
                               value="<?php if (!empty($_POST['start_date'])) echo $start_date; ?>"
                               min="2000-01-01">
                        <br>
                        <label for="start">End date:</label>
                        <input type="date" name="end_date" class="form-control"
                               value="<?php if (!empty($_POST['end_date'])) echo $end_date; ?>"
                               min="2000-01-01">
                        <br>
                        <label for="Payment_Method">Payment Method:</label>
                        <select name = "payment_method" class="form-control"
                                value="<?php if (!empty($_POST['payment_method'])) echo $payment_method; ?>">
                            <option value = "none"> Select </option> 
                            <option value = "1"> Cash </option>
                            <option value = "2"> Credit-Debit </option>
                            <option value = "3"> Coupons </option>
                        </select>

                        <br>
                        <label for="points1">Number Of Products:</label>
                        <input type="number" id="points1" name="number_of_products" step="1" class="form-control"
                               value="<?php if (!empty($_POST['number_of_products'])) echo $number_of_products; ?>" min="1">
                        <br>
                        <label for="points2">Total Cost From:</label>
                        <input type="number" id="points2" name="total_cost" step="any" class="form-control"
                               value="<?php if (!empty($_POST['total_cost'])) echo $total_cost; ?>" min="0">
                        <br>
                        <input type = "submit" value = "Search">
                        </form>
                        <br>
                        <?php
// Include config file
                        require_once "config.php";


// Attempt select query execution
//$sql = "SELECT * FROM transactions WHERE store_id = ?";
                        if ($result = mysqli_query($link, $sql)) {
                            //echo $result -> num_rows;
                            if (mysqli_num_rows($result) > 0) {
                                echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Transaction's Date</th>";
                                echo "<th>Number Of Products</th>";
                                echo "<th>Total Cost</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";

                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['date_of_transaction'] . "</td>";
                                    echo "<td>" . $row['number_of_products'] . "</td>";
                                    echo "<td>" . $row['total_cost'] . "</td>";

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