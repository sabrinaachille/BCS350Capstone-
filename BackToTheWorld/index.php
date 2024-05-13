<?php
//start a session
session_start();

//set a cookie
$cookie_name = "user";
$cookie_value = "John Doe";
//cookie expires in an hour
setcookie($cookie_name, $cookie_value, time() + 3600, "/");

//funtcion to sanitize useer input
function sanitize($data) {
    //removes whitespace from the beginning and end of the string
    $data = trim($data);
    //remove backslashes
    $data = stripslashes($data);
    //convert special characters to HTML entities
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <!-- Login Page prompts user to enter username and password -->
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <?php
                //includes config file
                include("php/config.php");
                
                if(isset($_POST['submit'])){
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    try {
                        //sanitize data
                        $email = sanitize($_POST['email']);
                        $password = sanitize($_POST['password']);

                        //create an instance of pdo interface
                        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        //execute SQL statement
                        $stmt = $pdo->prepare("SELECT * FROM users WHERE Email = :email AND Password = :password");
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':password', $password);
                        $stmt->execute();

                        //fetch result
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        //if username and password is valid, set session variables and redirect to homepage
                        if($row){ 
                            $_SESSION['valid_username'] = $row['Username'];
                            $_SESSION['valid_email'] = $row['Email'];
                            $_SESSION['valid_type'] = $row['Type'];
                            $_SESSION['valid_id'] = $row['Id'];

                            header("Location: homepage.php");
                            //prevent further execution
                            exit(); 
                        //if user does not exist, prints following error message
                        } else {
                            echo "<div class='message'>
                                    <p>Wrong Username or Password</p>
                                </div><br>";
                            echo "<a href='index.php'><button class='btn'>Go back</button>";
                        }
                    } catch(PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
            ?>

            <header>Login</header>
            <form action="" method="post">
                <!--Email field-->
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <!--Password field-->
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <!--Submit button-->
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login">
                </div>
                <!--Register link, if user wants to sign up for an account-->
                <div class="links">
                    Don't have an account? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
