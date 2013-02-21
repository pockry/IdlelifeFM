<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Songlist Manager</title>
</head>

<body>

<?php
error_reporting(E_ALL & ~ E_NOTICE);
if(isset($_GET["sl"])){
	$songpaperpath="js/songpaper.js";
	$file=file_get_contents($songpaperpath);
	$json=json_decode($file,true);
	$path=$json["songpaper"][$_GET["sl"]]["path"];
	$file=file_get_contents($path);
	$json=json_decode($file,true);
	$slength=count($json["songlist"])?count($json["songlist"]):0;
	$json["songlist"][$slength]["title"]=$_POST["sltitle"];
	$json["songlist"][$slength]["artist"]=$_POST["slartist"];
	$json["songlist"][$slength]["album"]=$_POST["slalbum"];
	$json["songlist"][$slength]["from"]=$_POST["slfrom"];
	$json["songlist"][$slength]["pathmp3"]=$_POST["slpmp3"];
	$json["songlist"][$slength]["pathogg"]=$_POST["slpogg"];
	$json=json_encode($json);
	$file=fopen($path,"w");
	fwrite($file,$json);
	fclose($file);
	echo "添加歌曲成功！";
	echo "<script>location.href='slmanager.php?sl=".$_GET["sl"]."';</script>";
};
?>


</body>
</html>