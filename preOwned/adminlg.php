<?php
session_start();
unset($_SESSION["adminuserid"]);
  unset($_SESSION["adminusername"]);
  unset($_SESSION["adminemail"]);
  include 'adminlogin.php';
  ?>
