<?php

$dirs = shell_exec("ls dataset");
$dirs = split("\n",$dirs);
//for($x = 0; $x<count($dirs);$x++){
//	if(strrpos($dirs[$x],".") > -1 || strlen($dirs[$x]) < 1){
//		unset($dirs[$x]);
//		$x--;
//	}
//}
echo json_encode($dirs);// $dirs;
?>