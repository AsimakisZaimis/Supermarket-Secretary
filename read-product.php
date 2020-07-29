<?php
require_once "config.php";

$product_id = $_REQUEST["id"];

$sql2 = "SELECT * FROM products WHERE id = '$product_id'";

if ($result = mysqli_query($link, $sql2)) {
    $row = mysqli_fetch_array($result);
} else {
    header("location: error.php");
    exit();
}
$tag;
if ($row['tag'] == '0')
    $tag = "Brand labeled";
else if ($row['tag'] == '1')
    $tag = "Private labeled";


$category;
if ($row['category_id'] == '1')
    $category = "Fresh products";
else if ($row['category_id'] == '2')
    $category = "Fridge items";
else if ($row['category_id'] == '3')
    $category = "Drinks";
else if ($row['category_id'] == '4')
    $category = "Personal care items";
else if ($row['category_id'] == '5')
    $category = "Home items";
else if ($row['category_id'] == '6')
    $category = "Pet items";
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
                            <h1>Product's Details</h1>
                        </div>
                        <table class='table table-bordered table-striped'>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Tag</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $tag ?></td>
                                <td><?php echo $category; ?></td>
                                <td><?php echo $row["price"]; ?></td>
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