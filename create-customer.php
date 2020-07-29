<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$first_name = $last_name = $birth_date = $address_number = $address_street = $postal_code = $city = $number_of_kids = $marital_status = "";
$first_name_err = $last_name_err = $birth_date_err = $address_number_err = $address_street_err = $postal_code_err = $city_err = $number_of_kids_err = $marital_status_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate first name
    $input_first_name = trim($_POST["first_name"]);
    if (empty($input_first_name)) {
        $first_name_err = "Please enter customer's first name.";
    } elseif (!filter_var($input_first_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[A-Za-zΑ-Ωα-ωίϊΐόάέύϋΰήώπρστυφχψς\s]+$/")))) {
        $first_name_err = "Please enter a valid name(Greek or English).";
    } else {
        $first_name = $input_first_name;
    }
        
    // Validate last name
    $input_last_name = trim($_POST["last_name"]);
    if (empty($input_last_name)) {
        $last_name_err = "Please enter customer's last name.";
    } elseif (!filter_var($input_last_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[A-Za-zΑ-Ωα-ωίϊΐόάέύϋΰήώπρστυφχψς\s]+$/")))) {
        $last_name_err = "Please enter a valid name(Greek or English).";
    } else {
        $last_name = $input_last_name;
    }

    // Validate date of birth
    $input_birth_date = trim($_POST["birth_date"]);

    $dateExploded = explode("-", $input_birth_date);

    if (empty($input_birth_date)) {
        $birth_date_err = "Please enter customer's date of birth.";
    } elseif (count($dateExploded) == 3) {
        $day = $dateExploded[2];
        $month = $dateExploded[1];
        $year = $dateExploded[0];
        if (!checkdate($month, $day, $year)) {
            $birth_date_err = $input_birth_date . ' is not a valid date!';
        } else {
            $birth_date = $input_birth_date;
        }
    } else {
        $birth_date_err = "Invalid date format!";
    }

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

    // Validate number of kids
    $input_number_of_kids = trim($_POST["number_of_kids"]);
    if (empty($input_number_of_kids)) {
        $number_of_kids_err = "Please enter customer's kids.";
    } elseif (!ctype_digit($input_number_of_kids)) {
        $number_of_kids_err = "Please enter a positive integer value.";
    } else {
        $number_of_kids = $input_number_of_kids;
    }

    // Validate marital status
    $input_marital_status = trim($_POST["marital_status"]);
    if (empty($input_marital_status)) {
        $marital_status_err = "Please enter customer's marital status.";
    } /* elseif (!ctype_digit($input_number_of_kids)) {
      $number_of_kids_err = "Please enter a positive integer value.";
      } */ else {
        $marital_status = $input_marital_status;
    }

    // Check input errors before inserting in database
    if (empty($first_name_err) && empty($last_name_err) && empty($birth_date_err) && empty($address_number_err) && empty($address_street_err) && empty($city_err) && empty($postal_code_err) && empty($number_of_kids_err) && empty($marital_status_err)) {
        // Prepare an insert statement

        $sql = "INSERT INTO customers (first_name, last_name, birth_date, address_number, address_street, address_postal_code, city, number_of_kids, marital_status_id) VALUES ('$first_name', '$last_name', '$birth_date', '$address_number', '$address_street', '$postal_code', '$city', '$number_of_kids', '$marital_status')";
        
        if ($stmt = mysqli_prepare($link, $sql)) {

            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: customers.php");
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
        <title>Create Record</title>
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
                            <h2>Create Customer</h2>
                        </div> 
                        <p>Please fill this form and submit to add a customer to the database.</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group <?php echo (!empty($first_name_err)) ? 'has-error' : ''; ?>">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control" value="<?php echo $first_name; ?>">
                                <span class="help-block"><?php echo $first_name_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($last_name_err)) ? 'has-error' : ''; ?>">
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="<?php echo $last_name; ?>">
                                <span class="help-block"><?php echo $last_name_err; ?></span>
                            </div>           
                            <div class="form-group <?php echo (!empty($birth_date_err)) ? 'has-error' : ''; ?>">
                                <label>Date of Birth</label>
                                <input type="date" name="birth_date" class="form-control" value="<?php echo $birth_date; ?>" >
                                <span class="help-block"><?php echo $birth_date_err; ?></span>                     
                            </div> 
                            <div class="form-group <?php echo (!empty($address_street_err)) ? 'has-error' : ''; ?>">
                                <label>Address Street</label>
                                <input type="text" name="street" class="form-control" value="<?php echo $address_street; ?>">
                                <span class="help-block"><?php echo $address_street_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($address_number_err)) ? 'has-error' : ''; ?>">
                                <label>Address Number</label>
                                <input type="text" name="number" class="form-control" value="<?php echo $address_number; ?>">
                                <span class="help-block"><?php echo $address_number_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($city_err)) ? 'has-error' : ''; ?>">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
                                <span class="help-block"><?php echo $city_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($postal_code_err)) ? 'has-error' : ''; ?>">
                                <label>Postal Code</label>
                                <input type="text" name="postal" class="form-control" value="<?php echo $postal_code; ?>">
                                <span class="help-block"><?php echo $postal_code_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($number_of_kids_err)) ? 'has-error' : ''; ?>">
                                <label>Number of kids</label>
                                <input type="number" name="number_of_kids" class="form-control" value="<?php echo $number_of_kids; ?>" min="0" max="10">
                                <span class="help-block"><?php echo $number_of_kids_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($marital_status_err)) ? 'has-error' : ''; ?>">
                                <label>Marital status</label>
                                <select type="number" name="marital_status" class="form-control" value="<?php echo $marital_status; ?>">
                                    <option value = "1"> Married </option> 
                                    <option value = "2"> Engaged </option>
                                    <option value = "3"> Single </option>
                                    <option value = "4"> Divorced </option>
                                </select>
                                <span class="help-block"><?php echo $marital_status_err; ?></span>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="customers.php" class="btn btn-default">Cancel</a>
                        </form>
                        <br>
                        <br>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>