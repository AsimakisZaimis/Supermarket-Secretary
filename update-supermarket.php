<?php
// Include config file
require_once "config.php";

$store_id = $_REQUEST["id"];

$sql2 = "SELECT * FROM stores WHERE id = '$store_id'";

if ($result = mysqli_query($link, $sql2)) {
    $row = mysqli_fetch_array($result);
} else {
    header("location: error.php");
    exit();
}

// Define variables and initialize with existing values
$address_number = $row['address_number'];
$address_street = $row['address_street'];
$postal_code = $row['address_postal_code'];
$city = $row['city'];
$square_meters = $row['square_meters'];
$address_number_err = $address_street_err = $postal_code_err = $city_err = $square_meters_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate street
    $input_address_street = trim($_POST["street"]);
    if (empty($input_address_street)) {
        $address_street_err = "Please enter store's street.";
    } elseif (!filter_var($input_address_street, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[A-Za-zΑ-Ωα-ωίϊΐόάέύϋΰήώπρστυφχψς\s]+$/")))) {
        $address_street_err = "Please enter a valid street(Greek or English).";
    } else {
        $address_street = $input_address_street;
    }

    // Validate number
    $input_address_number = trim($_POST["number"]);
    if (empty($input_address_number)) {
        $address_number_err = "Please enter street's number.";
    } elseif (!ctype_digit($input_address_number)) {
        $address_number_err = "Please enter a positive integer value.";
    } else {
        $address_number = $input_address_number;
    }

    // Validate city
    $input_city = trim($_POST["city"]);
    if (empty($input_city)) {
        $city_err = "Please enter store's street.";
    } elseif (!filter_var($input_city, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[A-Za-zΑ-Ωα-ωίϊΐόάέύϋΰήώπρστυφχψς\s]+$/")))) {
        $city_err = "Please enter a valid city(Greek or English).";
    } else {
        $city = $input_city;
    }

    // Validate postal code
    $input_postal_code = trim($_POST["postal"]);
    if (empty($input_postal_code)) {
        $postal_code_err = "Please enter city's postal code.";
    } elseif (!ctype_digit($input_postal_code)) {
        $postal_code_err = "Please enter a positive integer value.";
    } else {
        $postal_code = $input_postal_code;
    }

    // Validate square meters
    $input_square_meters = trim($_POST["sqmeters"]);
    if (empty($input_square_meters)) {
        $square_meters_err = "Please enter the store's square meters.";
    } elseif (!ctype_digit($input_square_meters)) {
        $square_meters_err = "Please enter a positive integer value.";
    } else {
        $square_meters = $input_square_meters;
    }

    // Check input errors before inserting in database
    if (empty($address_number_err) && empty($address_street_err) && empty($city_err) && empty($postal_code_err) && empty($square_meters_err)) {
        // Prepare an insert statement
        $sql = "UPDATE stores SET address_number = '$address_number', address_street = '$address_street'"
                . ", address_postal_code = '$postal_code', city = '$city', square_meters = '$square_meters'"
                . "WHERE id = '$store_id'";

        if ($stmt = mysqli_prepare($link, $sql)) {

            if (mysqli_stmt_execute($stmt)) {
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Supermarket</title>
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
                            <h2>Update Store</h2>
                        </div> 
                        <p>Please fill this form and submit to add a supermarket store to the database.</p>
                        <form action="<?php "<form action='update-supermarket.php?id=" . $store_id . "' method='post'>"; ?>" method="post">
                            <div class="form-group <?php echo (!empty($address_street_err)) ? 'has-error' : ''; ?>">
                                <label>Street</label>
                                <input type="text" name="street" class="form-control" value="<?php echo $address_street; ?>">
                                <span class="help-block"><?php echo $address_street_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($address_number_err)) ? 'has-error' : ''; ?>">
                                <label>Number</label>
                                <input type="text" name="number" class="form-control" value="<?php echo $address_number ?>">
                                <span class="help-block"><?php echo $address_number_err; ?></span>
                            </div>            
                            <div class="form-group <?php echo (!empty($city_err)) ? 'has-error' : ''; ?>">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" value="<?php echo $row['city'] ?>">
                                <span class="help-block"><?php echo $city_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($postal_code_err)) ? 'has-error' : ''; ?>">
                                <label>Postal Code</label>
                                <input type="text" name="postal" class="form-control" value="<?php echo $postal_code; ?>">
                                <span class="help-block"><?php echo $postal_code_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($square_meters_err)) ? 'has-error' : ''; ?>">
                                <label>Square meters</label>
                                <input type="text" name="sqmeters" class="form-control" value="<?php echo $square_meters ?>">
                                <span class="help-block"><?php echo $square_meters_err; ?></span>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Update">
                            <a href="index.php" class="btn btn-default">Cancel</a>
                        </form>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>