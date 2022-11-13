<?php

if (empty($_SESSION['CUSTOMERID'])) {
    header("Location: " . BASE_URL() . 'sign-in.php');
    exit;
}

?>