<?php
function ngefind_admin($target,$loli){
		$c = curl_init();
		$curl_setopt = array(
			CURLOPT_URL=>$target,
			CURLOPT_RETURNTRANSFER=>1,
			CURLOPT_BINARYTRANSFER=>1,
			CURLOPT_SSL_VERIFYPEER=>0,
			CURLOPT_FOLLOWLOCATION=>0,
			);
		curl_setopt_array($c,$curl_setopt);
		$ex=curl_exec($c);
		return preg_match("/".$loli."/",$ex);
		curl_close($c);
	}
function ngefind_adminI($target){
		$gh = get_headers($target);
		return $gh;
	}
function status($o,$url){
	if($o == 1){
		echo "[<font color=green>FOUND</font>] ".$url."<br>";
	}else{
		echo "[<font color=red>NOT FOUND</font>] ".$url."<br>";
	}
}
$file = file_get_contents('wordlist.txt');
$expl = explode("\n",$file);

if($_POST['method']=='http'){
foreach($expl as $admin){
$url = $_POST['target']."/".$admin;
$o=ngefind_adminI($url);
if(preg_match("/200 OK/",$o[0])){
	status(1,$url);
}else{
	status(0,$url);
}
}
}elseif($_POST['method']=='curl'){
foreach($expl as $admin){
$url = $_POST['target']."/".$admin;
$loli = $_POST['regex'];
$lol =ngefind_admin($url,$loli);
if($lol){status(1,$url);}else{status(0,$url);}
}
}
?>
