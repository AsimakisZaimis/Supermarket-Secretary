<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$tag = $name = $category = $price = "";
$tag_err = $name_err = $category_err = $price_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter product's name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[A-Za-zΑ-Ωα-ωίϊΐόάέύϋΰήώπρστυφχψς\s]+$/")))) {
        $name_err = "Please enter a valid name(Greek or English).";
    } else {
        $name = $input_name;
    }

    // Validate tag
    $input_tag = trim($_POST["tag"]);
    if (empty($input_tag)) {
        $tag_err = "Please enter tag.";
    } else {
        $tag = $input_tag - 1;
    }

    // Validate category
    $input_category = trim($_POST["category"]);
    if (empty($input_category)) {
        $category_err = "Please enter category.";
    } else {
        $category = $input_category;
    }


    // Validate price
    $input_price = trim($_POST["price"]);
    if (empty($input_price)) {
        $price_err = "Please enter product's price.";
    } else {
        $price = $input_price;
    }


    // Check input errors before inserting in database
    if (empty($name_err) && empty($tag_err) && empty($category_err) && empty($price_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO products (tag, name, category_id, price) VALUES ('$tag', '$name', '$category', '$price')";

        if ($stmt = mysqli_prepare($link, $sql)) {

            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: products.php");
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
                            <h2>Create product</h2>
                        </div> 
                        <p>Please fill this form and submit to add a product to the database.</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                                <span class="help-block"><?php echo $name_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($tag_err)) ? 'has-error' : ''; ?>">
                                <label>Tag</label>
                                <select type="number" name="tag" class="form-control" value="<?php echo $tag; ?>">
                                    <option value = "1"> Brand labeled </option> 
                                    <option value = "2"> Private labeled </option>
                                </select>
                                <span class="help-block"><?php echo $tag_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($category_err)) ? 'has-error' : ''; ?>">
                                <label>Category</label>
                                <select type="number" name="category" class="form-control" value="<?php echo $category; ?>">
                                    <option value = "1"> Fresh products </option> 
                                    <option value = "2"> Fridge items </option>
                                    <option value = "3"> Drinks </option> 
                                    <option value = "4"> Personal care items </option>
                                    <option value = "5"> Home items </option> 
                                    <option value = "6"> Pet items </option>
                                </select>
                                <span class="help-block"><?php echo $category_err; ?></span>
                            </div>
                            <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                                <label>Price</label>
                                <input type="number" name="price" step="any" class="form-control" value="<?php echo $price; ?>" min="0.01">
                                <span class="help-block"><?php echo $price_err; ?></span>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="products.php" class="btn btn-default">Cancel</a>
                        </form>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>