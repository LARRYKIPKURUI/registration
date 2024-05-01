  
<?php
    include("connection.php");

    ob_start(); // Start output buffering
    session_start();
    
    $username_error = "";
    $password_error = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST")  {
        $username = mysqli_real_escape_string ($conn,$_POST['username']);
        $password = $_POST['password'];
    
        // Validate username
        if (empty($username)) {
            $username_error = "Username cannot be empty!";
        } else if (strlen($username) < 5) {
            $username_error = "Username should have at least 5 characters";
        }
    
        // Validate password
        if (empty($password)) {
            $password_error = "Password cannot be empty!";
        } else if (strlen($password) < 4) {
            $password_error = "Password should have more than 4 characters";
        }
    
        // Use prepared statements to prevent SQL injection
        $sql = "SELECT username, password FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
    
        // Check if the statement preparation was successful
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);
    
            // Check if a user with the given username was found
            if ($user) {
                // Retrieve the hashed password from the database
                $hashed_password_from_db = $user["password"];
    
                // Check if the provided password matches the hashed password in the database
                if (password_verify($password, $hashed_password_from_db)) {
                    // Passwords match, proceed to set session
                    $sessionToken = bin2hex(random_bytes(32));
                    $_SESSION["username"] = $user["username"];
                   
                    header("Location: home.php");
                    exit();
                } else {
                    // Passwords don't match
                    $password_error = "Password does not match";
                }
            } else {
                // Username does not exist
                $username_error = "Username does not exist";
            }
    
            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Handle the case where the statement preparation failed
            echo "Error in SQL statement preparation: " . mysqli_error($conn);
        }
    
        // Close the database connection
        mysqli_close($conn);
    } 
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
    <form action="<?php # echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="name" name="username" >
                <p class="error"><?php echo $username_error; ?></p><br> 

            <div class="form-group">
                <label for="password">Password:</label>
               <input type="password" id="password" name="password" >
               <p class="error"><?php echo $password_error; ?></p><br>
            </div>
            <div class="form-group">
                <button type="submit" name="submit"> Log in</button>
                
            </div>
        </form>
    </div>

</body>
</html>
