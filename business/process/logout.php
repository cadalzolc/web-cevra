<?php
session_start();

include('../../libs/base.php');
include('../../libs/func.php');
include('../../libs/db.php');

if (isset($_SESSION['C-ID'])) {
    session_destroy();
}

header('Location: ' . BASE_URL());