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

    if($_GET['product_id'])
    {
        $product_id = $_GET['product_id'];
        $query = "DELETE FROM products WHERE id = '$product_id'";
        $query_result = mysqli_query($conn,$query);

        if($query_result)
        {
            header('location:view_product.php');
        }
    }

    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
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
                <div class="container">
                    <h1>All Products</h1>
                    <table class="table table-bordered">
                        <thead>
                           
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                                <th scope="col">Image</th>
                                <th scope="col">Delete</th>
                                <th scope="col">Update</th>
                            </tr>
                            
                        </thead>
                        <tbody>
                            <?php while($info = mysqli_fetch_assoc($result)){ ?>
                                <tr>
                                    <td><?php echo "{$info['title']}" ?></td>
                                    <td><?php echo "{$info['description']}" ?></td>
                                    <td><?php echo "{$info['quantity']}" ?></td>
                                    <td><?php echo "{$info['price']}" ?></td>
                                    <td><img src="../<?php echo "{$info['image']}" ?>" 
                                    width="100px" height="100px"  alt=""></td>
                                    <td><a onClick="javascript:return confirm('Are you sure you want to delete this?')"
                                        href="view_product.php?product_id=<?php echo "{$info['id']}" ?>" 
                                    class="btn btn-danger btn-sm">Delete</a></td>
                                    <td><a href="update_product.php?product_id=<?php echo "{$info['id']}" ?>" 
                                        class="btn btn-primary btn-small">Update</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>