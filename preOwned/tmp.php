<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>tmp_Ad</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/lightbox.min.css">
  <link rel="stylesheet" href="css/tmp.css">
  <script src="js/lightbox-plus-jquery.min.js"></script>
</head>

<body>
<div class="navigation">
    <nav class="navbar navbar-expand-sm navbar-light" style="padding-top: 0px; padding-bottom: 0px;">
      <div class="container-fluid">
        <form action="indeximg.php" method="POST">
          <button type="submit" class="navbar-brand" style="border: none;" name="home"><img src="images/logo2.png" alt="logo" width="150" /></button>
        </form>
        <a class="nav-link nav-font navbar-nav" href="<?php
                                                      if (isset($_SESSION["userid"])) echo "allads.php";
                                                      else echo "login.php";
                                                      ?>">All adds</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          <ul class="navbar-nav nav-font">
            <li class="nav-item">
              <a class="nav-link" href="<?php
                                        if (isset($_SESSION["username"])) echo "profile.php";
                                        else echo "login.php";
                                        ?>"><img src="images/login.png" alt="Login image" width="30" /><?php
                                                                                if (isset($_SESSION["username"])) {
                                                                                  echo $_SESSION["username"];
                                                                                } else {
                                                                                  echo "Login";
                                                                                } ?></a>
            </li>
            <!-- 
              <li class="nav-item">
                <a class="nav-link" href="register.php"
                  ><img
                    src="images/register.png"
                    alt="Register image"
                    width="25"
                  />Register</a
                >
              </li> -->

            <form action="check.php" method="POST">
              <li class="nav-item">
                <span class="nav-link"><button type="submit" name="postbutton" class="btn button1">
                    POST YOUR AD
                  </button></span>
              </li>
            </form>
          </ul>
        </div>
      </div>
    </nav>
  </div>

  <?php

  include 'dbconnect.php';
  $qq = "Select * from ads";
  $resqq = mysqli_query($con, $qq);
  $resqqcheck = mysqli_num_rows($resqq);
  if ($resqqcheck > 0) {
    while ($rowqq = mysqli_fetch_assoc($resqq)) {
      if (isset($_POST[$rowqq['ad_id']])) {
        $squeryfromregister = "Select * from registration where userid=" . $rowqq['user_id'];
        $resregis = mysqli_query($con, $squeryfromregister);
        $resregischeck = mysqli_num_rows($resregis);
        if ($resregischeck > 0) {
          $rowregi = mysqli_fetch_assoc($resregis);
          $pby = $rowregi['username'];
        }
        $phone = $rowqq['phone'];
        echo "<div class='container-fluid' id='ban'>
          <div id='details'>
            <div class='container-fluid'>" . $rowqq['cat'] . "</div>
            <div class='container-fluid' style='font-size: 35px'>" . $rowqq['title'] . "</div>
            <div class='container-fluid'>
              <div class='row'>
                <div id='location' class='col'>
                  <img src='images/location.png' alt='location image' width='20px' />
                  " . $rowqq['loc'] . "
                </div>
                <div id='mobileNo' class='col-3'>
                  <button id='mobileNoButton'>
                    <img src='images/mobile_image.png' alt='mobile image' width='25px' />
                    <div style='display: inline; padding-left: 5px;' id='mNo'>
                      Click to view
                    </div>
                  </button>
                </div>
              </div>
            </div>
            <hr />
            <div class='container-fluid'>
              <div class='row'>
                <div id='date' class='col'> Posted On : " . $rowqq['postDate'] . " &nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp Posted By : ".$pby."</div>
                <div id='price' class='col-4'>
                  <span>" . $rowqq['price'] . "</span>(
                  <span>" . $rowqq['isnego'] . "</span>
                  )
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class='container-fluid' id='adImages'>
          <div class='row'>
            <div class='col'>
              <div class='gallery'>
                <a href='" . $rowqq['img1'] . "' data-lightbox='mygallery' data-title='image1'><img src='" . $rowqq['img1'] . "' alt='no image' width='580px'></a>
              </div>
              <div class='gallery' style='padding-top: 20px;'>
                <a href='" . $rowqq['img2'] . "' data-lightbox='mygallery' data-title='image1'><img src='" . $rowqq['img2'] . "' alt='no image' width='142px'></a>
                <a href='" . $rowqq['img3'] . "' data-lightbox='mygallery' data-title='image1'><img src='" . $rowqq['img3'] . "' alt='no image' width='142px'></a>
                <a href='" . $rowqq['img4'] . "' data-lightbox='mygallery' data-title='image1'><img src='" . $rowqq['img4'] . "' alt='no image' width='142px'></a>
                <a href='" . $rowqq['img5'] . "' data-lightbox='mygallery' data-title='image1'><img src='" . $rowqq['img5'] . "' alt='no image' width='142px'></a>
              </div>
            </div>
            <div class='col-3' id='adSideDetails'>
              <div class='adSideSpec'>
                <span>Price:</span>
                <span style='padding-right: 5px; padding-left: 10px'>" . $rowqq['price'] . "</span>(
                <span>" . $rowqq['isnego'] . "</span>
                )
              </div>
              <div class='adSideSpec'>
                <span>Condition:</span>
                <span style='padding-right: 5px; padding-left: 10px'>" . $rowqq['con'] . "</span>
              </div>
              <div class='adSideSpec'>
                <span>Authenticity:</span>
                <span style='padding-right: 5px; padding-left: 10px'>" . $rowqq['aut'] . "</span>
              </div>
            </div>
          </div>
        </div>
        
        <div class='container-fluid' id='adDes'>
        <div class='row'>
          <div class='col'>
            <h5>Features</h5>
            <p>
              " . $rowqq['feature'] . "
            </p>
          </div>
        </div>
        <div class='row'>
          <div class='col'>
            <h5>Description</h5>
            <p>
              " . $rowqq['des'] . "
            </p>
          </div>
        </div>
      </div>

      

        ";
      }
    }
  }
  ?>

<script>
        document
          .getElementById('mobileNoButton')
          .addEventListener('click', displayMobileNo);

          function displayMobileNo() {
            document.getElementById('mNo').innerHTML = "<?php echo "$phone" ?>  ";
          }
      </script>

  <div class="footer">
    <hr />
    <small>Copywrite 2022 &copy; Theme Created By
      <span style="color: #ff9f29">Saimoon</span> All Rights Reserved.</small>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

</body>

</html>