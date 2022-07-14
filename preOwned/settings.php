<?php
session_start();
?>
<?php
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
if (isset($_POST['logout'])) {
  
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>preOwned</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/settings.css" />
</head>

<body>
  <div class="navigation">
    <nav class="navbar navbar-expand-sm navbar-light" style="padding-top: 0px; padding-bottom: 0px;">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img src="images/logo2.png" alt="logo" width="150" /></a>
        <a class="nav-link nav-font navbar-nav" href="allads.php">All adds</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          <ul class="navbar-nav nav-font">
            <li class="nav-item">
              <a class="nav-link" href="login.php"><img src="images/login.png" alt="Login image" width="30" /><?php
                                                                                                              if (isset($_SESSION["username"])) {
                                                                                                                echo $_SESSION["username"];
                                                                                                              } else {
                                                                                                                echo "Login";
                                                                                                              } ?></a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="register.php"><img src="images/register.png" alt="Register image" width="25" />Register</a>
            </li>

            <form action="check.php" method="POST">
              <li class="nav-item">
                <a class="nav-link" href="<?php
                                          if (isset($_SESSION["username"])) echo "postAd.php";
                                          else echo "login.php" ?>"><button type="submit" name="postbutton" class="btn button1">
                    POST YOUR AD
                  </button></a>
              </li>
            </form>
          </ul>
        </div>
      </div>
    </nav>
  </div>


  <div class="container" id="container_id">
    <div class="row">
      <div class="col-3" id="column1">
        <p style="font-size: 1.5rem;">Account</p>
        <hr>
        <a href="profile.php">My Account</a>
        <hr>
        <a href="settings.php" style="font-weight: bold;">Settings</a>
        <hr>
        <br>
        <br>
        <br>
        <br>
        <form action="settings.php" method="POST">
          <button type="submit" name="logout" class="btn button1" style="display:block; width: auto; margin: auto;">Log Out</button>
        </form>
      </div>

      <div class="col" id="column2">
        <p style="font-size: 1.2rem; padding-left: 15px;">Settings</p>
        <hr>
        <p style="font-size: 1.2rem; padding-left: 15px;">Change details</p>
        <div id="ud">
          <p><span style="margin-right: 5px;">Email: </span> <?php echo $_SESSION['email']; ?></p><br>
          <form action="settings.php" method="POST">
            <span>Name</span><br><br>
            <input style="border: none; border-radius: 5px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; width: 300px;" type="text" name="uname" value="<?php echo $_SESSION['username']; ?>">
            <br>
            <br>
            <br>
            <br>
            <br>
            <button type="submit" name="udetails" class="btn button1">Update details</button>
          </form>
          <br>
          <br>
          <br>
          <p style="font-size: 1.2rem;">Change Password</p>
          <form action="settings.php" method="POST">
            <input style="border: none; border-radius: 5px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; width: 300px;" type="password" name="cur_pass" placeholder="Current password"><br><br><br>
            <input type="password" style="border: none; border-radius: 5px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; width: 300px;" name="new_pass" placeholder="New password"><br><br><br>
            <input type="password" style="border: none; border-radius: 5px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; width: 300px;" name="confirm_pass" placeholder="Confirm password"><br><br><br><br>

            <button type="submit" name="cpass" class="btn button1">Change Password</button>
          </form>
          <hr>
          <form action="settings.php" method="POST">
            <button type="submit" name="daccount" class="btn button1">Delete Account</button>
            <button type="submit" name="logout" class="btn button1">Log Out</button>
          </form>

        </div>
      </div>
    </div>
  </div>

  <div class="footer">
    <hr>
    <small>Copywrite 2022 &copy; Theme Created By <span style="color: #ff9f29;">Saimoon</span> All Rights Reserved.</small>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>