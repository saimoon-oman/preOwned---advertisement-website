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
session_start();
?>
<?php
if (isset($_POST['login'])) {
  include 'dbconnect.php';
  $username = mysqli_real_escape_string($con, $_POST['username']);
  $password = mysqli_real_escape_string($con, $_POST['password']);


  $query = "Select * from admin_registration where username='$username' and password='$password'";
  $result = mysqli_query($con, $query);
  $resultcount = mysqli_num_rows($result);

  if ($resultcount > 0) {
?>
    <script>
      alert("Login successful");
    </script>
  <?php
    $fquery = "Select * from registration where username='$username' and password='$password'";
    $res = mysqli_query($con, $fquery);
    $row = mysqli_fetch_assoc($res);
    $_SESSION["adminuserid"] = $row['userid'];
    $_SESSION["adminusername"] = $username;
    $_SESSION["adminemail"] = $row['email'];
    include 'adminindex.php';
    
  } else {
  ?>
    <script>
      alert("User doesn't exists");
    </script>
<?php
    include 'adminlogin.php';
    
  }
}
?>

<?php

if (isset($_POST['register'])) {
  include 'dbconnect.php';
  $username = mysqli_real_escape_string($con, $_POST['username']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $password = mysqli_real_escape_string($con, $_POST['password']);

  $emailquery = "Select * from admin_registration where email='$email'";
  $query = mysqli_query($con, $emailquery);

  $emailcount = mysqli_num_rows($query);

  if ($emailcount > 0) {
?>
    <script>
      alert("Email already exists");
    </script>
    <?php
    include 'adminregister.php';
  } else {

    $insertquery = "insert into admin_registration (username, email, password) values ('$username', '$email', '$password')";
    $iquery = mysqli_query($con, $insertquery);

    if ($iquery) {
    ?>
      <script>
        alert("Registration successful!");
      </script>
      <?php
      $fquery = "Select * from admin_registration where username='$username' and email='$email' and password='$password'";
      $res = mysqli_query($con, $fquery);
      $row = mysqli_fetch_assoc($res);

      $_SESSION["adminuserid"] = $row['userid'];
      $_SESSION["adminusername"] = $username;
      $_SESSION["adminemail"] = $email;


      $to_email = $_SESSION["adminemail"];
      $subject = "Payment to preOwned successful";
      $body = "Hello " . $_SESSION['adminusername'] . ", 
       
    
    Welcome as admin in preOwned 😊";


      $headers = "From: preownedshop123@gmail.com";

      if (mail($to_email, $subject, $body, $headers)) {
      
      } else {
        echo "Email sending failed...";
      }
      include 'adminindex.php';
    } else {
      ?>
      <script>
        alert("Registration not successful!");
      </script>
<?php
      include 'adminregister.php';
    }
  }
}
?>