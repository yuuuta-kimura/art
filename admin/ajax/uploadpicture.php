<?php

ini_set("display_errors",1);
error_reporting(E_ALL);

require('../dbconnect.php');
require('../pdosql.php');

session_start();

//$ini = parse_ini_file('../config.ini');

$errors="";
$file_name_local = "";
$file_name_new_db="";
$arr = array();

$artist_id=1;

switch ($_POST['upload_btn'])
{
	case 'workpic': $input_file = $_FILES['workpic']; 
		$file_ext = pathinfo($input_file["name"], PATHINFO_EXTENSION);
		$file_name_local = "../pic/".$_POST['upload_btn'] . "." . $file_ext;
		$file_name_new_db = $_POST['upload_btn'] . "." . $file_ext;
		break;	

	default: break;
}


if(empty($input_file))
{

	$errors="-1";	
	$clm = array('url' => NULL, 'pic_id' => NULL, 'file' => NULL, 'error' => -1);
	array_push($arr,$clm);
}
else
{		
	//アップロード可能な拡張子であるか調べる
	if(FileExtensionGetAllowUpload($file_ext))
	{

		//ファイルの移動を行う
		if (!move_uploaded_file($input_file["tmp_name"], $file_name_local))
		{
			$errors="-2";
			$clm = array('url' => NULL, 'pic_id' => NULL, 'file' => NULL, 'error' => -2);
			array_push($arr,$clm);
		}else
		{
			$upload_pic = "";

			// ファイルのパーミッションを確実に0644に設定する
			chmod($file_name_local, 0644);

			//本番サーバーに転送
			/*
			$ftp_server = openssl_decrypt(hex2bin($ini['FTP_SERVER']), 'AES-128-ECB', 'temcy900c0ccie9itjcy18g0xxjzjgvj4ids167jak5md5dkwgpcfihv8arkfk23gs1u0d70ih1uudq6s5r5w4vfrvsepuy47y4d9rknv7og3wp0feu12pxp5rkahg0krphkn0kjwgs84apka4oiy0ihdtumlwrmg055dxwbe4xy48aqlcomp4jf0gai7eu0awrboq56emny9jn6j57wnsx4p1dj9p9xh6uklzk7svx284rgcis6rtixmsrqaazu',OPENSSL_RAW_DATA);
			$ftp_user_name = openssl_decrypt(hex2bin($ini['FTP_USER_NAME']), 'AES-128-ECB', 'temcy900c0ccie9itjcy18g0xxjzjgvj4ids167jak5md5dkwgpcfihv8arkfk23gs1u0d70ih1uudq6s5r5w4vfrvsepuy47y4d9rknv7og3wp0feu12pxp5rkahg0krphkn0kjwgs84apka4oiy0ihdtumlwrmg055dxwbe4xy48aqlcomp4jf0gai7eu0awrboq56emny9jn6j57wnsx4p1dj9p9xh6uklzk7svx284rgcis6rtixmsrqaazu',OPENSSL_RAW_DATA);
			$ftp_user_pass = openssl_decrypt(hex2bin($ini['FTP_USER_PASS']), 'AES-128-ECB', 'temcy900c0ccie9itjcy18g0xxjzjgvj4ids167jak5md5dkwgpcfihv8arkfk23gs1u0d70ih1uudq6s5r5w4vfrvsepuy47y4d9rknv7og3wp0feu12pxp5rkahg0krphkn0kjwgs84apka4oiy0ihdtumlwrmg055dxwbe4xy48aqlcomp4jf0gai7eu0awrboq56emny9jn6j57wnsx4p1dj9p9xh6uklzk7svx284rgcis6rtixmsrqaazu',OPENSSL_RAW_DATA);
			*/
			$ftp_server="ftp.7135244fd63eb4a7.lolipop.jp";
			$ftp_user_name="lolipop.jp-7135244fd63eb4a7";
			$ftp_user_pass="yuta6151";

			//$domain =$ini['DOMAIN1'];
			//$domain =$ini['DOMAIN1'];
			$domain ="http://e-art.tokyo";
			
			// 接続を確立する
			$conn_id = ftp_connect($ftp_server);
			
			// ユーザー名とパスワードでログインする
			$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

			//ディレクトリ作成

			//$ftp_dir1 =$ini['FTP_DIR1'];
			$ftp_dir1 ="art/works_pictures";
			$ftp_dir2 ="works_pictures";

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
				$errors="-5";
				$clm = array('url' => NULL, 'pic_id' => NULL, 'file' => NULL, 'error' => -3);
				array_push($arr,$clm);
			}else{
				$clm = array('url' => $pic_url, 'pic_id' => NULL, 'file' => NULL, 'error' => 0);
				array_push($arr,$clm);				
			}

			// 接続を閉じる
			ftp_close($conn_id);

			/*
			if($errors=="")
			{
				//データーベース更新
				$db = dbconnect();


				$sql = sprintf('UPDATE TM_PROJECT SET %s="%s" WHERE prj_id=%d',
							$upload_pic,
							$pic_url,
							$db_id
							);

				$record=NULL;
				my_execute($db,$sql,$record);
				//$arr=$pic_url;
				$clm = array('url' => $pic_url, 'pic_id' => NULL, 'file' => NULL, 'error' => 0);
				array_push($arr,$clm);

				unlink($file_name_local);

				$db=NULL;
			}
			*/
		}
	
	}else{
		$errors="-4";
		$clm = array('url' => NULL, 'pic_id' => NULL, 'file' => NULL, 'error' => -4);
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