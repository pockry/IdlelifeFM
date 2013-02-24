<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Songlist Manager</title>
</head>

<body>

<?php
$songpaperpath="js/songpaper.js";
$jsondata = file_get_contents($songpaperpath);
$songp = json_decode($jsondata,true);
$songplength = count($songp["songpaper"]);
for($i=$songplength-1;$i>=0;$i--){
	if($songp["songpaper"][$i]["shareflag"]=="NO") {
		array_splice($songp["songpaper"],$i,1);
	};
};

$output=json_encode($songp);


if(isset($_GET['callback']) && $_GET['met']=="sp"){

	echo $_GET['callback'].'('.$output.')';
};

?>

</body>
</html>