<?php

?>



<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home Page</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: linear-gradient(304deg, rgba(2,0,36,1) 0%, rgba(134,27,160,1) 0%, rgba(198,12,241,1) 42%, rgba(0,212,255,1) 100%);
                margin: 0;
                padding: 0;
            }

            .container {
                max-width: 800px;
                margin: 50px auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }

            h1 {
                color: #333;
            }
            a{
                color: white;

            }
            a :hover{
                color:blue;
                background-color: #007bff;
            }
            p {
                color: #666;
                margin-bottom: 20px;
            }

            button {
                background-color: #007bff;
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            button:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Welcome to Our Website!</h1>
            <p>This is a simple home page created using HTML and CSS.</p>
            <form action="" method="post">
                <button type="submit"><a href="logout.php">Log out</a></button>
            </form>
        </div>
    </body>
    </html>



  


    