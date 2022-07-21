<?php
include 'dbconnect.php';
$query = "Select * from ads";
$res = mysqli_query($con, $query);
$rescheck = mysqli_num_rows($res);
if ($rescheck > 0) {
  while ($row = mysqli_fetch_assoc($res)) {
    $expDate = $row['endDate'];
    $today = date("Y-m-d");
    
    $today_time = strtotime($today);
    $expire_time = strtotime($expDate);

    if ($expire_time < $today_time) { 
      $q = "Delete from ads where endDate = '".$expDate."'";
      $res1 = mysqli_query($con, $q);
    }
  }
}
?>
<?php
if (isset($_SESSION["start"])) { if( time() > $_SESSION["start"]) {
  unset($_SESSION["userid"]);
  unset($_SESSION["username"]);
  unset($_SESSION["email"]);
  unset($_SESSION["start"]);
  ?>
  <script>
    alert("Session is automatically destroyed after 15 minutes");
  </script>
  <?php
} }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/login.css" />
  <link rel="icon" type="image/x-icon" href="images/favicon.ico">
  <title>Register</title>
  <style>
    body {
      background-image: url("bg123.jpg");
      background-size: cover;
      background-repeat: no-repeat;
    }
  </style>
</head>

<body>
  <div class="container">
    <h3>Register</h3>
    <form action="check.php" method="POST">
      <input type="text" name="username" placeholder="Username" required />
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit" class="btn" name="register">Register</button>
    </form>
    <p><small>Have an account? <a href="login.php">LogIn here</a>.</small></p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>