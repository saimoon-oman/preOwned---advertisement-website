

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>preOwned</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/styles.css" />
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

  <div class="container-fluid" id="landingSection">
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
      <div class="container" id="browseCategoriesTable">
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
      <div class="container" id="adsByLocationsTable">
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
    <div class="container" id="howItWorksTable">
      <div class="row">
        <div class="col" style="background-color: whitesmoke;">
          <a href="#">
            <img src="images/mobile.jpg" alt="Mobile images" style="width: 50px;" />
            <h6>Create Account</h6>
            <p>Simple way to create your account. It's free to create new account. Create account to post ads.</p>
          </a>
        </div>
        <div class="col">
          <a href="#">
            <img src="images/electronics.jpg" alt="Electronics images" style="width: 125px;" />
            <h6>Get Deal</h6>
            <p>Get your best deal searching by categories or locations. It's easy to search items also by keyword. And grab the best deal for you. You can post your ads too and get them sold.</p>
          </a>
        </div>
        <div class="col" style="background-color: whitesmoke;">
          <a href="#">
            <img src="images/vehicles.jpg" alt="Vehicles images" style="width: 65px;" />
            <h6>You're Done!</h6>
            <p>After completing these two steps your work is done. Contact with seller or customer and grab your deal.</p>
          </a>
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