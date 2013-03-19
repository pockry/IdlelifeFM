(function($){
$.fn.idlelifeFM = function(e){
	$("#volumn").hide();
	var sp={},sl=[],fl=[],i=0,n=0;
	if(true){
		var fh=$("#sample").height()-8;
		$(".fm-ctn").css({"height":fh,"line-height":fh+"px"});
		$(".fm-songlist-p").css({"height":fh});
	};
	$.ajaxSetup({async:false});
	$.getJSON("json.php?met=sp&callback=?",function(data){
		sp=data;
	});
	if(sp.songpaper=="undefined"){alert("歌单载入出错！");};
	for(s=0;s<sp.songpaper.length;s++){
		var url="json.php?met=sl&s="+sp.songpaper[s].num+"&callback=?";
		$.getJSON(url,function(data){
		sl[s]=data;
	}).error(function(){alert("error1")});
	$("<div>"+sp.songpaper[s].songlistname+"<br />（"+sl[s].songlist.length+"）</div>").appendTo("div.fm-songlist-p").addClass("fm-songlist-q");
	};
	$(".fm-songlist-q:eq(0)").addClass("fm-songlist-c");
	$("<div>退出</div>").appendTo("div.fm-songlist-p").addClass("fm-songlist-q").css({
		"position":"absolute",
		"bottom":"3px",
		"right":"3px",
		"z-index":"101",
	});
	
	
	
	var fm = document.getElementById("topic-fm");
	function initFM(i,json,n){
		$("#fm-title").text(json[n].songlist[i].title).show();
		$("#fm-artist").text(json[n].songlist[i].artist).show();
		$("#fm-from").text(json[n].songlist[i].from).show();
		$("#fm-album").text("<"+json[n].songlist[i].album+">").show();
		$("#fm-mp3").attr("src",json[n].songlist[i].pathmp3);
		$("#fm-ogg").attr("src",json[n].songlist[i].pathogg);
		fm.load();
		fm.play();
	};
	$("button").click(function(){initFM(0,sl,0);});
    setInterval(function(){
		if(fm.networkState==3){
			$("#timeleft").text("缓冲失败!");
			$("#played").css("width",0);
		}
		else if(fm.duration){
			var curt=fm.currentTime/fm.duration * 210;
			$("#played").css("width",curt);
			var timeleft = parseInt(fm.duration-fm.currentTime),sec=timeleft%60,sec=sec>=10?sec:"0"+sec;
		
			var timeleftstr= "-"+parseInt(timeleft/60)+":"+sec;
			$("#timeleft").text(timeleftstr);
		} else{$("#timeleft").text("缓冲中…");};
		},1000);
	//initFM(i,sl,n);
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
		if(i == sl[n].songlist.length-1){
			i=0;
			initFM(i,sl,n);
		}else{i=i+1;initFM(i,sl,n);}
	}, false);
	
	
	$("#fm-loop").click(function(){
		if(fm.loop==false){
		fm.loop=true;
		$(this).addClass("fm-loop-c");
		}else{
		fm.loop=false;
		$(this).removeClass("fm-loop-c");
		};
	});
	$("#fm-like").click(function(){
	
	});
	$("#fm-next").click(function(){
		if(i == sl[n].songlist.length-1){
			i=0;
			initFM(i,sl,n);
		}else{i=i+1;initFM(i,sl,n);}
	});
	$("#fm-songlist").click(function(){
		$(".fm-songlist-p").show();
	});
	$(".fm-songlist-q:not(:last)").click(function(){
		n=$(this).index()-1;
		i=0;
		initFM(i,sl,n);
		$(this).addClass("fm-songlist-c").siblings().removeClass("fm-songlist-c");
		$(".fm-songlist-p").delay(300).fadeOut(300);
	});
	$(".fm-songlist-q:last").click(function(){
		$(".fm-songlist-p").hide();
	});
	function addSVG(){
		$("<svg width='28px' height='26px'><g><rect fill='#9DD6C5' width='28' height='26'/><rect x='7' y='6' fill='#FFFFFF' width='4' height='14'/><rect x='17' y='6' fill='#FFFFFF' width='4' height='14'/></g></svg>").appendTo("#paused");
		$("<span><svg width='16px' height='16px'><path fill='#333333' d='M13.683,8c-0.006,3.556-2.546,5.677-5.683,5.683c-3.139-0.006-5.678-2.543-5.684-5.682 C2.322,4.862,4.861,2.322,8,2.317c1.268,0,2.426,0.416,3.37,1.114l-1.179,1.181l5.579,1.495l-1.496-5.579l-1.252,1.251 C11.651,0.669,9.899,0,8,0C3.581,0.002,0.001,3.583,0,8c0.002,4.42,3.581,8,8,8c4.418,0,8-3.556,8-8H13.683z'/></svg></span>").prependTo("#fm-loop");
		$("<span><svg width='26.134px' height='16px'><path fill='#333333' d='M22.756,0v6.4L11.377,0v6.4L0,0v16l11.377-6.4V16l11.378-6.4V16h3.378V0H22.756z'/></svg></span>").prependTo("#fm-next");
		$("<svg width='15.691px' height='14px'><path stroke='#999999' fill='none' d='M14.474,1.22c-1.691-1.693-4.542-1.611-6.335,0.18L7.846,1.692L7.553,1.399 C5.761-0.393,2.908-0.475,1.218,1.22c-1.692,1.69-1.611,4.541,0.18,6.334L7.845,14l6.447-6.446 C16.085,5.763,16.167,2.91,14.474,1.22z'/></svg>").appendTo("#fm-like-i");
	};
	addSVG();
	$("#paused").mouseover(function(){$(this).find("rect").eq(0).attr("fill","#b8f1e0");}).mouseout(function(){$(this).find("rect").eq(0).attr("fill","#9DD6C5");});
	$(".playrow").mouseover(function(){$(this).find("path").attr("fill","#0cf");}).mouseout(function(){$(this).find("path").attr("fill","#333");});
	$("#fm-like-i").mouseover(function(){$(this).find("path").attr("stroke","#f33");}).mouseout(function(){$(this).find("path").attr("stroke","#999");});
	$("#fm-like-i").click(function(){
		if(true){
		$(this).unbind("mouseover").unbind("mouseout").find("path").attr("stroke","none").attr("fill","#f33");
		};
	});
})(jQuery);