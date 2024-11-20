<?php
    $conn = mysqli_connect('localhost','root','','ecommerce');

    if(!$conn)
    {
        die("Connection failed");
    }

    if(isset($_POST['register']))
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $usertype = 'user';

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users(name,email,password,phone,address,usertype)
        VALUES('$name','$email','$hashed_password','$phone','$address','$usertype')";

        $result = mysqli_query($conn,$sql);

        if($result)
        {
            echo "Register Success";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="my_form">
        <h2>Register Form</h2>
        <form action="" method="post">
            <div class="input_deg">
                <label>Name</label>
                <input type="text" name="name">
            </div>
            <div class="input_deg">
                <label>Email</label>
                <input type="email" name="email">
            </div>
            <div class="input_deg">
                <label>Phone</label>
                <input type="text" name="phone">
            </div>
            <div class="input_deg">
                <label>Address</label>
                <input type="text" name="address">
            </div>
            <div class="input_deg">
                <label>Password</label>
                <input type="password" name="password">
            </div>
            <div class="input_deg">
                <input type="submit" name="register" value="Register">
            </div>
        </form>
    </div>
</body>
</html>