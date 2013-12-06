<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

define('USERNAME', 'dten1986');
define('PASSWORD', '123456');
define('LOGIN_URL', 'https://account.dyn.com/');
define('COOKIE_FILE', './cookies.txt');
 
$ch = curl_init();
 
curl_setopt_array($ch, array(
	CURLOPT_HEADER => TRUE,
	CURLOPT_VERBOSE => TRUE,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.3; Trident/7.0)', 
	CURLOPT_SSL_VERIFYPEER => FALSE,
	CURLOPT_SSL_VERIFYHOST => FALSE,
	CURLOPT_RETURNTRANSFER => TRUE,
	CURLOPT_COOKIESESSION => TRUE,
	CURLOPT_AUTOREFERER => TRUE,
	CURLOPT_FOLLOWLOCATION => TRUE,
	CURLOPT_COOKIEFILE => COOKIE_FILE,
	CURLOPT_COOKIEJAR => COOKIE_FILE,
));	

curl_setopt($ch, CURLOPT_URL, LOGIN_URL); 
$content1 = curl_exec($ch);

preg_match('/(name=\'multiform\')\svalue=\'(?<value>.+?)\'/', $content1, $matches);

$post_data = http_build_query(array(
	'username' => USERNAME,
	'password' => PASSWORD,
	'multiform' => $matches['value'],
	'submit' => 'Log in'
));

curl_setopt_array($ch, array(
	CURLOPT_POST => TRUE,
	CURLOPT_URL => LOGIN_URL,
	CURLOPT_POSTFIELDS => $post_data
));

$content2 = curl_exec($ch);

curl_close($ch);
unlink(COOKIE_FILE);

?>