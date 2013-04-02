<?php

error_reporting(E_ALL);

$code = "____SHA256 HASH____";

$result = "";
if (array_key_exists('r_code', $_POST)) {
	if (hash("sha256", $_POST['r_code']) == $code) {
		// Correct code
		$remote_ip = $_SERVER['REMOTE_ADDR'];
		system("/usr/bin/sudo /usr/local/sbin/openfw.sh ".$remote_ip, $retval);
		if ($retval === 0) {
			$result = "Access for SSH has been enabled <b>for 1 hour</b> from your location (".$remote_ip.")";
		} else {
			$result = "There was an error while enabling SSH access from your location";
		}
	} else {
		// Wrong code
		$result = "Invalid code.";
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>SSH access</title>
		<style>
			body  { font-family: sans-serif; }
			table { margin: 20px auto 0px auto; }
			th    { font-weight: normal; }
		</style>
	</head>
	<body>
		<form name="code" method="POST">
			<table>
				<tr><th>Passcode</th><td><input name="r_code" type="password" /> <input type="submit" value="Go" /></tr>
				<tr><td colspan="2"><b class="result"><?php echo($result);?></b></td></tr>
			</table>
		</form>
		<script lang="javascript">
			document.code.r_code.focus();
		</script>
	</body>
</html>
<?php
