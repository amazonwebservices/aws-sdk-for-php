<?php
if (isset($_GET['logopng']))
{
	$data='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';
	header('Content-type: image/png');
	echo base64_decode($data);
	exit;
}
else if (isset($_GET['background']))
{
	$data='R0lGODlhMAEeAeYAAP///8ni6cTf5+72+PD3+c3k6+nz9ufy9ev099Pn7bnZ48bg6LfY4uHv8/r8/f3+/v7//7bX4cjh6fj7/Mvj6vz9/rva4+z19/X6+/f7/Pn8/fb6+7jZ4vv9/bra473b5Lzb5LXX4b7c5b/c5e31+NTo7tvs8dfq7/H3+bjY4tnq79Hm7c/l69nr8PL4+t7t8sDd5cLe5uPw9Nvr8Mri6fP4+tLn7er099Hm7O/2+dDm7OTw9OXx9Nbp7tbp7+Lv8+Du8szj6sXg57bY4d3s8djq7+jz9tzs8cPe58fh6M7k68Pf5+by9fz+/sDd5vT5+vT5+97t8bbY4trr8P7+/v7+/+Pw8+Xx9dXo7sHe5vH4+fP5+sHd5t/u8s/l7AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAwAR4BAAf/gCGCg4SFhoeIiYqLjI2Oj5CRkpOUlZaXmJmam5ydnp+goaKNEaWmp6ipqqusra6vsLGys7S1tre4ubq7vL2+v8DBwsPExbBDyMnKy8zNzs/Q0dLT1NXW19jZ2tvc3d7KUuHi4+Tl5ufo6err7O3u7/Dx8vP09fb34wz6+/z9/v8AAwocSLCgwYMIEypcyLChw4cQI0qcSLGixYsYM2osmKKjx48gQ4ocSbKkyZMoU6pcybKly5cwY8qc+ZGDzZs4c+rcybOnz59AgwodSrSo0aNIkypdyrSp06dQo0qdSrWq1aAKsmrdyrWr169gw4odS7as2bNo06pdy7at27dw/+PKnUu3rt27ePOS9cC3r9+/gAMLHky4sOHDiBMrXsy4sePHkCNLnky5suXLmDNr3sz5sIXPoEOLHk26tOnTqFOrXs26tevXsGPLnk27tu3buHPr3s27t+/fqkEIH068uPHjyJMrX868ufPn0KNLn069uvXr2LNr3869u/fv4MOLb/6hvPnz6NOrX8++vfv38OPLn0+/vv37+PPr38+/v///AAYo4IAEFgifCAgmqOCCDDbo4IMQRijhhBRWaOGFGGao4YYcdujhhyCGKOKIJJZo4okoTjjCiiy26OKLMMYo44w01mjjjTjmqOOOPPbo449ABinkkEQWaeSRSCap5P+SNsLg5JNQRinllFRWaeWVWGap5ZZcdunll2CGKeaYZELpxJlopqnmmmy26eabcMYp55x01mnnnXjmqeeefPaZJheABirooIQWauihiCaq6KKMNuroo5BGKumklFZqqaBZZKrpppx26umnoIYq6qiklmrqqaimquqqrLbq6qubxiDrrLTWauutuOaq66689urrr8AGK+ywxBZr7LHI0orEssw26+yz0EYr7bTUVmvttdhmq+223Hbr7bfghtvsEuSWa+656Kar7rrstuvuu/DGK++89NZr77345quvuQL06++/AAcs8MAEF2zwwQgnrPDCDDfs8MMQRyzxxBRXbPH/xRhnrPHGHHeMsBAghyzyyCSXbPLJKKes8sost+zyyzDHLPPMNNdss8gL5Kzzzjz37PPPQAct9NBEF2300UgnrfTSTDft9NNQRy311FRXbfXVWGdNdBJcd+3112CHLfbYZJdt9tlop6322my37fbbcMctt9cS1G333XjnrffefPft99+ABy744IQXbvjhiCeu+OKMN+7445BHLvnklFcOeACYZ6755px37vnnoIcu+uikl2766ainrvrqrLfu+uuwxy777LTXbvvtuI9Ow+689+7778AHL/zwxBdv/PHIJ6/88sw37/zz0EffOwXUV2/99dhnr/323Hfv/ffghy/+//jkl2/++einr/767Lfv/vvwxy///PR/H8T9+Oev//789+///wAMoAAHSMACGvCACEygAhfIwAbmrwAQjKAEJ0jBClrwghjMoAY3yMEOevCDIAyhCEdIwhKa8IQoTKEKV8jCFrrwhTDcoBJmSMMa2vCGOMyhDnfIwx768IdADKIQh0jEIhrxiEhMYg1ZwMQmOvGJUIyiFKdIxSpa8YpYzKIWt8jFLnrxi2AMoxid6IUymvGMaEyjGtfIxja68Y1wjKMc50jHOtrxjnjMox73eEYd+PGPgAykIAdJyEIa8pCITKQiF8nIRjrykZCMpCQnSUlA4uCSmMykJjfJyU568v+ToAylKEdJylKa8pSoTKUqV8nKVmZyBbCMpSxnScta2vKWuMylLnfJy1768pfADKYwh0nMYhpTljZIpjKXycxmOvOZ0IymNKdJzWpa85rYzKY2t8nNbnrzm8tMgDjHSc5ymvOc6EynOtfJzna6853wjKc850nPetrznvjMpz73yc9++vOfAA2oQNtZgoIa9KAITahCF8rQhjr0oRCNqEQnStGKWvSiGM2oRjd6UCx49KMgDalIR0rSkpr0pChNqUpXytKWuvSlMI2pTGdKU5D24KY4zalOd8rTnvr0p0ANqlCHStSiGvWoSE2qUpfK1Kbm1AdQjapUp0rVqlr1qlj/zapWt8rVrnr1q2ANq1jHStaymlWqJ0irWtfK1ra69a1wjatc50rXutr1rnjNq173yte++vWvay2CYAdL2MIa9rCITaxiF8vYxjr2sZCNrGQnS9nKWvaymCWsCjbL2c569rOgDa1oR0va0pr2tKhNrWpXy9rWuva1sI1tZ1tA29ra9ra4za1ud8vb3vr2t8ANrnCHS9ziGve4yE2ucm07heY697nQja50p0vd6lr3utjNrna3y93ueve74A2veMf73BmY97zoTa9618ve9rr3vfCNr3znS9/62ve++M2vfvfLX/Sa4L8ADrCAB0zgAhv4wAhOsIIXzOAGO/jBEI6w/4QnTOEKB/gIGM6whjfM4Q57+MMgDrGIR0ziEpv4xChOsYpXzOIWu1jDRIixjGdM4xrb+MY4zrGOd8zjHvv4x0AOspCHTOQiG/nIM46CkpfM5CY7+clQjrKUp0zlKlv5yljOspa3zOUue/nLYGbyC8ZM5jKb+cxoTrOa18zmNrv5zXCOs5znTOc62/nOeM5zmbvA5z77+c+ADrSgB03oQhv60IhOtKIXzehGO/rRkI60pP0MhEpb+tKYzrSmN83pTnv606AOtahHTepSm/rUqE61qld96Qa4+tWwjrWsZ03rWtv61rjOta53zete+/rXwA62sIdN7GIb+9jITrayl//N7GY7O9c/iLa0p03talv72tjOtra3ze1ue/vb4A63uMdN7nKb+9zTtoK6183udrv73fCOt7znTe962/ve+M63vvfN7377+98AZ7cMBk7wghv84AhPuMIXzvCGO/zhEI+4xCdO8Ypb/OIYz3jBd8Dxjnv84yAPuchHTvKSm/zkKE+5ylfO8pa7/OUwj7nMPc6Dmtv85jjPuc53zvOe+/znQA+60IdO9KIb/ehIT7rSl37zKzj96VCPutSnTvWqW/3qWM+61rfO9a57/etgD7vYx052qDPh7GhPu9rXzva2u/3tcI+73OdO97rb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';
	header('Content-type: image/gif');
	echo base64_decode($data);
	exit;
}

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

