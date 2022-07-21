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
  <title>PostAd</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
  <link rel="icon" type="image/x-icon" href="images/favicon.ico">
  <style>
    body {
      background-color: #e5e7eb;
    }

    .navigation {
      background-color: #eaf6f7;
      position: sticky;
      box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
      top: 0;
      z-index: 100;
    }

    .button1 {
      background-color: #ff9f29;
      color: black;
    }

    .button1:hover {
      background-color: #ff5f00;
      font-weight: bold;
    }

    .nav-font {
      font-size: 20px;
      font-weight: bold;
    }

    #formContainer {
      width: 67%;
      background-color: white;
      /* height: 300px; */
      margin: 20px auto;
      border-radius: 10px;
      box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
      padding: 15px;
    }

    #postingRules {
      text-decoration: none;
      float: right;
    }

    #features,
    #description {
      border: 1px solid black;
      border-radius: 5px;
    }

    #price,
    #title {
      width: 417px;
    }

    .formPadding {
      padding-left: 250px;
    }

    .footer {
      text-align: center;
      padding: 50px auto;
    }

    #cat,
    #loc {
      padding-top: 20px;
    }

    #category,
    #location {
      width: 300px;
    }

    #con,
    #aut,
    #ngo {
      padding-top: 10px;
    }

    li {
      list-style-type: none;
      padding: 10px;
    }

    #sub {
      border: none;
      background-color: #ff9f29;
      border-radius: 10px;
      width: 100px;
      height: 40px;
    }

    #sub:hover {
      background-color: #ff5f00;
      border: 1px solid black;
      border-radius: 10px;
      font-weight: bold;
    }

    .popup {
      background: rgba(0, 0, 0, 0.6);
      width: 100%;
      height: 100%;
      position: absolute;
      top: 0;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .popup-content {
      height: 250px;
      width: 500px;
      background: white;
      padding: 20px;
      border-radius: 5px;
      position: relative;
    }

    .footer {
      background: #152F4F;
      color: white;
    }

    * {
      box-sizing: border-box;
    }

    .form {
      margin: 20px 0;
      padding: 0px 50px;
    }

    .form .grid {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      gap: 20px;
    }

    .form .grid .form-element {
      width: 130px;
      height: 130px;
      cursor: pointer;
      box-shadow: 0px 0px 20px 5px rgba(100, 100, 100, 0.1);
    }

    .form .grid .form-element input {
      display: none;
    }

    .form .grid .form-element img {
      width: 130px;
      height: 130px;
      cursor: pointer;
      object-fit: cover;
    }

    .form .grid .form-element div {
      position: relative;
      height: 40px;
      margin-top: -40px;
      background: rgba(0, 0, 0, 0.5);
      text-align: center;
      line-height: 40px;
      font-size: 13px;
      color: #f5f5f5;
      font-weight: 600;
    }

    .form .grid .form-element div span {
      font-size: 40px;
    }
  </style>
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

  <div class="container-fluid" id="formContainer">
    <div id="ff">
      <h5>Fill in the details</h5>
      <hr />
      <a href="#" id="postingRules"><small>See out posting rules</small></a>
      <form action="check.php" method="post" enctype="multipart/form-data">
        <div class="formPadding" style="padding-top: 50px">
          <div id="cat">
            <label for="category" style="padding-right: 20px">Caterory</label>
            <select name="category" id="category" required style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; border-radius: 5px;">
              <option value="" disabled selected hidden>Search</option>
              <option value="mobiles">Mobiles</option>
              <option value="electronics">Electronics</option>
              <option value="vehicles">Vehicles</option>
              <option value="home&living">Home & Living</option>
              <option value="pets&animals">Pets & Animals</option>
              <option value="property">Property</option>
              <option value="agriculture">Agriculture</option>
              <option value="jobs">Jobs</option>
            </select><br />
          </div>

          <div id="loc">
            <label for="location" style="padding-right: 20px">Location</label>
            <select name="location" id="location" required style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; border-radius: 5px;">
              <option value="" disabled selected hidden>Search</option>
              <option value="dhaka">Dhaka</option>
              <option value="chattogram">Chattogram</option>
              <option value="sylhet">Sylhet</option>
              <option value="khulna">Khulna</option>
              <option value="barishal">Barishal</option>
              <option value="rajshahi">Rajshahi</option>
              <option value="rangpur">Rangpur</option>
              <option value="mymensingh">Mymensingh</option>
            </select><br />
          </div>

          <div id="tit" style="padding-top: 20px;">
            <label for="title"><small>Title</small></label><br>
            <input type="text" id="title" name="title" required style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; border-radius: 5px;">
          </div>

          <div style="padding-top: 20px"><small>Condition</small></div>
          <div id="con">
            <input type="radio" id="used" name="condition" value="used" checked />
            <label for="used">Used</label>
            <input type="radio" id="new" name="condition" value="new" />
            <label for="new">New</label><br />
          </div>

          <div style="padding-top: 20px"><small>Authenticity</small></div>
          <div id="aut">
            <input type="radio" id="original" name="authenticity" value="original" checked />
            <label for="original">Original</label>
            <input type="radio" id="refurbished" name="authenticity" value="refurbished" />
            <label for="refurbished">Refurbished</label><br />
          </div>

          <div style="padding-top: 20px">
            <label for="features"><small>Features (optional)</small></label>
          </div>
          <textarea name="features" id="features" cols="55" rows="5" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; border-radius: 5px;"></textarea><br />

          <div style="padding-top: 20px">
            <label for="description"><small>Description</small></label>
          </div>
          <textarea name="description" id="description" cols="55" rows="5" required style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; border-radius: 5px;"></textarea><br />

          <div style="padding-top: 20px">
            <label for="price"><small>Price (Tk)</small></label>
          </div>
          <input type="number" name="price" id="price" required placeholder="Pick a good price - what would you pay?" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; border-radius: 5px;" /><br />

          <div style="padding-top: 20px"><small>Type</small></div>
          <div id="ngo">
            <input type="radio" id="nego" name="isNego" value="negotiable" />
            <label for="nego">Negotiable</label>
            <input type="radio" id="fixed" name="isNego" value="fixed" checked />
            <label for="fixed">Fixed</label><br />
          </div>
          <!-- <div style="padding-top: 20px">
            <input type="checkbox" id="isNego" name="isNego" />
            <label for="isNego"> Negotiable</label>
          </div> -->

          <div style="padding-top: 20px;">
            <label for="endDate"><small>The ad will show till:</small></label><br>
            <input type="date" id="endDate" name="endDate" min="<?php echo date("Y-m-d"); ?>" max="<?php echo date('Y-m-d', strtotime(date("Y-m-d") . ' + 1 years')); ?>" required style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; border-radius: 5px;">
          </div>
        </div>
        <hr />
        <div class="">
          <h6 style="text-align: center;">Add upto 5 photos</h6>

          <div class="form">
            <div class="grid">
              <div class="form-element">
                <input type="file" name="image1" id="image1" accept="image/*" required />
                <label for="image1" id="image1-preview">
                  <img src="https://bit.ly/3ubuq5o" alt="">
                  <div>
                    <span>+</span>
                  </div>
                </label>
              </div>
              <div class="form-element">
                <input type="file" name="image2" id="image2" accept="image/*" />
                <label for="image2" id="image2-preview">
                  <img src="https://bit.ly/3ubuq5o" alt="">
                  <div>
                    <span>+</span>
                  </div>
                </label>
              </div>
              <div class="form-element">
                <input type="file" name="image3" id="image3" accept="image/*" />
                <label for="image3" id="image3-preview">
                  <img src="https://bit.ly/3ubuq5o" alt="">
                  <div>
                    <span>+</span>
                  </div>
                </label>
              </div>
              <div class="form-element">
                <input type="file" name="image4" id="image4" accept="image/*" />
                <label for="image4" id="image4-preview">
                  <img src="https://bit.ly/3ubuq5o" alt="">
                  <div>
                    <span>+</span>
                  </div>
                </label>
              </div>
              <div class="form-element">
                <input type="file" name="image5" id="image5" accept="image/*" />
                <label for="image5" id="image5-preview">
                  <img src="https://bit.ly/3ubuq5o" alt="">
                  <div>
                    <span>+</span>
                  </div>
                </label>
              </div>
            </div>
          </div>

          <!-- <ul>
            <li>
              <input type="file" name="image1" id="image1" accept="image/*" required />
            </li>
            <li>
              <input type="file" name="image2" id="image2" accept="image/*" />
            </li>
            <li>
              <input type="file" name="image3" id="image3" accept="image/*" />
            </li>
            <li>
              <input type="file" name="image4" id="image4" accept="image/*" />
            </li>
            <li>
              <input type="file" name="image5" id="image5" accept="image/*" />
            </li>
          </ul> -->
        </div>
        <hr />
        <div class="formPadding">
          <h6>Contact Details</h6>
          <p>
            <small>Name</small><br />
            <span id="userName"><?php echo $_SESSION["username"] ?></span>
          </p>

          <p>
            <small>Email</small><br />
            <span id="userEmail"><?php echo $_SESSION["email"] ?></span>
          </p>

          <label for="phoneNo"><small>Add phone number</small></label><br />
          <input type="tel" name="phoneNo" id="phoneNo" required style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; border-radius: 5px;" /><br />
          <div style="padding-top: 20px">
            <input type="checkbox" id="termsAndConditions" onclick="ffun()" name="termsAndConditions" value="true" />
            <label for="termsAndConditions">
              I have read and accept the
              <a href="#" style="text-decoration: none">Terms and Conditions</a></label><br />
          </div>
          <div style="padding-top: 20px; padding-left: 375px">
            <input type="submit" id="sub" name="ppbutton" value="Post Ad" style="background: #ff9f29;" />
          </div>
        </div>
      </form>
    </div>
  </div>


  <script>
    function ffun() {
      var x = document.getElementById("sub");
      if (x.style.background === "#ff9f29") {
        x.style.background = "#ff5f00";
        x.style.fontWeight = "bold";
      } else {
        x.style.background = "#ff9f29";
      }
    }
  </script>

  <div class="mt-5 pt-5 pb-5 footer" style='border-radius: 10px 10px 0 0; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;'>
    <div class="container">
      <div class="row">
        <div class="col-lg-5 col-xs-12 about-company" style="text-align: left; padding-right: 50px;">
          <h2>About preOwned</h2>
          <p class="pr-5 text-white-50">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Hic sint tempore qui ratione dolor omnis iusto, fugit optio voluptates laudantium! Non tempore nam, molestias provident quod nemo ipsum error at ducimus autem voluptas iusto tempora harum nulla dolorem mollitia quam sed inventore, officia exercitationem placeat debitis illum ut! Voluptatum, saepe.</p>
          <p><a href="#"><i class="fa fa-facebook-square mr-1"><img src="images/fb1.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; display: inline-block; margin-right: 20px;"></i></a><a href="#"><i class="fa fa-linkedin-square"><img src="images/twitter.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; display: inline-block; margin-right: 20px;"></i></a><a href="#"><i class="fa fa-linkedin-square"><img src="images/insta.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; display: inline-block; margin-right: 20px;"></i></a></p>
        </div>
        <div class="col-lg-3 col-xs-12 links" style="text-align: left;">
          <h4 class="mt-lg-0 mt-sm-3">Links</h4>
          <ul class="m-0 p-0" style="text-align: left;">
            <li>- <a href="#">Home</a></li>
            <li>- <a href="#">About</a></li>
            <li>- <a href="#">Contact</a></li>
            <li>- <a href="#">FAQ</a></li>
          </ul>
        </div>
        <div class="col-lg-4 col-xs-12 location" style="text-align: left;">
          <h4 class="mt-lg-0 mt-sm-4">Location</h4>
          <br>
          <p><img src="images/locc.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 20px;"><span>67/9 Kamal Road</span>Uttara, Dhaka</p>
          <p class="mb-0"><i class="fa fa-phone mr-3"><img src="images/call.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 20px;">
            </i>+8801718478921</p>
          <br>
          <p><i class="fa fa-envelope-o mr-3"><img src="images/msg.png" alt="" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 20px;">
            </i><a id="eemail" href="mailto:preownedshop123@gmail.com">preownedshop123@gmail.com</a></p>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col copyright">
          <p class=""><small class="text-white-50">© 2019. All Rights Reserved.</small></p>
        </div>
      </div>
    </div>
  </div>


  <script>
    function previewBeforeUpload(id) {
      document.querySelector("#" + id).addEventListener("change", function(e) {
        if (e.target.files.length == 0) {
          return;
        }
        let file = e.target.files[0];
        let url = URL.createObjectURL(file);
        document.querySelector("#" + id + "-preview div").innerText = file.name;
        document.querySelector("#" + id + "-preview img").src = url;
      });
    }

    previewBeforeUpload("image1");
    previewBeforeUpload("image2");
    previewBeforeUpload("image3");
    previewBeforeUpload("image4");
    previewBeforeUpload("image5");
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>