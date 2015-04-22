<?php
session_start();
//session_destroy();
unset($_SESSION['madmin']);
unset($_SESSION['userid']);
unset($_SESSION['mlevel']);
unset($_SESSION['mauth']);

echo "<script>window.open('login.html','_parent');</script>";
/*End PHP*/

