<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href='http://fonts.googleapis.com/css?family=Roboto:100,300' rel='stylesheet' type='text/css' />
<link href='js/style.css' rel='stylesheet' type='text/css' />
<title>Songlist Manager</title>
</head>

<body>
<div class="shadowfix"><div class="heightfix">
<header>
<h1>Songlist Manager</h1>
<span class="description">A backend manager for Idlelife FM. Feel easy to make yourself a DJ!</span>
</header>
<nav>
<div>
<a class="nava" href='slmanager.php' >歌单管理</a><a class="nava" href='#' >使用帮助</a>
</div>
</nav>
<article>


<fieldset>
<legend>歌单列表</legend>
<a class='righta' href="slmanager.php?met=create">创建歌单</a>
<?php
//输出歌单列表
//本模块地址	slmanager.php
//添加歌曲： 		slmanager.php?sl=0&met=add
//批量修改mp3路径： slmanager.php?sl=0&met=mp3		
//批量修改ogg路径： slmanager.php?sl=0&met=ogg		
//编辑：			slmanager.php?sl=0
//删除：			slmanager.php?sl=0&met=del		
error_reporting(E_ALL & ~ E_NOTICE);
$songpaperpath="js/songpaper.js";
if(file_exists($songpaperpath)){
	$file=file_get_contents($songpaperpath);
	$songp=json_decode($file,true);
	$songplength=count($songp["songpaper"]);
	echo "<table><tr class='thead'><td>ID</td><td>歌单名</td><td>歌曲数</td><td>是否公开</td><td>添加歌曲</td><td>批量修改mp3路径</td><td>批量修改ogg路径</td><td>编辑</td><td>删除</td></tr>";
	for($i=0;$i<$songplength;$i++){
		$n=$i+1;
		$path=$songp["songpaper"][$i]["path"];
		$file=file_get_contents($path);
		$json=json_decode($file,true);
		$jsonlength=count($json["songlist"])?count($json["songlist"]):0;
		echo "<tr><td>".$n."</td><td>".$songp["songpaper"][$i]["songlistname"]."</td><td>".$jsonlength."</td><td>".$songp["songpaper"][$i]["shareflag"]."</td><td><a href='slmanager.php?sl=".$i."&met=add'>添加</a></td><td><a href='slmanager.php?sl=".$i."&met=mp3'>修改</a></td><td><a href='slmanager.php?sl=".$i."&met=ogg'>修改</a></td><td><a href='slmanager.php?sl=".$i."'>编辑</a></td><td><a href='javascript:void(0)' title=".$i." onclick='delsl(this.title);'>删除</a></td></tr>";
	};
	echo"</table><br />";
}else{echo "歌单配置文件不存在！";};
?>
</fieldset>

<div class='popup'>
<?php
//echo $_SERVER['HTTP_REFERER']."<br />";
$referer=$_SERVER['HTTP_REFERER'];
if(strstr($referer,"slcreate.php") || strstr($referer,"addsong.php") || strstr($referer,"edit.php") || strstr($referer,"met=del")){
echo "<span>操作成功！</span>";
};
?>
</div>

<?php
//输出歌单的title列表
//本模块地址	slmanager.php?sl=0
//编辑：			slmanager.php?sl=0&s=1&met=edit		
//删除：			slmanager.php?sl=0&s=1&met=del
if(isset($_GET["sl"]) && !isset($_GET["met"])){
	echo "<fieldset>";
	echo "<legend>歌单：".$songp["songpaper"][$_GET["sl"]]["songlistname"]."</legend>"."<a class='righta' href='slmanager.php?sl=".$_GET["sl"]."&met=edit'>修改歌单</a>";
	$path=$songp["songpaper"][$_GET["sl"]]["path"];
	$file=file_get_contents($path);
	$json=json_decode($file,true);
	$slength=count($json["songlist"]);
	echo "<table>";
	echo "<tr class='thead'><td>ID</td><td>Title</td><td>Artist</td><td>Album</td><td>From</td><td>编辑</td><td>删除</td></tr>";
	for($i=0;$i<$slength;$i++){
		$n=$i+1;
		echo "<tr><td>".$n."</td><td>".$json["songlist"][$i]["title"]."</td><td>".$json["songlist"][$i]["artist"]."</td><td>".$json["songlist"][$i]["album"]."</td><td>".$json["songlist"][$i]["from"]."</td><td><a href='slmanager.php?sl=".$_GET["sl"]."&s=".$i."&met=edit'>编辑</a></td><td><a href='javascript:void(0)' name=".$_GET["sl"]." title=".$i." onclick='delsong(this.name,this.title);'>删除</a></td></tr>";
	};
	echo "</table><br />";
	echo "</fieldset>";
};

