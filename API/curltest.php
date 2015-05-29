<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include('includes/start.php');
$userName = "homeyteam@inter-actief.net";
$password = "1helemoeilijke";

$url = "https://www.ah.nl/mijn/inloggen/basis?ref=/";
$fields = "userName=".urlencode($userName)."&password=".urlencode($password).'&rememberUser=true';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_COOKIEJAR,'./cookie.txt');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.81 Safari/537.36");
curl_exec($ch);
curl_close($ch);

var_dump(htmlentities(file_get_contents("https://www.ah.nl/mijn/dashboard?ref=/")));
echo '<h2>'.$fields.'</h2>';