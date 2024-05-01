
<?php  
    include("connection.php");

    //declare variables for error then assign later if true
    $username_error = "";
    $email_error = "";
    $password_error = "";
    $confirmpassword_error = "";

    if (isset($_POST["submit"])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    
    // Validate username
    if (empty($username)) {
        $username_error = "Username cannot be empty!";
    
    } else if (strlen($username) < 5) {
        $username_error = "Username should have at least 5 characters";
    } else if (!empty($username)) {
         
        $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $username_error= "Username already exists";
        }
    }

    // Validate email
    if (empty($email)) {
        $email_error = "Email cannot be empty!";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format";
    } else if (!empty($email)) {
        $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $email_error = "Email already exists";
        }
    }

    // Validate password
    if (empty($password)) {
        $password_error = "Password cannot be empty!";
    } else if (strlen($password) < 4) {
        $password_error = "Password should have more than 4 characters";
    }else if(!preg_match('#[0-9]+#',$_POST['password'])){
        $password_error ="password must contain atleast a number";
    }else if(!preg_match('#[A-Z]+#',$_POST['password'])){
        $password_error = "password must contain atleast a capital letter";
    }else if (!preg_match('#[a-z]+#',$_POST['password'])){
        $password_error ="password must contain atleast a small letter";
    }

 
    // Validate confirm password
    if (empty($confirmpassword)) {
        $confirmpassword_error = "Confirm Password cannot be empty!";
    } else if ($password !== $confirmpassword) {
        $confirmpassword_error = "Password and Confirm Password must match";
    }

    //Hash Password and Confirm Password
    $encpass = password_hash($password, PASSWORD_BCRYPT);
  
    if (empty($username_error) && empty($email_error) && empty($password_error) && empty($confirmpassword_error)) {
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $encpass);
        
        if ($stmt->execute()) {
            echo "<script>alert('You have successfully signed up');</script>";
        } else {
            echo "<script>alert('Failed to sign up: $conn->error');</script>";
        }
        
        $stmt->close();
    
        // Redirect to home.php
        header("Location: login.php");
        exit;
    
    }
}
#<?php  //echo $_SERVER['PHP_SELF']; ? 

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: rgb(2,0,36);
            background: linear-gradient(304deg, rgba(2,0,36,1) 0%, rgba(134,27,160,1) 0%, rgba(198,12,241,1) 42%, rgba(0,212,255,1) 100%); 
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #45a049;
            
        }
        .form-group button{
            scale:1.1;
            color: #fff;
            font-weight: bolder;
            text-align: center;
            margin-left: 100px;
        }
        p.error{
            color: red;
        }
    </style>
</head>
<body>

    <div class="form-container">
    <form action="<?php  echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="name" name="username" >
                <p class="error"><?php echo $username_error; ?></p><br> 

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" >
                <p class="error"><?php echo $email_error; ?></p><br>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
               <input type="password" id="password" name="password" >
               <p class="error"><?php echo $password_error; ?></p><br>
            </div>
            <div class="form-group">
                <label for="confirmpassword">Confirm Password:</label>
               <input type="password" id="confirmpassword" name="confirmpassword" >
               <p class="error"><?php echo $confirmpassword_error; ?></p><br>
            </div>
           

            <div class="form-group">
                <button type="submit" name="submit">Sign Up</button>
                
            </div>
        </form>
    </div>

</body>
</html>
