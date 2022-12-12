<?php

//session_start();

include('./libs/env.php');
//include('./libs/base.php');
//include('./libs/db.php');
//include('./libs/func.php');

//$today = date("D, M j, Y");

//$sql_venues = "SELECT * FROM vw_listing LIMIT 12";
//$db = new Server();
//$qry_venues = $db->DbQuery($sql_venues);
//$cntLst = mysqli_num_rows($qry_venues);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Home</title>
</head>

<body class="d-flex flex-column h-100">
    <pre>Server:    <?php echo Configuration::Setting('server'); ?></pre>
    <pre>Username:  <?php echo Configuration::Setting('username'); ?></pre>
    <pre>Password:  <?php echo Configuration::Setting('password'); ?></pre>
    <pre>Database:  <?php echo Configuration::Setting('database'); ?></pre>
</body>

</html>