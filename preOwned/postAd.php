
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PostAd</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
  <style>
    body {
      background-color: #f9f9f9;
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
      margin-top: 20px;
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
    #aut, #ngo {
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
  </style>
</head>

<body>
<div class="navigation">
      <nav class="navbar navbar-expand-sm navbar-light" style="padding-top: 0px; padding-bottom: 0px;">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php"
            ><img src="images/logo2.png" alt="logo" width="150"
          /></a>
          <a class="nav-link nav-font navbar-nav" href="allads.php">All adds</a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div
            class="collapse navbar-collapse justify-content-end"
            id="navbarSupportedContent"
          >
            <ul class="navbar-nav nav-font">
              <li class="nav-item">
                <a class="nav-link" href="login.php" 
                  ><img
                    src="images/login.png"
                    alt="Login image"
                    width="30"
                  /><?php
                  if (isset($_SESSION["username"])) {
                    echo $_SESSION["username"];
                  }
                  else {
                    echo "Login";
                  }?></a
                >
              </li>

              <li class="nav-item">
                <a class="nav-link" href="register.php"
                  ><img
                    src="images/register.png"
                    alt="Register image"
                    width="25"
                  />Register</a
                >
              </li>

              <form action="check.php" method="POST">
              <li class="nav-item">
                <a class="nav-link" href="<?php 
                if(isset($_SESSION["username"])) echo "postAd.php";
                else echo "login.php" ?>"
                  ><button type="submit" name="postbutton" class="btn button1">
                    POST YOUR AD
                  </button></a
                >
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
            <select name="category" id="category" required>
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
            <select name="location" id="location" required>
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
            <input type="text" id="title" name="title" required>
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
          <textarea name="features" id="features" cols="55" rows="5"></textarea><br />

          <div style="padding-top: 20px">
            <label for="description"><small>Description</small></label>
          </div>
          <textarea name="description" id="description" cols="55" rows="5" required></textarea><br />

          <div style="padding-top: 20px">
            <label for="price"><small>Price (Tk)</small></label>
          </div>
          <input type="number" name="price" id="price" required placeholder="Pick a good price - what would you pay?" /><br />

          <div style="padding-top: 20px"><small>Type</small></div>
          <div id="ngo">
            <input type="radio" id="nego" name="isNego" value="negotiable" />
            <label for="nego">Negotiable</label>
            <input type="radio" id="fixed" name="isNego" value="fixed" checked/>
            <label for="fixed">Fixed</label><br />
          </div>
          <!-- <div style="padding-top: 20px">
            <input type="checkbox" id="isNego" name="isNego" />
            <label for="isNego"> Negotiable</label>
          </div> -->

          <div style="padding-top: 20px;">
            <label for="endDate"><small>The ad will show till:</small></label><br>
            <input type="date" id="endDate" name="endDate"  required>
          </div>
        </div>
        <hr />
        <div class="formPadding">
          <h6>Add upto 5 photos</h6>
          <ul>
            <li>
              <input type="file" name="image1" id="image1" accept="image/*" required/>
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
          </ul>
        </div>
        <hr />
        <div class="formPadding">
          <h6>Contact Details</h6>
          <p>
            <small>Name</small><br />
            <span id="userName"><?php echo $_SESSION["username"]?></span>
          </p>

          <p>
            <small>Email</small><br />
            <span id="userEmail"><?php echo $_SESSION["email"]?></span>
          </p>

          <label for="phoneNo"><small>Add phone number</small></label><br />
          <input type="tel" name="phoneNo" id="phoneNo" required /><br />
          <div style="padding-top: 20px">
            <input type="checkbox" id="termsAndConditions" name="termsAndConditions" value="true" />
            <label for="termsAndConditions">
              I have read and accept the
              <a href="#" style="text-decoration: none">Terms and Conditions</a></label><br />
          </div>
          <div style="padding-top: 20px; padding-left: 375px">
            <input type="submit" id="sub" name="ppbutton" value="Post Ad" />
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="footer">
    <hr />
    <small>Copywrite 2022 &copy; Theme Created By
      <span style="color: #ff9f29">Saimoon</span> All Rights Reserved.</small>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>