?>


<?php
//创建歌单
//本模块地址	slmanager.php?met=create
//提交表单：		slcreate.php
if($_GET["met"]=="create"){
	echo "<fieldset><legend>创建歌单</legend><form action='slcreate.php' method='post'>";
	echo "<table class='edit'><tr><td>歌单名：</td><td><input style='width:149px;' name='slname' type='text' maxlength='50' /></td></tr>";
	echo "<tr><td>文件名：</td><td><span>FM_songlist_</span><input style='width:56px;' name='slalias' type='text' maxlength='50' id='slalias' /> </td><td><span>（请使用字母、数字和下划线）</span></td></tr></table>";
	echo "<input type='submit' value='提    交' />";
	echo "</form><br /></fieldset>";
};
?>

<?php
//修改歌单名称
//本模块地址	slmanager.php?sl=0&met=edit
//提交表单：		edit.php?sl=0&met=sl
if(isset($_GET["sl"]) && !isset($_GET["s"]) && $_GET["met"]=="edit"){
	$slalias=$songp["songpaper"][$_GET["sl"]]["path"];
	$slalias=substr($slalias,15);
	$slaliaslength=strlen($slalias);
	$slaliaslength=$slaliaslength-3;
	$slalias=substr($slalias,0,$slaliaslength);
	$path=$songp["songpaper"][$_GET["sl"]]["path"];
	$file=file_get_contents($path);
	$jsonarr=json_decode($file,true);
	$slength=count($jsonarr["songlist"])?count($jsonarr["songlist"]):0;
	$share=$slength == 0 ? "disabled" : "";
	echo "<fieldset><legend>歌单：".$songp["songpaper"][$_GET["sl"]]["songlistname"]." | 修改歌单</legend><form action='edit.php?sl=".$_GET["sl"]."&met=sl' method='post'>";
	echo "<table class='edit'><tr><td>歌单名：</td><td><input style='width:149px;' name='slname' type='text' maxlength='50' value='".$songp["songpaper"][$_GET["sl"]]["songlistname"]."' /></td></tr>";
	echo "<tr><td>文件名：</td><td><span>FM_songlist_</span><input style='width:56px;' name='slalias' type='text' maxlength='50' id='slalias' value='".$slalias."' /></td><td><span>（请使用字母、数字和下划线）</span></td></tr>";
	if($songp["songpaper"][$_GET["sl"]]["shareflag"]=="YES"){
	echo "<tr><td>是否公开：</td><td><input type=radio name=share ".$share." value=YES checked />YES<input type=radio name=share value=NO  />NO</td><td>（歌曲数不为0才可选择公开）</td></tr></table>";
	}else{
	echo "<tr><td>是否公开：</td><td><input type=radio name=share ".$share." value=YES />YES<input type=radio name=share value=NO checked />NO</td><td>（歌曲数不为0才可选择公开）</td></tr></table>";
	};
	echo "<input type='submit' value='提    交' />";
	echo "</form><br /></fieldset>";
};
?>


