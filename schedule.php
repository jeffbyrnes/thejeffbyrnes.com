<?php
// Set username and password
$username = 'thejeffbyrnes';
$password = 'infinity22';
// The message you want to send

srand ((double) microtime() * 10000000);

$input = array (
	"In addition to my business card at http://jeffbyrn.es, you can also read my blog at http://www.jeffbyrnes.net/. Enjoy!");

$num = array_rand($input);
$message = $input[$num];

// $message = 'still writing new blog posts';
// The twitter API address
$url = 'http://twitter.com/statuses/update.xml';
// Alternative JSON version
// $url = 'http://twitter.com/statuses/update.json';
// Set up and execute the curl process
$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL, "$url");
curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "status=$message");
curl_setopt($curl_handle, CURLOPT_USERPWD, "$username:$password");
$buffer = curl_exec($curl_handle);
curl_close($curl_handle);
// check for success or failure
if (empty($buffer)) {
    echo 'message';
} else {
    echo 'success';
}
?>

