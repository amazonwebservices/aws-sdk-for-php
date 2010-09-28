#! /usr/bin/env php
<?php

// Required
$php_ok = (function_exists('version_compare') && version_compare(phpversion(), '5.2.0', '>='));
$simplexml_ok = extension_loaded('simplexml');
$json_ok = (extension_loaded('json') && function_exists('json_encode') && function_exists('json_decode'));
$spl_ok = extension_loaded('spl');
$pcre_ok = extension_loaded('pcre');
if (function_exists('curl_version'))
{
	$curl_version = curl_version();
	$curl_ok = (function_exists('curl_exec') && in_array('https', $curl_version['protocols'], true));
}
$file_ok = (function_exists('file_get_contents') && function_exists('file_put_contents'));

// Optional, but recommended
$openssl_ok = (extension_loaded('openssl') && function_exists('openssl_sign'));
$zlib_ok = extension_loaded('zlib');

// Optional
$apc_ok = extension_loaded('apc');
$xcache_ok = extension_loaded('xcache');
$memcached_ok = extension_loaded('memcached');
$memcache_ok = extension_loaded('memcache');
$mc_ok = ($memcache_ok || $memcached_ok);
$pdo_ok = extension_loaded('pdo');
$pdo_sqlite_ok = extension_loaded('pdo_sqlite');
$sqlite2_ok = extension_loaded('sqlite');
$sqlite3_ok = extension_loaded('sqlite3');
$sqlite_ok = ($pdo_ok && $pdo_sqlite_ok && ($sqlite2_ok || $sqlite3_ok));

/////////////////////////////////////////////////////////////////////////

echo PHP_EOL;

echo 'AWS SDK for PHP' . PHP_EOL;
echo 'PHP Environment Compatibility Test (CLI)' . PHP_EOL;
echo '----------------------------------------' . PHP_EOL;
echo PHP_EOL;

echo 'PHP 5.2 or newer...       ' . ($php_ok ? phpversion() : 'No') . PHP_EOL;
echo 'cURL with SSL...          ' . ($curl_ok ? ($curl_version['version'] . ' (' . $curl_version['ssl_version'] . ')') : ($curl_version['version'] . (in_array('https', $curl_version['protocols'], true) ? ' (with ' . $curl_version['ssl_version'] . ')' : ' (without SSL)'))) . PHP_EOL;
echo 'Standard PHP Library...   ' . ($spl_ok ? 'Yes' : 'No') . PHP_EOL;
echo 'SimpleXML...              ' . ($simplexml_ok ? 'Yes' : 'No') . PHP_EOL;
echo 'JSON...                   ' . ($json_ok ? 'Yes' : 'No') . PHP_EOL;
echo 'PCRE...                   ' . ($pcre_ok ? 'Yes' : 'No') . PHP_EOL;
echo 'File system read/write... ' . ($file_ok ? 'Yes' : 'No') . PHP_EOL;
echo 'OpenSSL extension...      ' . ($openssl_ok ? 'Yes' : 'No') . PHP_EOL;
echo 'Zlib...                   ' . ($zlib_ok ? 'Yes' : 'No') . PHP_EOL;
echo 'APC...                    ' . ($apc_ok ? 'Yes' : 'No') . PHP_EOL;
echo 'XCache...                 ' . ($xcache_ok ? 'Yes' : 'No') . PHP_EOL;
echo 'Memcache...               ' . ($memcache_ok ? 'Yes' : 'No') . PHP_EOL;
echo 'Memcached...              ' . ($memcached_ok ? 'Yes' : 'No') . PHP_EOL;
echo 'PDO...                    ' . ($pdo_ok ? 'Yes' : 'No') . PHP_EOL;
echo 'SQLite 2...               ' . ($sqlite2_ok ? 'Yes' : 'No') . PHP_EOL;
echo 'SQLite 3...               ' . ($sqlite3_ok ? 'Yes' : 'No') . PHP_EOL;
echo 'PDO-SQLite driver...      ' . ($pdo_sqlite_ok ? 'Yes' : 'No') . PHP_EOL;
echo PHP_EOL;

echo '----------------------------------------' . PHP_EOL;
echo PHP_EOL;

