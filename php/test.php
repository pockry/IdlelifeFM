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
$(document).ready(function(e) {
$("button").click(function(){
if(window.localStorage){
 alert('This browser supports localStorage');
}else{
 alert('This browser does NOT support localStorage');
};
});
});


</script>
<style type="text/css">

</style>
</head>

<body>



	<button type="button">hehe</button>

</body>
</html>