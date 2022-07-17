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
    $_SESSION["userid"] = $row['userid'];
    $_SESSION["username"] = $username;
    $_SESSION["email"] = $row['email'];
    include 'index.php';
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

      $_SESSION["userid"] = $row['userid'];
      $_SESSION["username"] = $username;
      $_SESSION["email"] = $email;


      $to_email = $_SESSION["email"];
      $subject = "Payment to preOwned successful";
      $body = "Hello " . $_SESSION['username'] . ", 
       
    
    Welcome to preOwned 😊";


      $headers = "From: preownedshop123@gmail.com";

      if (mail($to_email, $subject, $body, $headers)) {
      
      } else {
        echo "Email sending failed...";
      }
      include 'index.php';
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
  $d1 = strtotime($_POST['endDate']);
  $d2 = strtotime(date("Y-m-d"));

  $sec = $d1 - $d2;
  $day = $sec / 86400;
  $pp = $_POST['price'] * 0.02 + $day;
  include 'dbconnect.php';
  $uid = mysqli_real_escape_string($con, $_SESSION["userid"]);
  $category = mysqli_real_escape_string($con, $_POST["category"]);
  $location = mysqli_real_escape_string($con, $_POST["location"]);
  $title = mysqli_real_escape_string($con, $_POST["title"]);
  $condition = mysqli_real_escape_string($con, $_POST["condition"]);
  $authenticity = mysqli_real_escape_string($con, $_POST["authenticity"]);
  $features = mysqli_real_escape_string($con, $_POST["features"]);
  $description = mysqli_real_escape_string($con, $_POST["description"]);
  $price = mysqli_real_escape_string($con, $_POST["price"]);
  $isNego = mysqli_real_escape_string($con, $_POST["isNego"]);
  $endDate = mysqli_real_escape_string($con, $_POST["endDate"]);
  $image1 = $_FILES["image1"];
  $image2 = $_FILES["image2"];
  $image3 = $_FILES["image3"];
  $image4 = $_FILES["image4"];
  $image5 = $_FILES["image5"];
  $phoneNo = mysqli_real_escape_string($con, $_POST["phoneNo"]);
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

  $ssql = "Select * from ads where (user_id='$uid' and cat='$category' and loc='$location' and title='$title' and con='$condition' and aut='$authenticity' and feature='$features' and des='$description' and price='$price' and isnego='$isNego' and endDate='$endDate' and img1='$image1' and img2='$image2' and img3='$image3' and img4='$image4' and img5='$image5' and phone='$phoneNo' and postDate='$postDate')";

  $ssqlres = mysqli_query($con, $ssql);
  $ssqlresck = mysqli_num_rows($ssqlres);
  if ($ssqlresck > 0) {
    while ($rowssql = mysqli_fetch_assoc($ssqlres)) {
      $adId = $rowssql['ad_id'];
    }
    setcookie("adId", $adId, time() + (86400 * 1));
  }

  if ($adresult) {
?>
    <script>
      alert("Ad posted successfully!");
    </script>
<?php
    setcookie("userid", $_SESSION["userid"], time() + (86400 * 1));
    setcookie("username", $_SESSION["username"], time() + (86400 * 1));
    setcookie("email", $_SESSION["email"], time() + (86400 * 1));
  }

  /* PHP */
  $post_data = array();
  $post_data['store_id'] = "preow62d068642ae64";
  $post_data['store_passwd'] = "preow62d068642ae64@ssl";
  $post_data['total_amount'] = $pp;
  $post_data['currency'] = "BDT";
  $post_data['tran_id'] = "SSLCZ_TEST_" . uniqid();
  $post_data['success_url'] = "http://localhost/preOwned/allads.php";
  $post_data['fail_url'] = "http://localhost/preOwned/fail.php";
  $post_data['cancel_url'] = "http://localhost/new_sslcz_gw/cancel.php";
  # $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE

  # EMI INFO
  $post_data['emi_option'] = "1";
  $post_data['emi_max_inst_option'] = "9";
  $post_data['emi_selected_inst'] = "9";

  # CUSTOMER INFORMATION
  $post_data['cus_name'] = $_SESSION["username"];
  $post_data['cus_email'] = $_SESSION["email"];
  $post_data['cus_add1'] = "Dhaka";
  $post_data['cus_add2'] = "Dhaka";
  $post_data['cus_city'] = "Dhaka";
  $post_data['cus_state'] = "Dhaka";
  $post_data['cus_postcode'] = "1000";
  $post_data['cus_country'] = "Bangladesh";
  $post_data['cus_phone'] = $_POST['phoneNo'];
  $post_data['cus_fax'] = "01711111111";

  # SHIPMENT INFORMATION
  $post_data['ship_name'] = "testpreowgdbx";
  $post_data['ship_add1 '] = "Dhaka";
  $post_data['ship_add2'] = "Dhaka";
  $post_data['ship_city'] = "Dhaka";
  $post_data['ship_state'] = "Dhaka";
  $post_data['ship_postcode'] = "1000";
  $post_data['ship_country'] = "Bangladesh";

  # OPTIONAL PARAMETERS
  $post_data['value_a'] = "ref001";
  $post_data['value_b '] = "ref002";
  $post_data['value_c'] = "ref003";
  $post_data['value_d'] = "ref004";

  # CART PARAMETERS
  $post_data['cart'] = json_encode(array(
    array("product" => "DHK TO BRS AC A1", "amount" => "200.00"),
    array("product" => "DHK TO BRS AC A2", "amount" => "200.00"),
    array("product" => "DHK TO BRS AC A3", "amount" => "200.00"),
    array("product" => "DHK TO BRS AC A4", "amount" => "200.00")
  ));
  $post_data['product_amount'] = "100";
  $post_data['vat'] = "5";
  $post_data['discount_amount'] = "5";
  $post_data['convenience_fee'] = "3";

  # REQUEST SEND TO SSLCOMMERZ
  $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";

  $handle = curl_init();
  curl_setopt($handle, CURLOPT_URL, $direct_api_url);
  curl_setopt($handle, CURLOPT_TIMEOUT, 30);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
  curl_setopt($handle, CURLOPT_POST, 1);
  curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC


  $content = curl_exec($handle);

  $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

  if ($code == 200 && !(curl_errno($handle))) {
    curl_close($handle);
    $sslcommerzResponse = $content;
  } else {
    curl_close($handle);
    echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
    exit;
  }

  # PARSE THE JSON RESPONSE
  $sslcz = json_decode($sslcommerzResponse, true);

  if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
    # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
    # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
    echo "<meta http-equiv='refresh' content='0;url=" . $sslcz['GatewayPageURL'] . "'>";
    # header("Location: ". $sslcz['GatewayPageURL']);
    exit;
  } else {
    echo "JSON Data parsing error!";
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