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
if (isset($_POST['logout'])) {
  unset($_SESSION["userid"]);
  unset($_SESSION["username"]);
  unset($_SESSION["email"]);
  unset($_SESSION["start"]);
?>
  <script>
    alert("Log out successfully!");
  </script>
<?php
  include 'index.php';
}
if (isset($_POST['udetails'])) {
  include 'dbconnect.php';
  $sqlq = "update registration set username='".$_POST['uname']."' where userid='".$_SESSION['userid']."'";
  $res = mysqli_query($con, $sqlq);
  $_SESSION['username'] = $_POST['uname'];
  include 'index.php';
}
if (isset($_POST['cpass'])) {
  include 'dbconnect.php';
  $sqlq = "select * from registration";
  $res = mysqli_query($con, $sqlq);
  $rescheck = mysqli_num_rows($res);
  if ($rescheck > 0) {
    $flag = true;
    while ($row = mysqli_fetch_assoc($res)) {
      if ($_POST['cur_pass'] == $row['password'] && $_SESSION['email'] == $row['email']) {
        $flag = false;
        if ($_POST['new_pass'] == $_POST['confirm_pass']) {
          ?>
          <script>
            isExecuted = confirm("Are you sure to change password?");
            if (isExecuted) {
              <?php 
                include 'dbconnect.php';
                $sql = "update registration set password='".$_POST['new_pass']."' where userid='".$_SESSION['userid']."'";
                $resq = mysqli_query($con, $sql);
                ?>
                <script>
                  alert("Password changed successfully");
                </script>
                <?php
                include 'index.php';
              ?>
            }
          </script>
          <?php
        }
        else {
          ?>
          <script>
            alert("New password and Confirm Password not match!!!");
          </script>
          <?php
        }
      }
    }
    if ($flag) {
      ?>
      <script>
        alert("Password not matched!!!");
      </script>
      <?php
    }
  } 
}
if (isset($_POST['daccount'])) {
  include 'dbconnect.php';
  $sqlq = "delete from registration where userid=".$_SESSION["userid"];
  $res = mysqli_query($con, $sqlq);
  unset($_SESSION["userid"]);
  unset($_SESSION["username"]);
  unset($_SESSION["email"]);
  ?>
  <script>
    alert("Account Deleted successfully!");
  </script>
  <?php
  include 'index.php';
}

?>