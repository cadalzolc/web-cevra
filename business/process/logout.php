<?php
session_start();

include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

if (isset($_SESSION['B-ID'])) {
    session_destroy();
}

header('Location: ' . BASE_URL());