if ($php_ok && $curl_ok && $simplexml_ok && $spl_ok && $json_ok && $pcre_ok && $file_ok)
{

	echo 'Your environment meets the minimum requirements for using the AWS SDK for PHP!' . PHP_EOL . PHP_EOL;
	if ($openssl_ok) { echo '* The OpenSSL extension is installed. This will allow you to use CloudFront Private URLs and decrypt Windows instance passwords.' . PHP_EOL . PHP_EOL; }
	if ($zlib_ok) { echo '* The Zlib extension is installed. The SDK will automatically leverage the compression capabilities of Zlib.' . PHP_EOL . PHP_EOL; }

	$storage_types = array();
	if ($file_ok) { $storage_types[] = 'The file system'; }
	if ($apc_ok) { $storage_types[] = 'APC'; }
	if ($xcache_ok) { $storage_types[] = 'XCache'; }
	if ($sqlite_ok && $sqlite3_ok) { $storage_types[] = 'SQLite 3'; }
	elseif ($sqlite_ok && $sqlite2_ok) { $storage_types[] = 'SQLite 2'; }
	if ($memcached_ok) { $storage_types[] = 'Memcached'; }
	elseif ($memcache_ok) { $storage_types[] = 'Memcache'; }
	echo '* Storage types available for response caching: ' . implode(', ', $storage_types) . PHP_EOL . PHP_EOL;

	if (!$openssl_ok) { echo '* You\'re missing the OpenSSL extension, which means that you won\'t be able to take advantage of CloudFront Private URLs or Windows password decryption.' . PHP_EOL . PHP_EOL; }
	if (!$zlib_ok) { echo '* You\'re missing the Zlib extension, which means that responses from Amazon\'s services will take a little longer to download and you won\'t be able to take advantage of compression with the response caching feature.' . PHP_EOL . PHP_EOL; }
}
else
{
	if (!$php_ok) { echo '* PHP: You are running an unsupported version of PHP.' . PHP_EOL . PHP_EOL; }
	if (!$curl_ok) { echo '* cURL: The cURL extension is not available. Without cURL, the SDK cannot connect to -- or authenticate with -- Amazon\'s services.' . PHP_EOL . PHP_EOL; }
	if (!$simplexml_ok) { echo '* SimpleXML: The SimpleXML extension is not available. Without SimpleXML, the SDK cannot parse the XML responses from Amazon\'s services.' . PHP_EOL . PHP_EOL; }
	if (!$spl_ok) { echo '* SPL: Standard PHP Library support is not available. Without SPL support, the SDK cannot autoload the required PHP classes.' . PHP_EOL . PHP_EOL; }
	if (!$json_ok) { echo '* JSON: JSON support is not available. AWS leverages JSON heavily in many of its services.' . PHP_EOL . PHP_EOL; }
	if (!$pcre_ok) { echo '* PCRE: Your PHP installation doesn\'t support Perl-Compatible Regular Expressions (PCRE). Without PCRE, the SDK cannot do any filtering via regular expressions.' . PHP_EOL . PHP_EOL; }
	if (!$file_ok) { echo '* File System Read/Write: The file_get_contents() and/or file_put_contents() functions have been disabled. Without them, the SDK cannot read from, or write to, the file system.' . PHP_EOL . PHP_EOL; }
}

echo '----------------------------------------' . PHP_EOL;
echo PHP_EOL;

if ($php_ok && $curl_ok && $simplexml_ok && $spl_ok && $json_ok && $pcre_ok && $file_ok && $openssl_ok && $zlib_ok && ($apc_ok || $xcache_ok || $mc_ok || $sqlite_ok))
{
	echo 'Bottom Line: Yes, you can!' . PHP_EOL;
	echo 'Your PHP environment is ready to go, and can take advantage of all possible features!' . PHP_EOL;
}
elseif ($php_ok && $curl_ok && $simplexml_ok && $spl_ok && $json_ok && $pcre_ok && $file_ok)
{
	echo 'Bottom Line: Yes, you can!' . PHP_EOL;
	echo 'Your PHP environment is ready to go! There are a couple of minor features that you won\'t be able to take advantage of, but nothing that\'s a show-stopper.' . PHP_EOL;
}
else
{
	echo 'Bottom Line: We\'re sorry...' . PHP_EOL;
	echo 'Your PHP environment does not support the minimum requirements for the AWS SDK for PHP.' . PHP_EOL;
}

echo PHP_EOL;
?>
