<?php 
$connection = new mysqli("localhost", "root", "Whatpass@1113", "task2",3307);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $qry=$connection->prepare("SELECT * FROM users WHERE username=?");
    $qry->bind_param("s",$username);
    $qry->execute();
    $result=$qry->get_result();
    if($result->num_rows>0){
        echo $result->num_rows;
        echo "Username already exists!";
        exit();
    }
    //stop
    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // $hashed_password=md5($password);
        $stmt = $connection->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();
        $stmt->close();
        echo "Registration successful!";
        echo "<script>window.location.href='login.php';</script>";
    } else {
        echo "Passwords do not match!";
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>
        body {
            background-color: #0e0e0e;
        }
        h1 {
            color: white;
        }
        label {
            color: white;
        }
        href {
            color: white;
        }
    </style>
    <div class="container">
        <form action="" method="post">
        <h1>register</h1>
        <label for="username">Username:</label>
        <br>
        <input type="text" id="username" name="username" placeholder="eg abcadmin">
        <br>
        <label for="password">Password:</label>
        <br>
        <input type="password" id="password" oninput="checkpasswords()" name="password" placeholder="eg abc123">
        <br>
        <label for="confirm_password">Confirm Password:</label>
        <br>
        <input type="password" id="confirm_password" oninput="checkpasswords()" name="confirm_password" >
        <br>
        <p id="message"></p>

        <button type="submit">register</button>
        </form>
        <br>
        <a href="login.php"> already have an account? click me to login</a>
    </div>

    <script>
        const button=document.querySelector("button");
        function checkpasswords(){
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            const message = document.getElementById("message");

            if(password == confirmPassword){
                message.style.color = "green";
                message.textContent = "Passwords match";
            } else {
                message.style.color = "red";
                message.textContent = "Passwords do not match";
            }
        }
    </script>
    
</body>
</html>