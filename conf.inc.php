<?php
header("Access-Control-Allow-Origin: *");
date_default_timezone_set("Asia/Bangkok");
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WisniorWeb */

// ------------- RMIS REAL on rmis2.medicine.psu.ac.th ----------------------
define( 'DB_NAME', 'dsrr_connect' );
define( 'DB_HOST', 'localhost' );
define( 'DB_USER', 'rmis5' );
define( 'DB_PASSWORD', 'rmis5' );
define( 'TB_PREFIX', '' );
define( 'ROOT_DOMAIN', 'https://dsrr-connect.com');

// ------------- RMIS TEST on fxplor ----------------------
// define( 'DB_NAME', 'dsrr_connect' );
// define( 'DB_USER', 'rmis5' );
// define( 'DB_PASSWORD', 'rmis5' );
// define( 'DB_HOST', '157.230.46.106' );
// define( 'TB_PREFIX', '' );
// define( 'ROOT_DOMAIN', 'http://localhost/dsrrcweb/' );

// Define system parameters
$sysdate = date('Y-m-d');
$sysdatetime = date('Y-m-d H:i:s');
$sysdateu = date('U');
$sysdateyear = date('Y');
$ip = $_SERVER['REMOTE_ADDR'];

?>
