<?php
//start session 
session_start();
include("php/config.php");
if(!isset($_SESSION['valid'])){
    header("Location: index.php");
    exit();
}

//database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=B2W", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

//fetch user's information
try {
    $id = $_SESSION['valid'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE Id=:id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $res_Uname = $result['Email'];
    $res_email = $result['Username'];
    $res_type = $result['Type'];
    $res_id = $result['Id'];
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Home</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <!-- B2W logo-->
            <p><a href="home.php">Logo</a></p>
        </div>
        <div class="right-links">
            <!--Edit their profile infomration-->
            <a href='edit.php?Id=<?php echo $res_id; ?>'> Profile</a>
            <!-- logout of their account, ends session-->
            <a href="logout.php"><button class="btn">Logout</button></a>
        </div>
    </div>
    <main>
        <div class="main-box top">
            <div class="top">
                <div class="box">
                    <!-- Welcome's user to their account-->
                    <p>Hello <b><?php echo $res_Uname; ?></b>, Welcome</p>
                </div>
                    <!-- User can review their order and check the order's status -->
                <div class="box">
                    <p>Check your order <b>status</b></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
