<?php
function getUrlContent($url, $cookie, $ua){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, $ua);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch, CURLOPT_COOKIE, $cookie);
	$data = curl_exec($ch);
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	return ($httpcode>=200 && $httpcode<300) ? $data : $httpcode;
}

function resolveTid($res) {
	$pos = stripos($res, 'commonui.postArg.proc( 0');
	$posend = stripos($res, '0 )', $pos);
	$needle = substr($res, $pos, $posend - $pos);
	$exploded = explode('\'', $needle);
	$explodeded = explode(',', $exploded[17]);
	$good = $explodeded[1];
	$bad = $explodeded[2];
	return array('good' => $good, 'bad' => $bad);
}

function resolvePid($res) {
	$pos = stripos($res, 'commonui.postArg.proc( 0');
	$posend = stripos($res, '0 )', $pos);
	$needle = substr($res, $pos, $posend - $pos);
	$exploded = explode('\'', $needle);
	$explodeded = explode(',', $exploded[17]);
	$good = $explodeded[1];
	$bad = $explodeded[2];
	return array('good' => $good, 'bad' => $bad);
}

$cookie = 'CNZZDATA1256638820=390511242-1479453915-http%253A%252F%252Fbbs.ngacn.cc%252F%7C1510879713;CNZZDATA1256638828=946017144-1467876234-http%253A%252F%252Fbbs.bigccq.cn%252F%7C1504577587;CNZZDATA1256638851=934485016-1467876038-http%253A%252F%252Fbbs.bigccq.cn%252F%7C1505281279;CNZZDATA1256638858=1198529290-1471828718-http%253A%252F%252Fbbs.ngacn.cc%252F%7C1504497671;CNZZDATA1256638915=937876947-1510631340-http%253A%252F%252Fbbs.ngacn.cc%252F%7C1510707038;CNZZDATA1256638919=2020260462-1467876372-http%253A%252F%252Fbbs.bigccq.cn%252F%7C1506743398;CNZZDATA1256638924=1970676732-1478652037-http%253A%252F%252Fbbs.ngacn.cc%252F%7C1507507513;CNZZDATA1256638943=847646260-1478586669-http%253A%252F%252Fbbs.bigccq.cn%252F%7C1499835868;CNZZDATA1264400273=382669804-1505267425-http%253A%252F%252Fbbs.ngacn.cc%252F%7C1508892101;CNZZDATA30039253=cnzz_eid%3D1777353291-1464569208-null%26ntime%3D1510876502;CNZZDATA30043604=cnzz_eid%3D1933054826-1464568397-null%26ntime%3D1510876528;Hm_lpvt_60031dda34b454306f907cbac1fb2081=1491376791;Hm_lvt_60031dda34b454306f907cbac1fb2081=1490171673,1491037651,1491037783;PHPSESSID=pnu1pqkhs4dr66v85898doea92;UM_distinctid=15e4c092f1bace-09b19d71c52273-3a3e5f04-13c680-15e4c092f1c603;__tst_cookieid=360824482#;__utma=240585808.1008217655.1464572816.1510806122.1510879388.752;__utmc=240585808;__utmz=240585808.1505973883.695.1.utmccn=(direct)|utmcsr=(direct)|utmcmd=(none);bbsmisccookies=%7B%22insad_refreshid%22%3A%7B0%3A%22/ec61637a2293186444c851a0%22%2C1%3A1511404296%7D%2C%22pv_count_for_insad%22%3A%7B0%3A-19%2C1%3A1510938098%7D%2C%22insad_views%22%3A%7B0%3A1%2C1%3A1510938098%7D%7D;lastpath=/read.php?tid=12864498&_ff=-7;lastvisit=1510881728;ngaPassportCid=Z8h74a5rbv2pljuur7c1dhhdoi2tg11f90bafres;ngaPassportUid=34060742;ngaPassportUrlencodedUname=%25B4%25F3%25C5%25D6%25CE%25AC%25CE%25AC;ngacn0comInfoCheckTime=1510881695;ngacn0comUserInfo=%25B4%25F3%25C5%25D6%25CE%25AC%25CE%25AC%09%25E5%25A4%25A7%25E8%2583%2596%25E7%25BB%25B4%25E7%25BB%25B4%0942%0942%09%09-10%092200%094%090%090%098_-150%2C16_-450%2C85_-150%2C61_38%2C39_15;ngacn0comUserInfoCheck=f4c5d1c81d91787fb6c5fcf64eccec06;';
$ua = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0;';
$url = 'http://bbs.ngacn.cc/read.php?';
$finalRes = array();
if(array_key_exists('tid', $_GET)) {
	
	$tid = 'tid='.$_GET['tid'];
	$res = getUrlContent($url.$tid, $cookie, $ua);
	$finalRes['tid'] = resolveTid($res);
}
if(array_key_exists('pid', $_GET)) {
	$pid = 'pid='.$_GET['pid'];
	$res = getUrlContent($url.$pid, $cookie, $ua);
	$finalRes['pid'] = resolvePid($res);
}

echo json_encode($finalRes);
?>