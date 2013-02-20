<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script></script>
<title>Songlist Manager</title>
<script type="text/javascript">
$(document).ready(function(e) {
	
});
</script>
<style type="text/css">
table{}
td{border:1px solid #333;min-width:2em;}
</style>
</head>

<body>
<header>
<h1>制作你的歌单！</h1>
</header>
<nav>
<ul>
	<li><a href="slmanger.php?met=create">创建歌单</a></li>
    <li>管理歌单</li>
</ul>
</nav>
<article>


<div>歌单列表<br />
<?php
error_reporting(E_ALL & ~ E_NOTICE);
$songpaperpath="js/songpaper.js";
if(file_exists($songpaperpath)){
	$file=file_get_contents($songpaperpath);
	$songp=json_decode($file,true);
	$songplength=count($songp["songpaper"]);
	echo $songplength."<br />";
	echo "<table>";
	for($i=0;$i<$songplength;$i++){
		$n=$i+1;
		$url="slmanager.php?sl="+$n;
		$url=urlencode($url);
		echo "<tr><td>".$n."</td><td>".$songp["songpaper"][$i]["songlistname"]."</td><td><a href='slmanager.php?sl=".$i."&met=add'>添加歌曲</a></td><td><a href='slmanager.php?sl=".$i."'>编辑</a></td></tr>";
	};
	echo"</table><br /><br />";
}else{echo "出错！";};
?>
</div>
<div>

<?php
//输出歌单的title，附编辑、删除功能
if(isset($_GET["sl"]) && !isset($_GET["met"])){
	echo $_SERVER['HTTP_REFERER']."<br />";
	$path=$songp["songpaper"][$_GET["sl"]]["path"];
	$file=file_get_contents($path);
	$json=json_decode($file,true);
	$slength=count($json["songlist"]);
	echo "<table>";
	for($i=0;$i<$slength;$i++){
		$n=$i+1;
		echo "<tr><td>".$n."</td><td>".$json["songlist"][$i]["title"]."</td><td><a href=".$n.">编辑</a></td><td><a href='javascript:void(0)' name=".$_GET["sl"]." title=".$i." onclick='del(this.name,this.title);'>删除</a></td></tr>";
	};
	echo"</table><br /><br />";
};

?>




</div>

<?php

?>


<?php
//动态输出添加歌曲页面
if(isset($_GET["sl"]) && $_GET["met"]=="add"){
echo "<div>添加歌曲：<br />";
echo $_GET["sl"]."<br />";
echo "<form action='addsong.php?sl=".$_GET["sl"]."' method=post>";
echo "Title：<input name=sltitle type=text /><br />";
echo "Artist：<input name=slartist type=text /><br />";
echo "Album：<input name=slalbum type=text /><br />";
echo "From：<input name=slfrom type=text /><br />";
echo "Pathmp3：<input name=slpmp3 type=text /><br />";
echo "Pathogg：<input name=slpogg type=text /><br />";
echo "<input type=submit value='提交' />";
echo "</form>";
echo "</div>";
};
?>
<?php
//删除歌曲，并且跳转回歌曲页面
if(isset($_GET["sl"]) && isset($_GET["s"]) && $_GET["met"]=="del"){
	$path=$songp["songpaper"][$_GET["sl"]]["path"];
	$file=file_get_contents($path);
	$json=json_decode($file,true);
	array_splice($json["songlist"],$_GET["s"],1);
	$json=json_encode($json);
	$file=fopen("$path","w");
	fwrite($file,$json);
	fclose($file);
	echo "<script>location.href='slmanager.php?sl=".$_GET["sl"]."';</script>";
};
?>
</article>
<footer>
<div>footer</div>
</footer>
<script type="text/javascript">

function del(sl,i){
	if(confirm("你确定删除这首歌吗？")){
		var url="slmanager.php?sl="+sl+"&s="+i+"&met=del";
		location.href=url;
	}
	else {};
};

</script>
</body>
</html>