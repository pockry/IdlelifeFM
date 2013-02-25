<?php
$songpaperpath="js/songpaper.js";
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


if(isset($_GET['callback']) && $_GET['met']=="sp"){

	echo $_GET['callback'].'('.$outputjson.')';
};

if(isset($_GET['callback']) && $_GET['met']=="sl" && isset($_GET['s'])){
	$slpath=$songp["songpaper"][$_GET['s']]["path"];
	$slfile=file_get_contents($slpath);
	echo $_GET['callback'].'('.$slfile.')';
};

?>