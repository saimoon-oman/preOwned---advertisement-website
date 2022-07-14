<?php
session_start();
?>
<?php
if (isset($_POST['login'])) {
  include 'dbconnect.php';
  $username = mysqli_real_escape_string($con, $_POST['username']);
  $password = mysqli_real_escape_string($con, $_POST['password']);


  $query = "Select * from registration where username='$username' and password='$password'";
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
    include 'index.php';
    $_SESSION["userid"] = $row['userid'];
    $_SESSION["username"] = $username;
    $_SESSION["email"] = $row['email'];
  } else {
  ?>
    <script>
      alert("User doesn't exists");
    </script>
<?php
    include 'login.php';
  }
}
?>

<?php

if (isset($_POST['register'])) {
  include 'dbconnect.php';
  $username = mysqli_real_escape_string($con, $_POST['username']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $password = mysqli_real_escape_string($con, $_POST['password']);

  $emailquery = "Select * from registration where email='$email'";
  $query = mysqli_query($con, $emailquery);

  $emailcount = mysqli_num_rows($query);

  if ($emailcount > 0) {
?>
    <script>
      alert("Email already exists");
    </script>
    <?php
    include 'register.php';
  } else {

    $insertquery = "insert into registration (username, email, password) values ('$username', '$email', '$password')";
    $iquery = mysqli_query($con, $insertquery);

    if ($iquery) {
    ?>
      <script>
        alert("Registration successful!");
      </script>
    <?php
      $fquery = "Select * from registration where username='$username' and email='$email' and password='$password'";
      $res = mysqli_query($con, $fquery);
      $row = mysqli_fetch_assoc($res);
      include 'index.php';
      $_SESSION["userid"] = $row['userid'];
      $_SESSION["username"] = $username;
      $_SESSION["email"] = $email;
    } else {
    ?>
      <script>
        alert("Registration not successful!");
      </script>
<?php
      include 'register.php';
    }
  }
}
?>

<?php
if (isset($_POST['postbutton'])) {
  if (isset($_SESSION["username"])) {
    include 'postAd.php';
  } else {
?>
    <script>
      alert("Please Login!!");
    </script>
<?php
    include 'login.php';
  }
}
?>
<?php
if (isset($_POST['ppbutton'])) {
  include 'dbconnect.php';
  $uid = mysqli_real_escape_string($con, $_SESSION["userid"]);
  $category = mysqli_real_escape_string($con, $_POST['category']);
  $location = mysqli_real_escape_string($con, $_POST['location']);
  $title = mysqli_real_escape_string($con, $_POST['title']);
  $condition = mysqli_real_escape_string($con, $_POST['condition']);
  $authenticity = mysqli_real_escape_string($con, $_POST['authenticity']);
  $features = mysqli_real_escape_string($con, $_POST['features']);
  $description = mysqli_real_escape_string($con, $_POST['description']);
  $price = mysqli_real_escape_string($con, $_POST['price']);
  $isNego = mysqli_real_escape_string($con, $_POST['isNego']);
  $endDate = mysqli_real_escape_string($con, $_POST['endDate']);
  $image1 = $_FILES['image1'];
  $image2 = $_FILES['image2'];
  $image3 = $_FILES['image3'];
  $image4 = $_FILES['image4'];
  $image5 = $_FILES['image5'];
  $phoneNo = mysqli_real_escape_string($con, $_POST['phoneNo']);
  date_default_timezone_set('Asia/Dhaka');
  $postDate = mysqli_real_escape_string($con, date("Y-m-d h:ia"));

  $image1name = $image1['name'];
  $image1error = $image1['error'];
  $image1tmp = $image1['tmp_name'];

  $image1ext = explode('.', $image1name);
  $image1check = strtolower(end($image1ext));
  $extstored = array('png', 'jpg', 'jpeg');

  if (in_array($image1check, $extstored)) {

    $destinationfile1 = 'upload/' . $image1name;
    move_uploaded_file($image1tmp, $destinationfile1);

    $image1 = $destinationfile1;
  } else $image1 = "";

  $image2name = $image2['name'];
  $image2error = $image2['error'];
  $image2tmp = $image2['tmp_name'];

  $image2ext = explode('.', $image2name);
  $image2check = strtolower(end($image2ext));

  if (in_array($image2check, $extstored)) {

    $destinationfile2 = 'upload/' . $image2name;
    move_uploaded_file($image2tmp, $destinationfile2);
    $image2 = $destinationfile2;
  } else $image2 = "";

  $image3name = $image3['name'];
  $image3error = $image3['error'];
  $image3tmp = $image3['tmp_name'];

  $image3ext = explode('.', $image3name);
  $image3check = strtolower(end($image3ext));

  if (in_array($image3check, $extstored)) {

    $destinationfile3 = 'upload/' . $image3name;
    move_uploaded_file($image3tmp, $destinationfile3);
    $image3 = $destinationfile3;
  } else $image3 = "";

  $image4name = $image4['name'];
  $image4error = $image4['error'];
  $image4tmp = $image4['tmp_name'];

  $image4ext = explode('.', $image4name);
  $image4check = strtolower(end($image4ext));

  if (in_array($image4check, $extstored)) {

    $destinationfile4 = 'upload/' . $image4name;
    move_uploaded_file($image4tmp, $destinationfile4);
    $image4 = $destinationfile4;
  } else $image4 = "";

  $image5name = $image5['name'];
  $image5error = $image5['error'];
  $image5tmp = $image5['tmp_name'];

  $image5ext = explode('.', $image5name);
  $image5check = strtolower(end($image5ext));

  if (in_array($image5check, $extstored)) {

    $destinationfile5 = 'upload/' . $image5name;
    move_uploaded_file($image5tmp, $destinationfile5);

    $image5 = $destinationfile5;
  } else $image5 = "";

  $sqlpushadquery = "Insert into ads(user_id, cat, loc, title, con, aut, feature, des, price, isnego, endDate, img1, img2, img3, img4, img5, phone, postDate) values ('$uid', '$category', '$location', '$title', '$condition', '$authenticity', '$features', '$description', '$price', '$isNego', '$endDate', '$image1', '$image2', '$image3', '$image4', '$image5', '$phoneNo', '$postDate')";

  $adresult = mysqli_query($con, $sqlpushadquery);

  if ($adresult) {
?>
    <script>
      alert("Ad posted successfully!");
    </script>
<?php
    include 'index.php';
  }

  // echo $category . "<br>";
  // echo $location . "<br>";
  // echo $title . "<br>";
  // echo $condition . "<br>";
  // echo $authenticity . "<br>";
  // echo $features . "<br>";
  // echo $description . "<br>";
  // echo $price . "<br>";
  // echo $isNego . "<br>";
  // echo $endDate . "<br>";
  // echo $image1 . "<br>";
  // echo $image2 . "<br>";
  // echo $image3 . "<br>";
  // echo $image4 . "<br>";
  // echo $image5 . "<br>";
  // echo $phoneNo . "<br>";
  // echo $_SESSION["userid"];

}
?>
