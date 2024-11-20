<?php
    error_reporting(0);
    session_start();
    
    $conn = mysqli_connect('localhost','root','','ecommerce');

    if(!$conn)
    {
        die('Connection failed');
    }

    if(isset($_POST['login']))
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email = '".$email."' AND password = '".$password."'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result);

        if($row['usertype']=="user")
        {
            $_SESSION['email'] = $email;
            $_SESSION['usertype'] = 'user';
            header('location:userpage.php');
        }
        else if($row['usertype']=="admin")
        {
            $_SESSION['email'] = $email;
            $_SESSION['usertype'] = 'admin';
            header('location:../admin/adminpage.php');
        }
        else{
            $_SESSION['message'] = "Username or password is incorrect";
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="my_form">
        <h2><?php echo $_SESSION['message'] ?></h2>
        <h2>Login Form</h2>
        <form action="" method="post">
            <div class="input_deg">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="input_deg">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="input_deg">
                <input type="submit" name="login" value="Login">
            </div>
        </form>
    </div>
</body>
</html>