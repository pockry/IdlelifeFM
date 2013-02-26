<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
<title>html5-audio</title>
<script type="text/javascript">
$(document).ready(function(e) {

});
</script>
<style type="text/css">
iframe{display:none;}
</style>
</head>

<body>
<div>
eee<br />
<iframe name='vdisk' src=''></iframe>
<input type="button" value="try" style="width:120px;height:32px;" onclick="window.open ('http://www.vdisk.cn/api/webupload?success=http://localhost:8080/fm/test.php&user=kyonko','newwindow','height=100,width=700,top=200,left=200,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no')">
</div>

    <?php
    error_reporting(0);
	if(isset($_GET["downurl"])){
    $opts = array(
    'http'=>array('method'=>"GET",'header'=>"User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.3)\r\n")
    );
    $context = stream_context_create($opts);
    $url = $_GET["downurl"];
    $data = file_get_contents($url,false,$context);
    preg_match("/name=.httpfileurl..content=.(.*?).>/", $data, $data);
    $myurl = $data[1];
    if($myurl){
    echo "<input type=text value='".$myurl."' />";
    die();
    }
    else
    echo "参数错误";
	};
    ?>

</body>
</html>
