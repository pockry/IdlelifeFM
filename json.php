<?php
$jsondata = "{symbol:'IBM', price:120}";
echo $_GET['callback'].'('.$jsondata.')';

?>