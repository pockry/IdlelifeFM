<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
<title>html5-audio</title>
<script type="text/javascript">
$(document).ready(function(e) {
var aArr = [];
for(var i=0; i<100;i++){
    aArr.push(i); //aArr[i] = i;
}
function randomSort(a,b){ //数组元素随机排列
    return Math.random()>.5 ? -1:1;
}
aArr.sort(randomSort);
 //alert(aArr);
 
 $(".playrow").mouseover(function(){$(this).find("path").attr("fill","#0cf");}).mouseout(function(){$(this).find("path").attr("fill","#333");});
});
</script>
<style type="text/css">
#sample{
	border:1px solid #666;
	width:220px;
	font-size:12px;
	font-family:"Microsoft Yahei";
	padding:0;
	color:#333;
	position:relative;
}
#sample legend{margin-left:10px;}

#fm-artist{float:left;margin:0px 6px;font-size:18px;display:inline-block;overflow:hidden;width:170px; text-overflow:ellipsis;white-space:nowrap;}
#fm-album{}
#fm-from{color:#666;}
#fm-title{display:block;color:#009966;margin-top:10px;margin-bottom:5px;}

#progressbar{
	margin:0px 5px;
	width:210px;
	height:2px;
	background-color:#eee;
}
#played{
	height:inherit;
	background-color:#9dd6c5;
	float:left;
}
#paused{
	transform:rotate(90deg);
	-ms-transform:rotate(90deg);
	-webkit-transform:rotate(90deg);
	-moz-transform:rotate(90deg);
	display:inline-block;
	float:right;
	font-size:14px;
	background-color:#9dd6c5;
	padding:3px 6px 6px 6px;
	margin:-9px 10px 0 0;
	cursor:pointer;
	color:white;
	
}
#paused:hover{background-color:#b8f1e0;}
#timevol{
	text-align:right;
	line-height:27px;
	height:27px;
	padding-right:5px;
}
#timeleft,#volbtn{
	display:block;
	float:right;
	margin:auto 1px;
	z-index:20;
}
#fm-like-i{
	float:left;
	margin-left:5px;
	margin-top:7px;
}

#volbtn{font-size:18px;cursor:pointer;}
#volumn{
	float:right;
	height:3px;
	width:50px;
	background-color:#eee;
	cursor:pointer;
	margin-top:12px;
	margin-left:3px;
	
}
#volumn-c{
	height:inherit;
	width:25px;
	background-color:#333333;
	cursor:pointer;
}

.playrow{
	display:inline-block;
	float:right;
	margin:3px;
	padding:3px;
	border:1px solid #999;
	text-align:center;
	cursor:pointer;
}
.fm-ctn,.fm-songlist-p{
	display:none;
	z-index:100;
	position:absolute;
	text-align:center;
	width:inherit;
	height:184px;
	line-height:184px;
	vertical-align:middle;
	margin-top:-8px;
	background-color:rgba(255,255,255,0.6);
	cursor:pointer;
}
.fm-songlist-p{
	text-align:left;
	line-height:1.5em;
	cursor:default;
	background-color:rgba(255,255,255,0.8);
}
.fm-songlist-q{border:1px solid #999;width:auto;height:auto;line-height:1.2em;float:left;margin:3px;cursor:pointer;padding:3px;text-align:center;}
.fm-songlist-c{color:#ff0000;}
#fm-songlist{position:absolute;bottom:3px;left:3px;border:1px solid #999;cursor:pointer;padding:3px;}
.playrow:hover,#fm-songlist:hover,.fm-loop-c{color:#0cf;}
.playrow span{display:block;height:25px;font-size:16px;vertical-align:middle;}
.playrow span svg{margin-top:4px;}
.clear{clear:both;}
</style>
</head>

<body>

	<div id="fm-next" class="playrow"><span>
	<svg width="26.134px" height="16px">
<path fill="#333333" d="M22.756,0v6.4L11.377,0v6.4L0,0v16l11.377-6.4V16l11.378-6.4V16h3.378V0H22.756z"/>
</svg>
	</span>下一首</div>

</body>
</html>
