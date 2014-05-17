<?php

// prevent direct access
if (!defined('MINT_ROOT')) { exit(); }
define('MINT',true);

// dummy Mint
class Mint
{
	var $prefix;
	function Mint($db)
	{
		$this->prefix = $db['tblPrefix'];
		@mysql_connect($db['server'],$db['username'],$db['password']);
		@mysql_select_db($db['database']);
	}
	
	function sql($str) 
	{
		if (get_magic_quotes_gpc())
		{
			$str = stripslashes($str);
		}
		return (!is_callable('mysql_real_escape_string'))?mysql_escape_string($str):mysql_real_escape_string($str);
	}

	function sanitize($url)
	{
		$javascript = str_replace(' ', '\s*', ' j a v a s c r i p t :');
		return preg_replace("#^{$javascript}.*#i", '', $url);
	}

	function prep($url)
	{
		return $this->sql($this->sanitize(preg_replace('/#.*$/', '', htmlentities($url))));
	}

	function prep_checksum($url)
	{
		return crc32(preg_replace("/^http(s)?:\/\/www\.([^.]+\.)/i", "http$1://$2", preg_replace("/\/index\.[^?]+/i", "/", $url)));
	}
	
	function record($url)
	{
		$referer	= (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$referer 	= $this->prep($referer);
		$url 		= $this->prep($url);

		$referer_checksum	= $this->prep_checksum($referer);
		$url_checksum		= $this->prep_checksum($url);

		$dt = time();
		$query = "INSERT INTO `{$this->prefix}lessn` (`referer`, `referer_checksum`, `url`, `url_checksum`, `dt`) VALUES ('{$referer}','{$referer_checksum}','{$url}','{$url_checksum}', '{$dt}');";
		mysql_query($query);
	}
}

include(MINT_ROOT.'config/db.php');
$Mint->record($row['url']);