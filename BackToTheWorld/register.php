<?php
//includes config
include("php/config.php");

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $type = $_POST['Customer'];

    try {
        //verify email
        $verify_query = $pdo->prepare("SELECT Email FROM users WHERE Email = :email");
        $verify_query->bindParam(':email', $email);
        $verify_query->execute();

        if($verify_query->rowCount() != 0){
            echo "<div class='message'>
                    <p>This email is used, Please try another one</p>
                  </div><br>";
            echo "<a href='javascript:self.history.back()'><button class='btn'>Go back</button>";
        } else {
            //insert new user to users table in b2w database
            $insert_query = $pdo->prepare("INSERT INTO users(Username, Email, Type, Password) VALUES(:username, :email, :type, :password)");
            $insert_query->bindParam(':username', $username);
            $insert_query->bindParam(':email', $email);
            $insert_query->bindParam(':type', $type);
            $insert_query->bindParam(':password', $password);
            $insert_query->execute();
            //once data is added, message confirms successful registration 
            echo "<div class='message'>
                    <p>Registration Successful!</p>
                  </div><br>";
            echo "<a href='index.php'><button class='btn'>Login</button>";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Signup</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Sign Up</header>
            <form action="" method="post">
                <!--Username field-->
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>
                <!--Email field-->
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>
                <!--Customer type field
                    B2W services caters to indivdual household and business who want to recycle used oils-->
                <div class="field input radio">
                    <p>Which type of customer are you?</p>
                    <input type="radio" name="Customer" id="IndividualHousehold" value="Individual Household">
                    <label for="IndividualHousehold">Individual Household</label><br>
                    <input type="radio" name="Customer" id="Enterprise" value="Enterprise">
                    <label for="Enterprise">Enterprise</label><br>
                </div>
                <!--Password field-->
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
                <!--Submit button-->
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Signup">
                </div>
                <!--Login link-->
                <div class="links">
                    Already have an account? <a href="index.php">Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