<?php
//动态输出添加歌曲页面
//本模块地址	slmanager.php?sl=0&met=add
//提交表单：		addsong.php?sl=0
if(isset($_GET["sl"]) && $_GET["met"]=="add"){
	echo "<fieldset><legend>歌单：".$songp["songpaper"][$_GET["sl"]]["songlistname"]." | 添加歌曲</legend>";
	echo "<form action='addsong.php?sl=".$_GET["sl"]."' method=post>";
	echo "<table class='edit'><tr><td>Title：</td><td><input name=sltitle type=text /></td></tr>";
	echo "<tr><td>Artist：</td><td><input name=slartist type=text /></td></tr>";
	echo "<tr><td>Album：</td><td><input name=slalbum type=text /></td></tr>";
	echo "<tr><td>From：</td><td><input name=slfrom type=text /></td></tr>";
	echo "<tr><td>Pathmp3：</td><td><input name=slpmp3 type=text /></td></tr>";
	echo "<tr><td>Pathogg：</td><td><input name=slpogg type=text /></td></tr></table>";
	echo "<input type=submit value='提    交' />";
	echo "</form>";
	echo "<br /></fieldset>";
};
?>
<?php
//编辑歌曲页面
//本模块地址	slmanager.php?sl=0&s=1&met=edit
//提交表单：		edit.php?sl=0&s=1
if(isset($_GET["sl"]) && isset($_GET["s"]) && $_GET["met"]=="edit"){
	$path=$songp["songpaper"][$_GET["sl"]]["path"];
	$file=file_get_contents($path);
	$json=json_decode($file,true);
	echo "<fieldset><legend>歌单：".$songp["songpaper"][$_GET["sl"]]["songlistname"]." | 歌曲：".$json["songlist"][$_GET["s"]]["title"]." | 编辑歌曲</legend>";
	echo "<form action='edit.php?sl=".$_GET["sl"]."&s=".$_GET["s"]."' method=post>";
	echo "<table class='edit'><tr><td>Title：</td><td><input name=sltitle type=text value='".$json["songlist"][$_GET["s"]]["title"]."' /></td></tr>";
	echo "<tr><td>Artist：</td><td><input name=slartist type=text value='".$json["songlist"][$_GET["s"]]["artist"]."' /></td></tr>";
	echo "<tr><td>Album：</td><td><input name=slalbum type=text value='".$json["songlist"][$_GET["s"]]["album"]."' /></td></tr>";
	echo "<tr><td>From：</td><td><input name=slfrom type=text value='".$json["songlist"][$_GET["s"]]["from"]."' /></td></tr>";
	echo "<tr><td>Pathmp3：</td><td><input name=slpmp3 type=text value='".$json["songlist"][$_GET["s"]]["pathmp3"]."' /></td></tr>";
	echo "<tr><td>Pathogg：</td><td><input name=slpogg type=text value='".$json["songlist"][$_GET["s"]]["pathogg"]."' /></td></tr></table>";
	echo "<input type=submit value='提    交' />";
	echo "</form>";
	echo "<br /></fieldset>";
};
?>

<?php
//批量修改mp3路径
//本模块地址	slmanager.php?sl=0&met=mp3
//提交表单：		edit.php?sl=0&met=mp3
if(isset($_GET["sl"]) && $_GET["met"]=="mp3"){
	$path=$songp["songpaper"][$_GET["sl"]]["path"];
	$file=file_get_contents($path);
	$json=json_decode($file,true);
	$slength=count($json["songlist"])?count($json["songlist"]):0;
	if($slength==0){echo "此歌单内没有歌曲，请先行添加！";}
	else{
	echo "<fieldset><legend>歌单：".$songp["songpaper"][$_GET["sl"]]["songlistname"]." | 批量修改MP3路径</legend><form action='edit.php?sl=".$_GET["sl"]."&met=".$_GET["met"]."' method=post>";
	echo "<table class='edit'>";
	for($i=0;$i<$slength;$i++){
		$n=$i+1;
		echo "<tr><td>".$n."</td><td>".$json["songlist"][$i]["title"]."</td><td><input name='slpmp3_".$i."' type=text value='".$json["songlist"][$i]["pathmp3"]."'/></td></tr>";
	};
	echo "</table>";
	echo "<input type=submit value='提    交' />";
	echo "</form><br /></fieldset>";
	};
};
?>

<?php
//批量修改ogg路径
//本模块地址	slmanager.php?sl=0&met=ogg
//提交表单：		edit.php?sl=0&met=ogg
if(isset($_GET["sl"]) && $_GET["met"]=="ogg"){
	$path=$songp["songpaper"][$_GET["sl"]]["path"];
	$file=file_get_contents($path);
	$json=json_decode($file,true);
	$slength=count($json["songlist"])?count($json["songlist"]):0;
	if($slength==0){echo "此歌单内没有歌曲，请先行添加！";}
	else{
	echo "<fieldset><legend>歌单：".$songp["songpaper"][$_GET["sl"]]["songlistname"]." | 批量修改OGG路径</legend><form action='edit.php?sl=".$_GET["sl"]."&met=".$_GET["met"]."' method=post>";
	echo "<table class='edit'>";
	for($i=0;$i<$slength;$i++){
		$n=$i+1;
		echo "<tr><td>".$n."</td><td>".$json["songlist"][$i]["title"]."</td><td><input name='slpogg_".$i."' type=text value='".$json["songlist"][$i]["pathogg"]."'/></td></tr>";
	};
	echo "</table>";
	echo "<input type=submit value='提    交' />";
	echo "</form><br /></fieldset>";
	};
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
};
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
</div>
<footer>
<div id="fmicon">FM</div>
<span>Idlelife FM and Songlist Manager are open source project, created by pockry@idlelife.org. Visit <a href="#">GitHub page</a> for the newest version, or visit <a href="#">blog page</a> to leave a message.</span>
</footer>
</div>
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