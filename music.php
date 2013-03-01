<<<<<<< HEAD
<?php
error_reporting(0);
if(isset($_GET["url"])){
$opts = array(
'http'=>array('method'=>"GET",'header'=>"User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.3)\r\n")
);
$context = stream_context_create($opts);
$url = "http://www.vdisk.cn/down/index/".$_GET["url"];
$data = file_get_contents($url,false,$context);
preg_match("/name=.httpfileurl..content=.(.*?).>/", $data, $data);
$myurl = $data[1];
if($myurl){
    header('Content-Type:application/force-download');
    header("Location:".$myurl);
die();
}
else
echo "参数错误";
};
?>