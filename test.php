<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
<style type="text/css">
html{height:100%}
body{height:100%;width:960px;margin:0 auto;background-color:#eee;}
</style>
</head>
<script type="text/javascript">
$(document).ready(function(e) {
	//var sp={};
	$.ajaxSetup({async:false});
	$.getJSON("json.php?met=sp&callback=?",function(data){
	//	sp=data;
		alert(data);
	});
	
});
</script>
<body>
<div></div>


</form>
</body>
</html>