header('Content-type: text/html; charset=UTF-8');

?><!DOCTYPE html>

<html lang="en">
<head>
<title>AWS SDK for PHP: Environment Compatibility Test</title>

<style type="text/css">
body {
	font:14px/1.4em "Helvetica Neue", Helvetica, "Lucida Grande", Verdana, Arial, Clean, Sans, sans-serif;
	letter-spacing:0px;
	color:#333;
	margin:0;
	padding:0;
	background:#fff url(<?php echo pathinfo(__FILE__, PATHINFO_BASENAME); ?>?background) repeat-x top left;
}

div#site {
	width:650px;
	margin:20px auto 0 auto;
}

a {
	color: #326EA1;
	text-decoration: underline;
	padding: 1px 2px;
	-webkit-transition: background-color 0.15s;
	-webkit-transition: color 0.15s;
	-moz-transition: background-color 0.15s;
	-moz-transition: color 0.15s;
	transition: background-color 0.15s;
	transition: color 0.15s;
	-webkit-border-radius: 2px;
	-moz-border-radius: 2px;
	border-radius: 2px;
}

a:hover, a.hover {
	color: #fff;
	background-color: #333;
	text-decoration: none;
	padding: 1px 2px;
}

p {
	margin:0;
	padding:5px 0;
}

