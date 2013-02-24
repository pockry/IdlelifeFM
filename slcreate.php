<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Songlist Maker</title>
</head>

<body>

<?php
error_reporting(E_ALL & ~ E_NOTICE);
$songpaperpath="js/songpaper.js";
if($_POST["slname"] && $_POST["slalias"]){
	$filename="js/FM_songlist_".$_POST['slalias'].".js";
	if(file_exists($filename)){echo "歌单文件名重复！请返回！";}
	else{
	$file=fopen($filename,"x+");
	$slname=array("songlistname"=>$_POST["slname"]);
	$json=json_encode($slname);
	fwrite($file,$json);
	fclose($file);
	$file=file_get_contents($songpaperpath);
	$songp=json_decode($file,true);
	$songplength=count($songp["songpaper"]);
	$songp["songpaper"][$songplength]["path"]=$filename;
	$songp["songpaper"][$songplength]["songlistname"]=$_POST["slname"];
	$songp["songpaper"][$songplength]["shareflag"]="NO";
	$json=json_encode($songp);
	$file=fopen($songpaperpath,"w");
	fwrite($file,$json);
	fclose($file);
	echo "<script>location.href='slmanager.php';</script>";
	}
};
?>
</body>
</html>