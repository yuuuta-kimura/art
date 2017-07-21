<?php

//////////////////////////////////////
// user/getgallery.php
//////////////////////////////////////


function returnJson($resultArray){
  if(array_key_exists('callback', $_GET)){
    $json = $_GET['callback'] . "(" . json_encode($resultArray) . ");";
  }else{
    $json = json_encode($resultArray);
  }
  header('Content-Type: text/html; charset=utf-8');
  echo  $json;
  exit(0);
}

require('dbconnect.php');
require('pdosql.php');


$artist_id = $_REQUEST['artist_id'];
$limit = $_REQUEST['limit'];
$apikey = $_REQUEST['apikey'];


$result = [];
$arr = array();


try {

	if (empty($artist_id)) {
		throw new Exception("no artis_id");
	}
	if (empty($limit)) {
		throw new Exception("no limit");
	}

	if (empty($apikey)) {
		throw new Exception("no apiid");
	}
	
	$db = dbconnect();

	$systemkey='3j7j5e1iomx2z17lf2c6wi5eh3k298jz8xudrnyxdmolvpa8qdiuw9t52rx348lpb6togwgpnq8g5wimec464acisvkqpbxh5nn488ci6won3f4qvgkuqav2hcj3s52r0phrvh05ztnjld81boqepvmj6ytuyr49y8trq4eyortfdpha57yrse0z4wnod3425j57k4cskb9dr3ghd3t2y0akgkxoiu21m1sabqv1qz37ct3ejkoh7w7hgqmdepoxggfvjmkspadbjqc1dx9xvrqsblonshns21kqwuuvwowzu6fo4j0hji0q1unqizeba2q575n0gvp1w09pdqh9iizd8xw166axt9vfvje6qn8pvzmir0bt9xl6fter6x0p05fe7dltu7f7l4q6pbor2h0di8r8r4kouc811vixbq5bdonczc8440ocokv349hvhwg2lygjmdiqwq7hvve5a2uppy84q0nf1qvxh85jgorvmh8rb0ov3748pq6mpwpoyqytmjfu06llrbl2lght174t4gq6mzlxt7kcz5muoefpngz0qts86tae5gkrn2k1d0tz9byyqysmsxq49oefasp188udajxgvplnavn77d975imv79np87t92l77306told485gvm6fpfkmwc5gsu1rk9ykxgjkceqnuq3sanb26cjygexn9ub5zxcmbu5j71fiocat1eccd4ojgy129a32q3vzqznpd49hxrssxl2rslecds3xu5v6nxixm72hcic999j7xospjydpykq8qgxe9cp1iq5d262djz8ve0l07jhzdmu4hsjxsl7ve99ysoddt8foq757llqvd5a5hxydmiwqd5gzgms36phjw2ae71o0ra3ue49ua1vj6t0xw1orqzxxn1ctwiaog22gu49058xenkhmbrd1rb6s1mbe5c1hl0ccvhqo9b2l0eyvcryhfy2gssm9aix27gv7s1zh579owyh2aoti0aop8ir3eyoz2p3h0xeb28fwx3erh';
	
    $ciphertext = openssl_encrypt($apikey, 'AES-128-ECB', $systemkey, OPENSSL_RAW_DATA);
	$hex=bin2hex($ciphertext);
	
	$sql = sprintf('SELECT COUNT(*) AS cnt FROM TM_API WHERE artist_id=%d AND password="%s"',
				$artist_id, $hex
				);
	
	$record = $db->query($sql);
	if ($record->fetchColumn() <= 0) {		
		throw new Exception("different apiid");
	}
	
	
	$sql=sprintf("SELECT * FROM TT_WORKS WHERE artist_id=%d AND top_open_flg=1 AND open_flg=1 ORDER BY regist_time DESC LIMIT %d",$artist_id, $limit);
	$record=NULL;
	$record=$db->query($sql);
	
	while($data=$record->fetch(PDO::FETCH_ASSOC)){
		array_push($arr,$data);
	}
	
	$db=NULL;
	
	$result = [
	'result' => 'OK',
	'works' => $arr
	];
} catch (Exception $e) {
	$result = [
	'result' => 'NG',
	'message' => $e->getMessage()
	];
	$db=NULL;
}

//  JSONでレスポンスを返す
returnJson($result);

?>