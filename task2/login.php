    <?php 
    $connection = new mysqli("localhost", "root", "Whatpass@1113", "task2",3307);
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $username= $_POST["username"];
            $password=$_POST["password"];

            

            
            $qry=$connection->prepare("SELECT * FROM users WHERE username=?");
            $qry->bind_param("s",$username);
            $qry->execute();
            $result=$qry->get_result();
            if($result->num_rows>0){
                $user = $result->fetch_assoc();
                
                if (password_verify($password, $user['password'])) {
                    $_SESSION["username"]=$user["username"];
                    $_SESSION["user_id"]=$user["id"];
                    
                    echo "<script>alert('Login successful');
                    window.location.href='register.php';
                   
                    </script>";
                } else {
                    echo "Login failed";
                }
            }
        }  
        
    ?>




<!DOCTYPE html>
<html lang="en">
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
     </style>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
   
    <div class="container">
        <h1>Login</h1>
        <div class="card">
            <form action="login.php" method="post">

                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password">
                </div>
                <a href="register.php">Don't have an account? Register here</a><br>
               <button type="submit" name="login">Login</button>
            </form>
            
        </div>
    </div>
</body>
</html>