em {
	font-style:normal;
	background-color:#ffc;
}

ul, ol {
	margin:10px 0 10px 20px;
	padding:0 0 0 15px;
}

ul li, ol li {
	margin:0 0 4px 0;
	padding:0 0 0 3px;
}

h2 {
	font-size:18px;
	padding:0;
	margin:0 0 10px 0;
}

h3 {
	font-size:16px;
	padding:0;
	margin:20px 0 5px 0;
}

h4 {
	font-size:14px;
	padding:0;
	margin:15px 0 5px 0;
}

code {
	font-size:1.1em;
	background-color:#f3f3ff;
	color:#000;
}

em strong {
    text-transform: uppercase;
}

table#chart {
	border-collapse:collapse;
}

table#chart th {
	background-color:#eee;
	padding:2px 3px;
	border:1px solid #fff;
}

table#chart td {
	text-align:center;
	padding:2px 3px;
	border:1px solid #eee;
}

table#chart tr.enabled td {
	/* Leave this alone */
}

table#chart tr.disabled td,
table#chart tr.disabled td a {
	color:#999;
	font-style:italic;
}

table#chart tr.disabled td a {
	text-decoration:underline;
}

div.chunk {
	margin:0;
	padding:10px;
	border-bottom:1px solid #ccc;
}

div.important {
	background-color:#ffc;
}

div.ok {
	background-color:#cfc;
}

div.error {
	background-color:#fcc;
}

div.important h3 {
	margin: 7px 0 5px 0;
}

.footnote,
.footnote a {
	font:12px/1.4em "Helvetica Neue", Helvetica, "Lucida Grande", Verdana, Arial, Clean, Sans, sans-serif;
	color:#aaa;
}

.footnote em {
	background-color:transparent;
	font-style:italic;
}
</style>

<script type="text/javascript">
// Sleight - Alpha transparency PNG's in Internet Explorer 5.5/6.0
// (c) 2001, Aaron Boodman; http://www.youngpup.net

if (navigator.platform == "Win32" && navigator.appName == "Microsoft Internet Explorer" && window.attachEvent) {
	document.writeln('<style type="text/css">img, input.image { visibility:hidden; } </style>');
	window.attachEvent("onload", fnLoadPngs);
}

