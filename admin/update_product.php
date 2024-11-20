<?php
    // Uncomment during development for error reporting
    error_reporting(0);
    session_start();

    // Check if user is logged in and is an admin
    if (!isset($_SESSION['email'])) {
        header('location:../home/login.php');
        exit;
    } elseif ($_SESSION['usertype'] == 'user') {
        header('location:../home/login.php');
        exit;
    }

    // Connect to the database
    $conn = mysqli_connect('localhost', 'root', '', 'ecommerce');

    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    // Fetch product data if product_id is provided
    if (isset($_GET['product_id'])) {
        $product_id = intval($_GET['product_id']); // Ensure product_id is an integer
        $sql = "SELECT * FROM products WHERE id = '$product_id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $data = mysqli_fetch_assoc($result);
        } else {
            die('Product not found.');
        }
    }

    // Handle product update form submission
    if (isset($_POST['update_product'])) {
        $id = intval($_POST['id']); // Ensure id is an integer
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $price = str_replace(',', '', mysqli_real_escape_string($conn, $_POST['price'])); // Remove commas
        $quantity = intval($_POST['quantity']); // Ensure quantity is an integer

        // Handle file upload
        $file = $_FILES['image']['name'];
        if ($file) {
            $file_extension = pathinfo($file, PATHINFO_EXTENSION);
            $new_filename = uniqid() . '.' . $file_extension;
            $dst = "../product_images/" . $new_filename;
            $dst_db = "product_images/" . $new_filename;

            // Move uploaded file to destination folder
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $dst)) {
                die('File upload failed.');
            }

            // Update query with image
            $update_query = "UPDATE products 
                             SET title='$title', 
                                 description='$description', 
                                 price='$price', 
                                 quantity='$quantity', 
                                 image='$dst_db' 
                             WHERE id='$id'";
        } else {
            // Update query without image
            $update_query = "UPDATE products 
                             SET title='$title', 
                                 description='$description', 
                                 price='$price', 
                                 quantity='$quantity' 
                             WHERE id='$id'";
        }

        // Execute update query
        if (mysqli_query($conn, $update_query)) {
            header('location:view_product.php');
            exit;
        } else {
            echo 'Error updating product: ' . mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="admin_style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" 
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" 
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" 
          crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" 
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" 
            crossorigin="anonymous"></script>
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
                    <h1>Update Product</h1>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" 
                                   value="<?php echo $data['title']; ?>" required>
                        </div><br>
                        <div class="mb-3">
                            <label>Description</label>
                            <input type="text" class="form-control" name="description" 
                                   value="<?php echo $data['description']; ?>" required>
                        </div><br>
                        <div class="mb-3">
                            <label>Price</label>
                            <input type="text" class="form-control" name="price" 
                                   value="<?php echo $data['price']; ?>" required>
                        </div><br>
                        <div class="mb-3">
                            <label>Quantity</label>
                            <input type="number" class="form-control" name="quantity" 
                                   value="<?php echo $data['quantity']; ?>" required>
                        </div><br>
                        <div>
                            <label>Old Image</label><br>
                            <img src="../<?php echo $data['image']; ?>" alt="Product Image" 
                                 width="200px" height="200px">
                        </div><br>
                        <div class="mb-3">
                            <label>Image</label>
                            <input type="file" class="form-control" name="image">
                        </div><br>
                        <button type="submit" class="btn btn-primary" name="update_product">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
