<?php

ini_set("display_errors",1);
error_reporting(E_ALL);

require('dbconnect.php');
require('smallimage.php');

require('../pdosql.php');

session_start();

$ini = parse_ini_file('../config.ini');

$errors="";
$file_name_local = "";
$file_name_new_db="";
$arr = array();

$artist_id=$_POST['artist_id'];
$works_id=$_POST['works_id'];
$input_file=NULL;
$db_pic=NULL;

switch ($_POST['upload_btn'])
{
	case 'mainpic': 
		$input_file = $_FILES['mainpic']; 
		$db_pic='main_pic';
		break;	

	case 'basepic': 
		$input_file = $_FILES['basepic']; 
		$db_pic='base_pic';
		break;	

	default: break;
}


if(empty($input_file))
{

	$errors="-1";	
	$clm = array('url' => NULL, 'error' => -1);
	array_push($arr,$clm);
}
else
{		
	$file_ext = pathinfo($input_file["name"], PATHINFO_EXTENSION);
	$file_name_local = "../pic/".$works_id.$_POST['upload_btn'] .date('ymdHis'). "." . $file_ext;
	$file_name_local_small = "../pic/".$works_id.$_POST['upload_btn'] .date('ymdHis')."small". "." . $file_ext;
	$file_name_new_db = $works_id.$_POST['upload_btn'] .date('ymdHis'). "." . $file_ext;	
	if($db_pic=='main_pic'){
		$file_name_new_db_small = $works_id.$_POST['upload_btn'] .date('ymdHis')."small". "." . $file_ext;
	}
	
	//アップロード可能な拡張子であるか調べる
	if(FileExtensionGetAllowUpload($file_ext))
	{
		//ファイルの移動を行う
		if (!move_uploaded_file($input_file["tmp_name"], $file_name_local))
		{
			$errors="-2";
			$clm = array('url' => NULL, 'error' => -2);
			array_push($arr,$clm);
		}else
		{
			//ユーザー閲覧用のディレクトリに移動
			$upload_pic = "";
			chmod($file_name_local, 0644);// ファイルのパーミッションを確実に0644に設定する
			if($db_pic=='main_pic'){
				//SNS用のサムネイル画像を作成
				smallimage($file_name_local,$file_name_local_small,400);
				chmod($file_name_local_small, 0644);
			}

			//本番サーバーに転送
			$key='j3kihic1ryku5pgeqc09o8xsaf27vegssuahc87zguox0d2kb4ug4tr6tji9r8bs8zf205s1rlywk0k1t1e5tt2b6rjtgo6fhe1o3wv1inv0dgl6h9tch1kr7km6yfpmsmblty21s3owamjhijj6oux2sywlnuiov8pl4rusvqcy28niigu4qze570lcki3efgisr2c8jfv4utt9nua98zemr9ycna5t77nd5yoh822r2hj8iskpskl3r0mcpsj550x1jea2oj328y4dj700dbgrsdie6ke8jrpuztfgoood65xi9oj7dx0puttsuqlk755i7sny516v3dwemuqnn6qgerydk4clzdmlq475c31ge6mfqwb7jz9o4gax586ywth2pfgbrq6i2y7foml6yenzre6g3k6m1jaxy78e1rz4p40jkb9z4lxqog48csoxwkq3n9l2xna42igv563zfzi9vom2sftspz12k562u35rnvy3k3moqhgce50f69tdzi4v4upkxtfkig0l5xdjaftm8wiodcuspwev6sa7sjggb5gpbm93rvj66espsqc109kh7l7cz6cyqvibt0k4dh2thqpc9cfqw08m2vucuz7is6t54n77ksmbxa6l447gx4j5bkxr3pfd43qbxvie0pbkvciwliefbrs19nivrnxxa3f1dltaxjsrh4lcogjh117yu6bbft2trax6ahcydveoilqharl2wv08uifyuizptf0tkkix0cn90j6zuc95x3pnq88oplk7j77u4l8hekutlljhik5v81vp494jjp67mu5nz336xce5xrd1ggxo3z4fxpo99czvsyn4b6wqlxaku0w64mpmcvm2jv5c4b9pzwnetiybpxqafed446eu3s72xyog7osk4h11r6ryrkbeotvxz10t2p4c88vrli8s8pk60tkc86c9qp8p4r12wnpiwi51n7yvu8cnclas6zqao5ygggi5iz33ho5x3ssyaf0m669f3f42nrayl0k8';
			
			$ftp_server = openssl_decrypt(hex2bin($ini['FTP_SERVER']), 'AES-128-ECB', $key,OPENSSL_RAW_DATA);
			$ftp_user_name = openssl_decrypt(hex2bin($ini['FTP_USER_NAME']), 'AES-128-ECB', $key,OPENSSL_RAW_DATA);
			$ftp_user_pass = openssl_decrypt(hex2bin($ini['FTP_USER_PASS']), 'AES-128-ECB', $key,OPENSSL_RAW_DATA);
			
			//$ftp_server="ftp.7135244fd63eb4a7.lolipop.jp";
			//$ftp_user_name="lolipop.jp-7135244fd63eb4a7";
			//$ftp_user_pass="yuta6151";

			$domain =$ini['DOMAIN1'];
			//$domain ="http://art.newdimension.co.jp";
			
			// 接続を確立する
			$conn_id = ftp_connect($ftp_server);
			
			// ユーザー名とパスワードでログインする
			$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

			//ディレクトリ作成
			$ftp_dir1 =$ini['FTP_DIR1'];
			$ftp_dir2 =$ini['FTP_DIR2'];
			//$ftp_dir1 ="art/works_pictures";
			//$ftp_dir2 ="works_pictures";

			$articleiddir='';
			$pic_url='';

			$articleiddir=sprintf("%s/%d",$ftp_dir1,$artist_id);
			@ftp_mkdir($conn_id,$articleiddir);
			$pic_url= sprintf("%s/%s/%d/%s", $domain, $ftp_dir2,$artist_id,$file_name_new_db);
			$db_id = $artist_id;

			//転送先
			$remote_file = sprintf("%s/%s", $articleiddir, $file_name_new_db);
			
			// ファイルをアップロードする
			if(!ftp_put($conn_id, $remote_file, $file_name_local, FTP_ASCII)) {
				$errors="-3";
				$clm = array('url' => NULL, 'error' => -3);
				array_push($arr,$clm);
			}
			//ローカルファイルを削除
			unlink($file_name_local);					
			
			if($db_pic=='main_pic'){
				$pic_url_small= sprintf("%s/%s/%d/%s", $domain, $ftp_dir2,$artist_id,$file_name_new_db_small);
				$remote_file_small = sprintf("%s/%s", $articleiddir, $file_name_new_db_small);
				if(!ftp_put($conn_id, $remote_file_small, $file_name_local_small, FTP_ASCII)) {
					$errors="-3";
					$clm = array('url' => NULL, 'error' => -3);
					array_push($arr,$clm);
				}
				unlink($file_name_local_small);					
			}

			if($errors=="")
			{
				$db = dbconnect();

				$sql = sprintf('SELECT * FROM TT_WORKS WHERE works_id=%d', $works_id);
				$record=$db->query($sql);
				$data=$record->fetch(PDO::FETCH_ASSOC);
				
				if($db_pic=='main_pic'){
					if(!empty($data['main_pic']))
					{
						$picpath = parse_url($data['main_pic'], PHP_URL_PATH);
						ftp_delete($conn_id, 'art'.$picpath);
					}					
					if(!empty($data['main_pic_small']))
					{
						$picpath = parse_url($data['main_pic_small'], PHP_URL_PATH);
						ftp_delete($conn_id, 'art'.$picpath);
					}					
					$sql = sprintf('UPDATE TT_WORKS SET main_pic="%s", main_pic_small="%s" WHERE works_id=%d',
								$pic_url,
								$pic_url_small,
								$works_id
								);	
					$record=NULL;
					my_execute($db,$sql,$record);
				}
				
				if($db_pic=='base_pic'){
					if(!empty($data['base_pic']))
					{
						$picpath = parse_url($data['base_pic'], PHP_URL_PATH);
						ftp_delete($conn_id, 'art'.$picpath);
					}					
					$sql = sprintf('UPDATE TT_WORKS SET base_pic="%s" WHERE works_id=%d',
								$pic_url,
								$works_id
								);	
					$record=NULL;
					my_execute($db,$sql,$record);
				}
				
				//$arr=$pic_url;
				$clm = array('url' => $pic_url, 'error' => 0);
				array_push($arr,$clm);
				
				$db=NULL;
			}
			
			// 接続を閉じる
			ftp_close($conn_id);
			
		}
	
	}else{
		$errors="-4";
		$clm = array('url' => NULL, 'error' => -4);
		array_push($arr,$clm);
	}
	
	
	header("Content-Type: application/json; charset=utf-8");		
	
	echo json_encode($arr);
	
/*	
	if($errors!=""){
		echo json_encode($errors);
	}else{
		echo json_encode($arr);
	}
*/

}

#// -----------------------------------------------------
#// 拡張子からアップロードを許すか調べる
#// -----------------------------------------------------
function FileExtensionGetAllowUpload($ext){

	# アップロードを許可したい拡張子があればここに追加
	$allow_ext = array("bmp","gif","jpg","jpeg","png","BMP","JPG");

	foreach($allow_ext as $v){
		if ($v === $ext){
			return 1;
		}
	}

	return 0;
}

?>