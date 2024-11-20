<?php
    error_reporting(0);
    session_start();

    if(!isset($_SESSION['email']))
    {
        header('location:../home/login.php');
    }
    else if($_SESSION['usertype'] == 'user')
    {
        header('location:../home/login.php');
    }

    $conn = mysqli_connect('localhost','root','','ecommerce');

    if(!$conn)
    {
        die('Connection failed');
    }

    if(isset($_POST['add_product']))
    {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        $file = $_FILES['image']['name'];
        $file_extension = pathinfo($file, PATHINFO_EXTENSION);
    
        // Generate a unique file name with the extension
        $new_filename = uniqid() . '.' . $file_extension;
        $dst = "../product_images/" . $new_filename;
        $dst_db = "product_images/" . $new_filename;

        // Move the file to the destination folder
        move_uploaded_file($_FILES['image']['tmp_name'], $dst);
        

        $sql = "INSERT INTO products(title,description,price,quantity,image)
                VALUES('$title','$description','$price','$quantity','$dst_db')";
        $result = mysqli_query($conn,$sql);

        if($result)
        {
            header('location:add_product.php');
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="admin_style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <h2>Ecommerce Admin</h2>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Users</a></li>
                <li><a href="add_product.php">Add Products</a></li>
                <li><a href="view_product.php">View Product</a></li>
            </ul>
        </div>
        <div class="header">
            <div class="admin_header">
                <a href="../logout.php">Logout</a>
            </div>
            <div class="info">
                <div class="container" style="width: 60%;">
                <h1>Add Product</h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title">
                    </div><br>
                    <div class="mb-3">
                        <label>Description</label>
                        <input type="text" class="form-control" name="description">
                    </div><br>
                    <div class="mb-3">
                        <label>Price</label>
                        <input type="number" class="form-control" name="price">
                    </div><br>
                    <div class="mb-3">
                        <label>Quantity</label>
                        <input type="number" class="form-control" name="quantity">
                    </div><br>
                    <div class="mb-3">
                        <label>Image</label>
                        <input type="file" class="form-control" name="image">
                    </div><br>
                    <button type="submit" class="btn btn-primary" name="add_product">Submit</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>