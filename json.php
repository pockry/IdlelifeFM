<?php
$songpaperpath="js/songpaper.js";


if(isset($_GET['callback']) && $_GET['met']=="t"){
	$timestamp=file_get_contents("js/FM_timestamp.js");
	echo $_GET['callback'].'('.$timestamp.')';
};

if(isset($_GET['callback']) && $_GET['met']=="sp"){
	$jsondata = file_get_contents($songpaperpath);
$songp = json_decode($jsondata,true);
$songplength = count($songp["songpaper"]);
$output=array();
$n=0;
for($i=0;$i<$songplength;$i++){
	if($songp["songpaper"][$i]["shareflag"]=="YES"){
		$output["songpaper"][$n]["songlistname"]=$songp["songpaper"][$i]["songlistname"];
		$output["songpaper"][$n]["num"]=$i;
		$n++;
	};
};

$outputjson=json_encode($output);
	echo $_GET['callback'].'('.$outputjson.')';
};

if(isset($_GET['callback']) && $_GET['met']=="sl" && isset($_GET['s'])){
$jsondata = file_get_contents($songpaperpath);
$songp = json_decode($jsondata,true);

	$slpath=$songp["songpaper"][$_GET['s']]["path"];
	$slfile=file_get_contents($slpath);
	echo $_GET['callback'].'('.$slfile.')';
};

?>