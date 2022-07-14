<?php
  $dbServername = "localhost";
  $dbUsername = "root";
  $dbPassword = "";
  $dbnName = "preOwned";
  
  $con = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbnName);
  
  if ($con) {
    ?>
    <script>
      alert("Connected");
    </script>
    <?php
  }
  else {
    ?>
    <script>
      alert("Not Connected");
    </script>
    <?php
  }

?>