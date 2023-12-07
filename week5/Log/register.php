<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Vegetable Market</title>
    <link rel="stylesheet" href="../CSS/veggies.css?v=<?php echo time(); ?>">
</head>
<body>
  <div class="container">
  <?php
  session_start();
  include "../Database/database.php";

  if($_SERVER["REQUEST_METHOD"]=== "POST")
  {
    $username=$_POST["username"];
    $password=$_POST["password"];

    try
    {
      $conn=new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $checkStmt= $conn->prepare("SELECT * FROM users WHERE username= :username");
      $checkStmt->bindParam(':username', $username);
      $checkStmt->execute();

      if($checkStmt->rowCount()>0)
      {
        echo "Username already exists!";

      }else 
      {
        $hashedPassword=password_hash($password, PASSWORD_DEFAULT);

        $insertStmt= $conn->prepare("INSERT INTO users (username, password) VALUES(:username,:password)");
        $insertStmt->bindParam(':username', $username);
        $insertStmt->bindParam(':password',$hashedPassword);
        $insertStmt->execute();

        $_SESSION['username']= $username;
        header("Location:../Pages/menu.html");
        exit();
      }
    }catch (PDOException $e)
    {
      echo "Error:". $e->getMessage();
    }
  }
  ?>

  <form action="../Pages/register.html">
    <button type="submit">Back</button>
  </form>
  </div>
</body>
</html>