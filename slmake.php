<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<title>Songlist Maker</title>
<script type="text/javascript">
$(document).ready(function(e) {

});
</script>
<style type="text/css">
#step2{display:none;}
</style>
</head>

<body>
<header>
<h1>制作你的歌单！</h1>
</header>
<nav>
<ul>
	<li>创建歌单</li>
    <li>管理歌单</li>
</ul>
</nav>
<article>
<div id="step1">创建歌单名称<br />
<form action="slmake.php" method="post">
歌单名：<input name="slname" type="text" maxlength="50" value="Idlelife FM" /><br />
文件名：FM_songlist_<input name="slalias" type="text" maxlength="50" id="slalias" value="0" /> <span id="formval">（请使用字母、数字和下划线）</span><br />
<input id="submit" type="submit" value="提交" />
</form>
</div>
<?php
error_reporting(E_ALL & ~ E_NOTICE);
$songpaperpath="js/songpaper.js";
if($_POST["slname"] && $_POST["slalias"]){
	echo "歌单名：". $_POST["slname"]." 文件名：FM_songlist_". $_POST["slalias"] ."<br />";
	$filename="js/FM_songlist_".$_POST['slalias'].".js";
	if(file_exists($filename)){echo "歌单名重复！";}
	else{
	$file=fopen($filename,"x+");
	$slname=array("songlistname"=>$_POST["slname"]);
	$json=json_encode($slname);
	fwrite($file,$json);
	echo "创建歌单成功！<br />";
	fclose($file);
	$file=file_get_contents($songpaperpath);
	$songp=json_decode($file,true);
	$songplength=count($songp["songpaper"]);
	$songp["songpaper"][$songplength]["path"]=$filename;
	$songp["songpaper"][$songplength]["songlistname"]=$_POST["slname"];
	echo $songp["songpaper"][1]["path"]." ".$songp["songpaper"][1]["songlistname"];
	$json=json_encode($songp);
	$file=fopen($songpaperpath,"w");
	fwrite($file,$json);
	fclose($file);
	}
} else{echo "歌单名或文件名不能为空！";};

?>


</article>
<footer>
<div>啥</div>
</footer>
</body>
</html>