<?php
//session start
session_start();
include("php/config.php");

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $type = $_POST['Customer'];

    try {
        //Update user profile
        $update_query = $pdo->prepare("UPDATE users SET Username = :username, Email = :email, Type = :type WHERE Id = :id");
        $update_query->bindParam(':username', $username);
        $update_query->bindParam(':email', $email);
        $update_query->bindParam(':type', $type);
        $update_query->bindParam(':id', $_SESSION['valid_id']);
        $update_query->execute();

        //redirect to homepage after successful update
        header("Location: homepage.php");
        exit();
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
    <link rel="stylesheet" href="style.css">
    <title>Profile</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="homepage.php">Logo</a></p>
        </div>
        <div class="right-links">
            <a href="a"> Profile</a>
            <a href="logout.php"><button class="btn">Logout</button></a>
        </div>
    </div>
    <div class="container">
        <div class="box form-box">
            <!--Allows users to update or make changes to their account information and updated the database-->
            <header>Change Profile</header>
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
                <!--Customer type field-->
                <div class="field input">
                    <p>Which type of customer are you?</p>
                    <input type="radio" name="Customer" id="IndividualHousehold" value="Individual Household">
                    <label for="IndividualHousehold">Individual Household</label><br>
                    <input type="radio" name="Customer" id="Enterprise" value="Enterprise">
                    <label for="Enterprise">Enterprise</label><br>
                </div>
            
                <!--Submit button-->
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Update" required>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
