<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
<title>html5-audio</title>
<script type="text/javascript">
$(document).ready(function(e) {
	$("#volumn").hide();
	var sp={},sl=[],i=0;
	if(navigator.userAgent.indexOf("MSIE 9.0")>0){
		var fh=$("#sample").height()-8;
		$(".fm-ctn").css({"height":fh,"line-height":fh+"px"});
	}
	$.ajaxSetup({async:false});
	$.getJSON("json.php?met=sp&callback=?",function(data){
		sp=data;
	});
	//alert(sp.songpaper[0].num);
	for(s=0;s<sp.songpaper.length;s++){
		var url="json.php?met=sl&s="+sp.songpaper[s].num+"&callback=?";
		$.getJSON(url,function(data){
		sl[s]=data;
	}).error(function(){alert("error1")});
	$("<div>"+sp.songpaper[s].songlistname+"<br />（"+sl[s].songlist.length+"）</div>").appendTo("div.fm-songlist-p").addClass("fm-songlist-q");
	};
	$(".fm-songlist-q:eq(0)").addClass("fm-songlist-c");
	$("<div>退出</div>").appendTo("div.fm-songlist-p").addClass("fm-songlist-q").css("float","right");
	
	/*
	
	var fm = document.getElementById("topic-fm");
	function initFM(i,json){
		$("#fm-title").text(json.songlist[i].title).show();
		$("#fm-artist").text(json.songlist[i].artist).show();
		$("#fm-from").text(json.songlist[i].from).show();
		$("#fm-album").text("<"+json.songlist[i].album+">").show();
		$("#fm-mp3").attr("src",json.songlist[i].pathmp3);
		$("#fm-ogg").attr("src",json.songlist[i].pathogg);
		fm.load();
		fm.play();
	};
	$("button").click(function(){initFM(0,sl);});
    setInterval(function(){
		if(fm.networkState==3){$("#timeleft").text("缓冲失败!");}
		else if(fm.duration){
			var curt=fm.currentTime/fm.duration * 210;
			$("#played").css("width",curt);
			var timeleft = parseInt(fm.duration-fm.currentTime),sec=timeleft%60,sec=sec>=10?sec:"0"+sec;
		
			var timeleftstr= "-"+parseInt(timeleft/60)+":"+sec;
			$("#timeleft").text(timeleftstr);
		} else{$("#timeleft").text("缓冲中…");};
		},1000);
	initFM(i,sl);
	fm.volume=0.5;
	$("#paused").click(function(){
		fm.pause();
		$(this).css("visibility","hidden");
		$(".fm-ctn").show();
	});
	$(".fm-ctn").click(function(){
		fm.play();
		$("#paused").css("visibility","visible");
		$(".fm-ctn").hide();
	});
	$("#timevol").mouseenter(function(){
		$("#volumn").fadeIn(300); 
		$("#timeleft").hide();
	});
	$("#timevol").mouseleave(function(){
		$("#volumn").fadeOut(300);
		$("#timeleft").delay(300).fadeIn(100);
	});
	$("#volbtn").click(function(){
		if(fm.muted==false){
			$(this).css("color","#999");
			fm.muted=true;
			$("#volumn-c").css("width",0);
		} else {
			$(this).css("color","#333");
			fm.muted=false;
			var w =parseInt(fm.volume*50);
			$("#volumn-c").css("width",w);
			
		};
	});
	$("#volumn").click(function(e){
		var event= e || window.event;
		var ct=event.clientX;
		var dt=ct-$("#volumn").offset().left;
		$("#volumn-c").css("width",dt);
		fm.volume=dt/50;
	});
	fm.addEventListener('ended', function(){
		this.currentTime = 0;
		if(i == sl.songlist.length-1){
			i=0;
			initFM(i,sl);
		}else{i=i+1;initFM(i,sl);}
	}, false);
	
	
	$("#fm-loop").click(function(){
		if(!fm.loop){
		fm.loop=true;
		$(this).css("color","#0cf").siblings().css("color","#333").hover(function(){$(this).css("color","#0cf")},function(){$(this).css("color","#333")});
		}else{
		fm.loop=false;
		$(this).css("color","#333").hover(function(){$(this).css("color","#0cf")},function(){$(this).css("color","#333")}).siblings().css("color","#333").hover(function(){$(this).css("color","#0cf")},function(){$(this).css("color","#333")});
		};
	});
	$("#fm-like").click(function(){
		fm.loop=false;
		$(this).css("color","#0cf").siblings().css("color","#333").hover(function(){$(this).css("color","#0cf")},function(){$(this).css("color","#333")});
	});
	$("#fm-next").click(function(){
		if(i == sl.songlist.length-1){
			i=0;
			initFM(i,sl);
		}else{i=i+1;initFM(i,sl);}
	});
	*/
	$("#fm-songlist").click(function(){
		$(".fm-songlist-p").show();
	});
	$(".fm-songlist-q:last").click(function(){
		$(".fm-songlist-p").hide();
	});
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
.playrow:hover,#fm-songlist:hover{color:#0CF;}
.clear{clear:both;}
</style>
</head>

<body>

<audio id="topic-fm">
	<source id="fm-mp3" src="" />
    <source id="fm-ogg" src="" />
</audio>
<fieldset id="sample">
<legend>Idlelife FM</legend>
<div class="fm-ctn">继续播放&gt;</div>
<div class="fm-songlist-p">请选择歌单：<div class="clear"></div></div>
<div id="paused">〓</div>

<div id="fm-artist">Unknown Artist</div>
<div style="margin:0px 6px auto 6px;overflow:hidden;width:208px; text-overflow:ellipsis;white-space:nowrap;">

<span id="fm-album">&lt;Unknown Album&gt;</span><br />
<span id="fm-from">Unknown</span><br />
<span id="fm-title">Unknown Title</span>
</div>
<div id="progressbar"><div id="played"></div></div>
<div id="timevol">
    <div id="volumn"><div id="volumn-c"></div></div>
    <span id="volbtn">&#9738;</span>
	<span id="timeleft">-0:00</span>



</div>
<div class="clear"></div>

<div><div id="fm-songlist">歌单</div>
	<div id="fm-next" class="playrow"><span style="font-size:14px;line-height:25px;">▶▶▎</span><br />下一首</div>
  <div id="fm-like" class="playrow"><span style="font-size:18px;line-height:25px;">&#9850;</span><br />播放喜欢</div>
  <div id="fm-loop" class="playrow"><span style="font-size:18px;line-height:25px;">&#10227;</span><br />单曲循环</div>
  
</div>

</fieldset>
<br />
<br />
<button value="btn">初始化</button>
</body>
</html>
