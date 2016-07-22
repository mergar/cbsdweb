<?php
require_once("auth.php");
?>

<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>CBSD Project</title>
        <link type="text/css" href="./css/all.css" rel="stylesheet" />
	<style>
		body {
			background-image: url("/img/adm_bg.jpg");
			background-color: #84CF99;
			font-size:14px;
		}
	</style>
</head>
<body>

<?php
require('cbsd.php');

if (!isset($_GET['nodename'])) {
	echo "Empty nodename";
	exit(0);
}

if (isset($_GET['sure'])) {
	$sure=1;
} else {
	$sure=0;
}

$nodename=$_GET['nodename'];

if ($sure==0) {
	$str = <<<EOF
<script type="text/javascript">
<!--

var answer = confirm("Really remove $nodename node?")
if (!answer)
window.location="nodes.php"
else
window.location="nremove.php?nodename=$nodename&sure=1"
// -->
</script>
EOF;
	echo $str;
	exit(0);
}

$handle=popen("env NOCOLOR=1 /usr/local/bin/sudo /usr/local/bin/cbsd task owner=cbsdweb mode=new /usr/local/bin/cbsd node mode=remove inter=0 node=$nodename", 'r');
$read = fgets($handle, 4096);
echo "Job Queued: $read";
pclose($handle);
header( 'Location: nodes.php' ) ;
?>