function fnLoadPngs() {
	var rslt = navigator.appVersion.match(/MSIE (\d+\.\d+)/, '');
	var itsAllGood = (rslt != null && Number(rslt[1]) >= 5.5);

	for (var i = document.images.length - 1, img = null; (img = document.images[i]); i--) {
		if (itsAllGood && img.src.match(/\png$/i) != null) {
			var src = img.src;
			var div = document.createElement("DIV");
			div.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + src + "', sizing='scale')";
			div.style.width = img.width + "px";
			div.style.height = img.height + "px";
			img.replaceNode(div);
		}
		img.style.visibility = "visible";
	}
}
</script>

</head>

<body>

<div id="site">
	<div id="content">

		<div class="chunk">
			<h2 style="text-align:center;"><img src="<?php echo pathinfo(__FILE__, PATHINFO_BASENAME); ?>?logopng" alt="SimplePie Compatibility Test" title="SimplePie Compatibility Test" /></h2>

			<h3>Minimum Requirements</h3>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" id="chart">
				<thead>
					<tr>
						<th>Test</th>
						<th>Should Be</th>
						<th>What You Have</th>
					</tr>
				</thead>
				<tbody>
					<tr class="<?php echo ($php_ok) ? 'enabled' : 'disabled'; ?>">
						<td>PHP</td>
						<td>5.2 or newer</td>
						<td><?php echo phpversion(); ?></td>
					</tr>
					<tr class="<?php echo ($curl_ok) ? 'enabled' : 'disabled'; ?>">
						<td><a href="http://php.net/curl">cURL</a></td>
						<td>7.15.0 or newer, with SSL</td>
						<td><?php echo ($curl_ok) ? ($curl_version['version'] . ' (' . $curl_version['ssl_version'] . ')') : ($curl_version['version'] . (in_array('https', $curl_version['protocols'], true) ? ' (with ' . $curl_version['ssl_version'] . ')' : ' (without SSL)')); ?></td>
					</tr>
					<tr class="<?php echo ($simplexml_ok) ? 'enabled' : 'disabled'; ?>">
						<td><a href="http://php.net/simplexml">SimpleXML</a></td>
						<td>Enabled</td>
						<td><?php echo ($simplexml_ok) ? 'Enabled' : 'Disabled'; ?></td>
					</tr>
					<tr class="<?php echo ($spl_ok) ? 'enabled' : 'disabled'; ?>">
						<td><a href="http://php.net/spl">SPL</a></td>
						<td>Enabled</td>
						<td><?php echo ($spl_ok) ? 'Enabled' : 'Disabled'; ?></td>
					</tr>
					<tr class="<?php echo ($json_ok) ? 'enabled' : 'disabled'; ?>">
						<td><a href="http://php.net/json">JSON</a></td>
						<td>Enabled</td>
						<td><?php echo ($json_ok) ? 'Enabled' : 'Disabled'; ?></td>
					</tr>
					<tr class="<?php echo ($pcre_ok) ? 'enabled' : 'disabled'; ?>">
						<td><a href="http://php.net/pcre">PCRE</a></td>
						<td>Enabled</td>
						<td><?php echo ($pcre_ok) ? 'Enabled' : 'Disabled'; ?></td>
					</tr>
					<tr class="<?php echo ($file_ok) ? 'enabled' : 'disabled'; ?>">
						<td>File System <a href="http://php.net/file_get_contents">Read</a>/<a href="http://php.net/file_put_contents">Write</a></td>
						<td>Enabled</td>
						<td><?php echo ($file_ok) ? 'Enabled' : 'Disabled'; ?></td>
					</tr>
				</tbody>
			</table>

			<h3>Optional Extensions</h3>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" id="chart">
				<thead>
					<tr>
						<th>Test</th>
						<th>Would Like To Be</th>
						<th>What You Have</th>
					</tr>
				</thead>
				<tbody>
					<tr class="<?php echo ($openssl_ok) ? 'enabled' : 'disabled'; ?>">
						<td><a href="http://php.net/openssl">OpenSSL</a></td>
						<td>Enabled</td>
						<td><?php echo ($openssl_ok) ? 'Enabled' : 'Disabled'; ?></td>
					</tr>
					<tr class="<?php echo ($zlib_ok) ? 'enabled' : 'disabled'; ?>">
						<td><a href="http://php.net/zlib">Zlib</a></td>
						<td>Enabled</td>
						<td><?php echo ($zlib_ok) ? 'Enabled' : 'Disabled'; ?></td>
					</tr>
					<tr class="<?php echo ($apc_ok) ? 'enabled' : 'disabled'; ?>">
						<td><a href="http://php.net/apc">APC</a></td>
						<td>Enabled</td>
						<td><?php echo ($apc_ok) ? 'Enabled' : 'Disabled'; ?></td>
					</tr>
					<tr class="<?php echo ($xcache_ok) ? 'enabled' : 'disabled'; ?>">
						<td><a href="http://xcache.lighttpd.net">XCache</a></td>
						<td>Enabled</td>
						<td><?php echo ($xcache_ok) ? 'Enabled' : 'Disabled'; ?></td>
					</tr>
					<tr class="<?php echo ($memcache_ok) ? 'enabled' : 'disabled'; ?>">
						<td><a href="http://php.net/memcache">Memcache</a></td>
						<td>Enabled</td>
						<td><?php echo ($memcache_ok) ? 'Enabled' : 'Disabled'; ?></td>
					</tr>
					<tr class="<?php echo ($memcached_ok) ? 'enabled' : 'disabled'; ?>">
						<td><a href="http://php.net/memcached">Memcached</a></td>
						<td>Enabled</td>
						<td><?php echo ($memcached_ok) ? 'Enabled' : 'Disabled'; ?></td>
					</tr>
					<tr class="<?php echo ($pdo_ok) ? 'enabled' : 'disabled'; ?>">
						<td><a href="http://php.net/pdo">PDO</a></td>
						<td>Enabled</td>
						<td><?php echo ($pdo_ok) ? 'Enabled' : 'Disabled'; ?></td>
					</tr>
					<tr class="<?php echo ($pdo_sqlite_ok) ? 'enabled' : 'disabled'; ?>">
						<td><a href="http://php.net/pdo-sqlite">PDO-SQLite</a></td>
						<td>Enabled</td>
						<td><?php echo ($pdo_sqlite_ok) ? 'Enabled' : 'Disabled'; ?></td>
					</tr>
					<tr class="<?php echo ($sqlite2_ok) ? 'enabled' : 'disabled'; ?>">
						<td><a href="http://php.net/sqlite">SQLite 2</a></td>
						<td>Enabled</td>
						<td><?php echo ($sqlite2_ok) ? 'Enabled' : 'Disabled'; ?></td>
					</tr>
					<tr class="<?php echo ($sqlite3_ok) ? 'enabled' : 'disabled'; ?>">
						<td><a href="http://php.net/sqlite3">SQLite 3</a></td>
						<td>Enabled</td>
						<td><?php echo ($sqlite3_ok) ? 'Enabled' : 'Disabled'; ?></td>
					</tr>
				</tbody>
			</table>

			<br>
		</div>

		<?php if ($php_ok && $curl_ok && $simplexml_ok && $spl_ok && $json_ok && $pcre_ok && $file_ok && $openssl_ok && $zlib_ok && ($apc_ok || $xcache_ok || $mc_ok || $sqlite_ok)): ?>
		<div class="chunk important ok">
			<h3>Bottom Line: Yes, you can!</h3>
			<p>Your PHP environment is ready to go, and can take advantage of all possible features!</p>
		</div>
		<div class="chunk">
			<h3>What's Next?</h3>
			<p>You can download the latest version of the <a href="http://aws.amazon.com/sdkforphp"><strong>AWS SDK for PHP</strong></a> and install it by <a href="http://aws.amazon.com/sdkforphp/getting-started">following the instructions</a>. Also, check out our library of <a href="http://developer.amazonwebservices.com/connect/entry.jspa?externalID=4262">screencasts and tutorials</a>.</p>
			<p>Take the time to read <a href="http://aws.amazon.com/sdkforphp/getting-started">"Getting Started"</a> to make sure you're prepared to use the AWS SDK for PHP. No seriously, read it.</p>
		</div>
		<?php elseif ($php_ok && $curl_ok && $simplexml_ok && $spl_ok && $json_ok && $pcre_ok && $file_ok): ?>
		<div class="chunk important ok">
			<h3>Bottom Line: Yes, you can!</h3>
			<p>Your PHP environment is ready to go! <i>There are a couple of minor features that you won't be able to take advantage of, but nothing that's a show-stopper.</i></p>
		</div>
		<div class="chunk">
			<h3>What's Next?</h3>
			<p>You can download the latest version of the <a href="http://aws.amazon.com/sdkforphp"><strong>AWS SDK for PHP</strong></a> and install it by <a href="http://aws.amazon.com/sdkforphp/getting-started">following the instructions</a>. Also, check out our library of <a href="http://developer.amazonwebservices.com/connect/entry.jspa?externalID=4262">screencasts and tutorials</a>.</p>
			<p>Take the time to read <a href="http://aws.amazon.com/sdkforphp/getting-started">"Getting Started"</a> to make sure you're prepared to use the AWS SDK for PHP. No seriously, read it.</p>
		</div>
		<?php else: ?>
		<div class="chunk important error">
			<h3>Bottom Line: We're sorry&hellip;</h3>
			<p>Your PHP environment does not support the minimum requirements for the <strong>AWS SDK for PHP</strong>.</p>
		</div>
		<div class="chunk">
			<h3>What's Next?</h3>
			<p>If you're using a shared hosting plan, it may be a good idea to contact your web host and ask them to install a more recent version of PHP and relevant extensions.</p>
			<p>If you have control over your PHP environment, we recommended that you upgrade your PHP environment. Check out the "Set Up Your Environment" section of the <a href="http://developer.amazonwebservices.com/connect/entry.jspa?externalID=4261&categoryID=329">Getting Started Guide</a> for more information.</p>
		</div>
		<?php endif; ?>

		<div class="chunk">
			<h3>Give me the details!</h3>
			<?php if ($php_ok && $curl_ok && $simplexml_ok && $spl_ok && $json_ok && $pcre_ok && $file_ok): ?>
			<ol>
				<li><em>Your environment meets the minimum requirements for using the <strong>AWS SDK for PHP</strong>!</em></li>

				<?php if ($openssl_ok): ?>
				<li>The <a href="http://php.net/openssl">OpenSSL</a> extension is installed. This will allow you to use <a href="http://docs.amazonwebservices.com/AmazonCloudFront/latest/DeveloperGuide/PrivateContent.html">CloudFront Private URLs</a> and decrypt Microsoft&reg; Windows&reg; instance passwords.</li>
				<?php endif; ?>

				<?php if ($zlib_ok): ?>
				<li>The <a href="http://php.net/zlib">Zlib</a> extension is installed. The SDK will automatically leverage the compression capabilities of Zlib.</li>
				<?php endif; ?>

				<?php
				$storage_types = array();
				if ($file_ok) { $storage_types[] = '<a href="http://php.net/file_put_contents">The file system</a>'; }
				if ($apc_ok) { $storage_types[] = '<a href="http://php.net/apc">APC</a>'; }
				if ($xcache_ok) { $storage_types[] = '<a href="http://xcache.lighttpd.net">XCache</a>'; }
				if ($sqlite_ok && $sqlite3_ok) { $storage_types[] = '<a href="http://php.net/sqlite3">SQLite 3</a>'; }
				elseif ($sqlite_ok && $sqlite2_ok) { $storage_types[] = '<a href="http://php.net/sqlite">SQLite 2</a>'; }
				if ($memcached_ok) { $storage_types[] = '<a href="http://php.net/memcached">Memcached</a>'; }
				elseif ($memcache_ok) { $storage_types[] = '<a href="http://php.net/memcache">Memcache</a>'; }
				?>
				<li>Storage types available for response caching: <?php echo implode(', ', $storage_types); ?></li>
			</ol>

				<?php if (!$openssl_ok && !$zlib_ok): ?>
				<p class="footnote"><strong>NOTE:</strong> You're missing the <a href="http://php.net/openssl">OpenSSL</a> extension, which means that you won't be able to take advantage of <a href="http://docs.amazonwebservices.com/AmazonCloudFront/latest/DeveloperGuide/PrivateContent.html">CloudFront Private URLs</a> or decrypt Microsoft&reg; Windows&reg; instance passwords. You're also missing the <a href="http://php.net/zlib">Zlib</a> extension, which means that responses from Amazon's services will take a little longer to download and you won't be able to take advantage of compression with the <i>response caching</i> feature.</p>
				<?php elseif (!$zlib_ok): ?>
				<p class="footnote"><strong>NOTE:</strong> You're missing the <a href="http://php.net/zlib">Zlib</a> extension, which means that responses from Amazon's services will take a little longer to download and you won't be able to take advantage of compression with the <i>response caching</i> feature.</p>
				<?php elseif (!$openssl_ok): ?>
				<p class="footnote"><strong>NOTE:</strong> You're missing the <a href="http://php.net/openssl">OpenSSL</a> extension, which means that you won't be able to take advantage of <a href="http://docs.amazonwebservices.com/AmazonCloudFront/latest/DeveloperGuide/PrivateContent.html">CloudFront Private URLs</a> or decrypt Microsoft&reg; Windows&reg; instance passwords.</p>
				<?php endif; ?>

			<?php else: ?>
			<ol>
				<?php if (!$php_ok): ?>
					<li><strong>PHP:</strong> You are running an unsupported version of PHP.</li>
				<?php endif; ?>

				<?php if (!$curl_ok): ?>
					<li><strong>cURL:</strong> The <a href="http://php.net/curl">cURL</a> extension is not available. Without cURL, the SDK cannot connect to &mdash; or authenticate with &mdash; Amazon's services.</li>
				<?php endif; ?>

				<?php if (!$simplexml_ok): ?>
					<li><strong>SimpleXML:</strong> The <a href="http://php.net/simplexml">SimpleXML</a> extension is not available. Without SimpleXML, the SDK cannot parse the XML responses from Amazon's services.</li>
				<?php endif; ?>

				<?php if (!$spl_ok): ?>
					<li><strong>SPL:</strong> <a href="http://php.net/spl">Standard PHP Library</a> support is not available. Without SPL support, the SDK cannot autoload the required PHP classes.</li>
				<?php endif; ?>

				<?php if (!$json_ok): ?>
					<li><strong>JSON:</strong> <a href="http://php.net/json">JSON</a> support is not available. AWS leverages JSON heavily in many of its services.</li>
				<?php endif; ?>

				<?php if (!$pcre_ok): ?>
					<li><strong>PCRE:</strong> Your PHP installation doesn't support Perl-Compatible Regular Expressions (PCRE). Without PCRE, the SDK cannot do any filtering via regular expressions.</li>
				<?php endif; ?>

				<?php if (!$file_ok): ?>
					<li><strong>File System Read/Write:</strong> The <a href="http://php.net/file_get_contents">file_get_contents()</a> and/or <a href="http://php.net/file_put_contents">file_put_contents()</a> functions have been disabled. Without them, the SDK cannot read from, or write to, the file system.</li>
				<?php endif; ?>
			</ol>
			<?php endif; ?>
		</div>

		<div class="chunk">
			<p class="footnote"><strong>NOTE</strong>: Passing this test does not guarantee that the AWS SDK for PHP will run on your web server &mdash; it only ensures that the requirements have been addressed.</p>
		</div>
	</div>

</div>

</body>
</html>