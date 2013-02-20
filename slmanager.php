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
body{font-size:14px;color:#333;}
table{text-align:center;}
tr:hover{background-color:#eee;}
td{border:1px solid #333;min-width:2em;}
</style>
</head>

<body>
<header>
<h1>制作你的歌单！</h1>
</header>
<nav>
<ul>
	<li><a href="slmanager.php?met=create">创建歌单</a></li>
    <li>管理歌单</li>
</ul>
</nav>
<article>


<div>歌单列表<br />
<?php
//输出歌单列表
//本模块地址	slmanager.php
//添加歌曲： 		slmanager.php?sl=0&met=add
//批量修改mp3路径： slmanager.php?sl=0&met=mp3		todo
//批量修改ogg路径： slmanager.php?sl=0&met=ogg		todo
//编辑：			slmanager.php?sl=0
//删除：			slmanager.php?sl=0&met=del		
error_reporting(E_ALL & ~ E_NOTICE);
$songpaperpath="js/songpaper.js";
if(file_exists($songpaperpath)){
	$file=file_get_contents($songpaperpath);
	$songp=json_decode($file,true);
	$songplength=count($songp["songpaper"]);
	echo "<table><tr style='font-weight:bold;'><td>ID</td><td>歌单名</td><td>歌曲数</td><td>添加歌曲</td><td>批量修改mp3路径</td><td>批量修改ogg路径</td><td>编辑</td><td>删除</td></tr>";
	for($i=0;$i<$songplength;$i++){
		$n=$i+1;
		$path=$songp["songpaper"][$i]["path"];
		$file=file_get_contents($path);
		$json=json_decode($file,true);
		$jsonlength=count($json["songlist"])?count($json["songlist"]):0;
		echo "<tr><td>".$n."</td><td>".$songp["songpaper"][$i]["songlistname"]."</td><td>".$jsonlength."</td><td><a href='slmanager.php?sl=".$i."&met=add'>添加歌曲</a></td><td><a href='slmanager.php?sl=".$i."&met=mp3'>修改</a></td><td>修改</td><td><a href='slmanager.php?sl=".$i."'>编辑</a></td><td><a href='javascript:void(0)' title=".$i." onclick='delsl(this.title);'>删除</a></td></tr>";
	};
	echo"</table><br /><br />";
}else{echo "出错！";};
?>
</div>
<div>
<?php
//输出歌单的title列表
//本模块地址	slmanager.php?sl=0
//编辑：			slmanager.php?sl=0&s=1&met=edit		todo
//删除：			slmanager.php?sl=0&s=1&met=del
if(isset($_GET["sl"]) && !isset($_GET["met"])){
	echo $_SERVER['HTTP_REFERER']."<br />";
	$path=$songp["songpaper"][$_GET["sl"]]["path"];
	$file=file_get_contents($path);
	$json=json_decode($file,true);
	$slength=count($json["songlist"]);
	echo "<table>";
	for($i=0;$i<$slength;$i++){
		$n=$i+1;
		echo "<tr><td>".$n."</td><td>".$json["songlist"][$i]["title"]."</td><td><a href=".$n.">编辑</a></td><td><a href='javascript:void(0)' name=".$_GET["sl"]." title=".$i." onclick='delsong(this.name,this.title);'>删除</a></td></tr>";
	};
	echo"</table><br /><br />";
};

?>
</div>

<?php
//创建歌单
//本模块地址	slmanager.php?met=create
//提交表单：		slcreate.php
if($_GET["met"]=="create"){
	echo "<form action='slcreate.php' method='post'>";
	echo "创建歌单名称和文件名<br />";
	echo "歌单名：<input name='slname' type='text' maxlength='50' /><br />";
	echo "文件名：<span>FM_songlist_</span><input style='width:63px;' name='slalias' type='text' maxlength='50' id='slalias' /> <span>（请使用字母、数字和下划线）</span><br />";
	echo "<input type='submit' value='提交' />";
	echo "</form>";
};
?>


<?php
//动态输出添加歌曲页面
//本模块地址	slmanager.php?sl=0&met=add
//提交表单：		addsong.php?sl=0
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
//批量修改mp3路径
//本模块地址	slmanager.php?sl=0&met=mp3
//提交表单：	
if(isset($_GET["sl"]) && $_GET["met"]=="mp3"){
	echo $songp["songpaper"][$_GET["sl"]]["songlistname"]."<br />";
	$path=$songp["songpaper"][$_GET["sl"]]["path"];
	$file=file_get_contents($path);
	$json=json_decode($file,true);
	$slength=count($json["songlist"]);
	echo "<form action='' method=post>";
	echo "<table>";
	for($i=0;$i<$slength;$i++){
		$n=$i+1;
		echo "<tr><td>".$n."</td><td>".$json["songlist"][$i]["title"]."</td><td><input name='slpmp3_".$i."' type=text value='".$json["songlist"][$i]["pathmp3"]."'/></td></tr>";
	};
	echo "</table>";
	echo "<input type=submit value='提交' />";
	echo "</form>";
};
?>

<?php
//删除歌单，并且跳转回歌单页面
//本模块地址	slmanager.php?sl=0&met=del
//删除成功：		slmanager.php
if(isset($_GET["sl"]) && !isset($_GET["s"]) && $_GET["met"]=="del"){
	$path=$songp["songpaper"][$_GET["sl"]]["path"];
	unlink($path);
	array_splice($songp["songpaper"],$_GET["sl"],1);
	$songpjson=json_encode($songp);
	$file=fopen($songpaperpath,"w");
	fwrite($file,$songpjson);
	fclose($file);
	echo "<script>location.href='slmanager.php';</script>";
}；
?>

<?php
//删除歌曲，并且跳转回歌曲页面
//本模块地址	slmanager.php?sl=0&s=1&met=del
//删除成功：		slmanager.php?sl=0
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

function delsong(sl,i){
	if(confirm("你确定删除这首歌吗？")){
		var url="slmanager.php?sl="+sl+"&s="+i+"&met=del";
		location.href=url;
	}
	else {};
};

function delsl(i){
	if(confirm("你确定删除此歌单吗？歌单下的所有歌曲信息都会被删除！")){
		var url="slmanager.php?sl="+i+"&met=del";
		location.href=url;
	}
	else {};
};

</script>
</body>
</html>