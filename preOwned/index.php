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
      $q = "Delete from ads where endDate = '" . $expDate . "'";
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
  <title>preOwned</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/styles.css" />
  <link rel="icon" type="image/x-icon" href="images/favicon.ico">

</head>

<body>
  <div class="navigation">
    <nav class="navbar navbar-expand-sm navbar-light" style="padding-top: 0px; padding-bottom: 0px;">
      <div class="container-fluid">
        <form action="indeximg.php" method="POST">
          <button type="submit" class="navbar-brand" style="border: none;" name="home"><img src="images/logo2.png" alt="logo" width="150" style="border-radius: 50%;" /></button>
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
            <li class="nav-item">
              <a class="nav-link" href="adminlogin.php"><img src="images/login.png" alt="Login image" width="30" />Admin</a>
            </li>
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

  <div class="container-fluid" id="landingSection" style='border-radius: 10px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;'>
    <h3>Sell your used goods at resonable price...</h3>
    <h1>
      Search from the largest classifieds & Post<br />
      unlimited classifieds free!
    </h1>
    <div class="container-fluid">
      <div id="searchForm">
        <form action="allads.php" method="POST">
          <input type="text" name="sT" id="searchText" size="30" placeholder="What Are You Looking For..." />

          <select name="cT" id="category">
            <option value="" disabled selected hidden>Category</option>
            <option value="mobiles">Mobiles</option>
            <option value="electronics">Electronics</option>
            <option value="vehicles">Vehicles</option>
            <option value="home&living">Home & Living</option>
            <option value="pets&animals">Pets & Animals</option>
            <option value="property">Property</option>
            <option value="agriculture">Agriculture</option>
            <option value="jobs">Jobs</option>
          </select>

          <select name="lC" id="location">
            <option value="" disabled selected hidden>Location</option>
            <option value="dhaka">Dhaka</option>
            <option value="chattogram">Chattogram</option>
            <option value="sylhet">Sylhet</option>
            <option value="khulna">Khulna</option>
            <option value="barishal">Barishal</option>
            <option value="rajshahi">Rajshahi</option>
            <option value="rangpur">Rangpur</option>
            <option value="mymensingh">Mymensingh</option>
          </select>

          <input class="btn button1" type="submit" name='indexsearch' value="Search" />
        </form>
      </div>
    </div>
  </div>

  <form action="allads.php" method="POST">
    <div class="container-fluid" id="browseCategories">
      <h3><span style="color: #ff9f29;">Browse</span> Categories</h3>
      <hr id="browseCategorieshr1" />
      <hr id="browseCategorieshr2" />
      <div class="container" id="browseCategoriesTable" style='border-radius: 10px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;'>
        <div class="row">
          <button type="submit" name="c1" class="col bb" style="background-color: whitesmoke;">
            <a href="#">
              <img src="images/mobile.jpg" alt="Mobile images" style="width: 50px;" />
              <p>Mobiles</p>
            </a>
          </button>
          <button type="submit" name="c2" class="col bb">
            <a href="#">
              <img src="images/electronics.jpg" alt="Electronics images" style="width: 125px;" />
              <p>Electronics</p>
            </a>
          </button>
          <button type="submit" name="c3" class="col bb" style="background-color: whitesmoke;">
            <a href="#">
              <img src="images/vehicles.jpg" alt="Vehicles images" style="width: 65px;" />
              <p>Vehicles</p>
            </a>
          </button>
          <button type="submit" name="c4" class="col bb">
            <a href="#">
              <img src="images/home&living.jpg" alt="Home & Living images" style="width: 145px;" />
              <p>Home & Living</p>
            </a>
          </button>
        </div>
        <div class="row">
          <button type="submit" name="c5" class="col bb">
            <a href="#">
              <img src="images/pets&animals.jpg" alt="Pets & Animals images" style="width: 100px;" />
              <p>Pets & Animals</p>
            </a>
          </button>
          <button type="submit" name="c6" class="col bb" style="background-color: whitesmoke;">
            <a href="#">
              <img src="images/property.jpg" alt="Property images" style="width: 130px;" />
              <p>Property</p>
            </a>
          </button>
          <button type="submit" name="c7" class="col bb">
            <a href="#">
              <img src="images/agriculture.jpg" alt="Agriculture images" style="width: 65px;" />
              <p>Agriculture</p>
            </a>
          </button>
          <button type="submit" name="c8" class="col bb" style="background-color: whitesmoke;">
            <a href="#">
              <img src="images/jobs.png" alt="Jobs images" style="width: 100px;" />
              <p>Jobs</p>
            </a>
          </button>
        </div>
      </div>
    </div>
  </form>

  <form action="allads.php" method="POST">
    <div class="container-fluid" id="adsByLocations">
      <h3>Ads <span style="color: #ff9f29;">By</span> Locations</h3>
      <hr id="browseCategorieshr1" />
      <hr id="browseCategorieshr2" />
      <p id="adsByLocationsMessages">Find items in your city and nearby by searching items by location</p>
      <div class="container" id="adsByLocationsTable" style='border-radius: 10px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;'>
        <div class="row">
          <button type="submit" name="l1" class="col bb" style="background-color: whitesmoke;">
            <a href="#">
              <img src="images/dhaka.jpg" alt="Dhaka city image" style="width: 260px;" />
              <p>Dhaka</p>
            </a>
          </button>
          <button type="submit" name="l2" class="col bb">
            <a href="#">
              <img src="images/chattogram.jpg" alt="Chattogram city image" style="width: 260px;" />
              <p>Chattogram</p>
            </a>
          </button>
          <button type="submit" name="l3" class="col bb" style="background-color: whitesmoke;">
            <a href="#">
              <img src="images/sylhet.jpg" alt="Sylhet city image" style="width: 260px;" />
              <p>Sylhet</p>
            </a>
          </button>
          <button type="submit" name="l4" class="col bb">
            <a href="#">
              <img src="images/khulna.jpg" alt="Khulna city image" style="width: 260px;" />
              <p>Khulna</p>
            </a>
          </button>
        </div>
        <div class="row">
          <button type="submit" name="l5" class="col bb">
            <a href="#">
              <img src="images/barishal.jpg" alt="Barishal city image" style="width: 260px;" />
              <p>Barishal</p>
            </a>
          </button>
          <button type="submit" name="l6" class="col bb" style="background-color: whitesmoke;">
            <a href="#">
              <img src="images/rajshahi.jpg" alt="Rajshashi city image" style="width: 260px;" />
              <p>Rajshahi</p>
            </a>
          </button>
          <button type="submit" name="l7" class="col bb">
            <a href="#">
              <img src="images/rangpur.jpg" alt="Rangpur city image" style="width: 260px;" />
              <p>Rangpur</p>
            </a>
          </button>
          <button type="submit" name="l8" class="col bb" style="background-color: whitesmoke;">
            <a href="#">
              <img src="images/mymensingh.jpg" alt="Mymensingh city image" style="width: 260px;" />
              <p>Mymensingh</p>
            </a>
          </button>
        </div>
      </div>
    </div>
  </form>

  <div class="container-fluid border" id="howItWorks">
    <h3>How It <span style="color: #ff9f29;">Works</span></h3>
    <hr id="browseCategorieshr1" />
    <hr id="browseCategorieshr2" />
    <p id="howItWorksMessages">Simple three steps to get your deal done!</p>
    <div class="container" id="howItWorksTable" style='border-radius: 10px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;'>
      <div class="row">
        <div class="col" style="background-color: whitesmoke;">
          <a href="#">
            <img src="images/ca.jpg" alt="Mobile images" style="width: 300px;" />
            <h6>Create Account</h6>
            <p>Simple way to create your account. It's free to create new account. Create account to post ads.</p>
          </a>
        </div>
        <div class="col">
          <a href="#">
            <img src="images/hanshake1.jpg" alt="Electronics images" style="width: 300px;" />
            <h6>Get Deal</h6>
            <p>Get your best deal searching by categories or locations. It's easy to search items also by keyword. And grab the best deal for you. You can post your ads too and get them sold.</p>
          </a>
        </div>
        <div class="col" style="background-color: whitesmoke;">
          <a href="#">
            <img src="images/done.jpg" alt="Vehicles images" style="width: 300px;" />
            <h6>You're Done!</h6>
            <p>After completing these two steps your work is done. Contact with seller or customer and grab your deal.</p>
          </a>
        </div>

      </div>
    </div>

    <div class="mt-5 pt-5 pb-5 footer" style='border-radius: 10px 10px 0 0; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;'>
      <div class="container">
        <div class="row">
          <div class="col-lg-5 col-xs-12 about-company" style="text-align: left; padding-right: 50px;">
            <h2>About preOwned</h2>
            <p class="pr-5 text-white-50" style="text-align: left;">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Hic sint tempore qui ratione dolor omnis iusto, fugit optio voluptates laudantium! Non tempore nam, molestias provident quod nemo ipsum error at ducimus autem voluptas iusto tempora harum nulla dolorem mollitia quam sed inventore, officia exercitationem placeat debitis illum ut! Voluptatum, saepe.</p>
            <p><a href="#"><img src="images/fb1.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; display: inline-block; margin-right: 20px;"></a><a href="#"><img src="images/twitter.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; display: inline-block; margin-right: 20px;"></a><a href="#"><img src="images/insta.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; display: inline-block; margin-right: 20px;"></a></p>
          </div>
          <div class="col-lg-3 col-xs-12 links" style="text-align: left;">
            <h4 class="mt-lg-0 mt-sm-3">Links</h4>
            <ul class="m-0 p-0" style="text-align: left; list-style-type: none;">
              <li>- <a href="#" style="color: white;">Home</a></li>
              <li>- <a href="#" style="color: white;">About</a></li>
              <li>- <a href="#" style="color: white;">Contact</a></li>
              <li>- <a href="#" style="color: white;">FAQ</a></li>
            </ul>
          </div>
          <div class="col-lg-4 col-xs-12 location" style="text-align: left;">
            <h4 class="mt-lg-0 mt-sm-4" style="text-align: left;">Location</h4>
            <p style="text-align: left;"><img src="images/locc.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; display: inline-block; margin-right: 20px;"><span>67/9 Kamal Road, Rashed residential area,</span>Uttara, Dhaka</p>
            <p class="mb-0" style="text-align: left;"><img src="images/call.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; display: inline-block; margin-right: 20px; ">
              +8801718478921</p>
            <br>
            <p style="text-align: left;"><img src="images/msg.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; display: inline-block; margin-right: 20px;">
              <a style="color: white;" id="eemail" href="mailto:preownedshop123@gmail.com">preownedshop123@gmail.com</a>
            </p>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col copyright">
            <p class=""><small class="text-white-50">© 2019. All Rights Reserved.</small></p>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>