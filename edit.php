<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Songlist Manager</title>
</head>

<body>

<?php
error_reporting(E_ALL & ~ E_NOTICE);
$songpaperpath="js/songpaper.js";
if(isset($_GET["sl"])){
	
	$file=file_get_contents($songpaperpath);
	$songp=json_decode($file,true);
	$path=$songp["songpaper"][$_GET["sl"]]["path"];
	$file=file_get_contents($path);
	$json=json_decode($file,true);
	$slength=count($json["songlist"]);
	if($_GET["met"]=="mp3"){
	for($i=0;$i<$slength;$i++){
		$slpmp3="slpmp3_".$i;
		$json["songlist"][$i]["pathmp3"]=$_POST[$slpmp3];
	};
	$json=json_encode($json);
	$file=fopen($path,"w");
	fwrite($file,$json);
	fclose($file);
	echo "<script>location.href='slmanager.php?sl=".$_GET["sl"]."';</script>";
	};
	if($_GET["met"]=="ogg"){
	for($i=0;$i<$slength;$i++){
		$slpogg="slpogg_".$i;
		$json["songlist"][$i]["pathogg"]=$_POST[$slpogg];
	};
	$json=json_encode($json);
	$file=fopen($path,"w");
	fwrite($file,$json);
	fclose($file);
	echo "<script>location.href='slmanager.php?sl=".$_GET["sl"]."';</script>";
	};
	if($_GET["met"]=="sl"){
		if($_POST["slname"] && $_POST["slalias"]){
			$filename="js/FM_songlist_".$_POST['slalias'].".js";
			if($filename==$songp["songpaper"][$_GET["sl"]]["path"]){
				$songp["songpaper"][$_GET["sl"]]["shareflag"]=$_POST["share"];
				$json=json_encode($songp);
				$file=fopen($songpaperpath,"w");
				fwrite($file,$json);
				fclose($file);
				echo "<script>location.href='slmanager.php';</script>"; 
			} else if(file_exists($filename)){echo "歌单文件名重复！请返回！";}
			else {
				$json["songlistname"]=$_POST["slname"];
				$json=json_encode($json);
				$file=fopen($filename,"x+");
				fwrite($file,$json);
				fclose($file);  
				unlink($songp["songpaper"][$_GET["sl"]]["path"]); 
				$songp["songpaper"][$_GET["sl"]]["path"]=$filename;
				$songp["songpaper"][$_GET["sl"]]["songlistname"]=$_POST["slname"];
				
				$json=json_encode($songp);
				$file=fopen($songpaperpath,"w");
				fwrite($file,$json);
				fclose($file);
				echo "<script>location.href='slmanager.php';</script>";
			};
		};
	};
	if(isset($_GET["s"])){
		$json["songlist"][$_GET["s"]]["title"]=$_POST["sltitle"];
		$json["songlist"][$_GET["s"]]["artist"]=$_POST["slartist"];
		$json["songlist"][$_GET["s"]]["album"]=$_POST["slalbum"];
		$json["songlist"][$_GET["s"]]["from"]=$_POST["slfrom"];
		$json["songlist"][$_GET["s"]]["pathmp3"]=$_POST["slpmp3"];
		$json["songlist"][$_GET["s"]]["pathogg"]=$_POST["slpogg"];
		$json=json_encode($json);
		$file=fopen($path,"w");
		fwrite($file,$json);
		fclose($file);
		echo "<script>location.href='slmanager.php?sl=".$_GET["sl"]."';</script>";
	};
};
?>
<?php

?>

</body>
</html>