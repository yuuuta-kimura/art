<?php

//////////////////////////////////////
// artist/editworks.php
//////////////////////////////////////


ini_set("display_errors",1);
error_reporting(E_ALL);

require('dbconnect.php');
require('pdosql.php');
require('func_login_artist.php');

$ini = parse_ini_file('config.ini');

session_start();

require_once("MySmarty.class.php");
$o_smarty=new MySmarty();
$params=array();
$message=NULL;
$error=0;

// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style_editworks.css');
$o_smarty->assign( 'head_tpl', 'head_editworks.tpl' );
$o_smarty->assign( 'header_tpl', 'header_menu.tpl' );

if(!empty($_SESSION['artist_id'])&&!empty($_SESSION['artist_pass']))
{
	$artist_id=$params['artist_id']=$_SESSION['artist_id'];
	$works_id=$_SESSION['works_id'];

	if(!empty($_POST['delete_btn']))
	{
				
		$db = dbconnect();

		//ファイルを削除
		$key='j3kihic1ryku5pgeqc09o8xsaf27vegssuahc87zguox0d2kb4ug4tr6tji9r8bs8zf205s1rlywk0k1t1e5tt2b6rjtgo6fhe1o3wv1inv0dgl6h9tch1kr7km6yfpmsmblty21s3owamjhijj6oux2sywlnuiov8pl4rusvqcy28niigu4qze570lcki3efgisr2c8jfv4utt9nua98zemr9ycna5t77nd5yoh822r2hj8iskpskl3r0mcpsj550x1jea2oj328y4dj700dbgrsdie6ke8jrpuztfgoood65xi9oj7dx0puttsuqlk755i7sny516v3dwemuqnn6qgerydk4clzdmlq475c31ge6mfqwb7jz9o4gax586ywth2pfgbrq6i2y7foml6yenzre6g3k6m1jaxy78e1rz4p40jkb9z4lxqog48csoxwkq3n9l2xna42igv563zfzi9vom2sftspz12k562u35rnvy3k3moqhgce50f69tdzi4v4upkxtfkig0l5xdjaftm8wiodcuspwev6sa7sjggb5gpbm93rvj66espsqc109kh7l7cz6cyqvibt0k4dh2thqpc9cfqw08m2vucuz7is6t54n77ksmbxa6l447gx4j5bkxr3pfd43qbxvie0pbkvciwliefbrs19nivrnxxa3f1dltaxjsrh4lcogjh117yu6bbft2trax6ahcydveoilqharl2wv08uifyuizptf0tkkix0cn90j6zuc95x3pnq88oplk7j77u4l8hekutlljhik5v81vp494jjp67mu5nz336xce5xrd1ggxo3z4fxpo99czvsyn4b6wqlxaku0w64mpmcvm2jv5c4b9pzwnetiybpxqafed446eu3s72xyog7osk4h11r6ryrkbeotvxz10t2p4c88vrli8s8pk60tkc86c9qp8p4r12wnpiwi51n7yvu8cnclas6zqao5ygggi5iz33ho5x3ssyaf0m669f3f42nrayl0k8';

		$ftp_server = openssl_decrypt(hex2bin($ini['FTP_SERVER']), 'AES-128-ECB', $key,OPENSSL_RAW_DATA);
		$ftp_user_name = openssl_decrypt(hex2bin($ini['FTP_USER_NAME']), 'AES-128-ECB', $key,OPENSSL_RAW_DATA);
		$ftp_user_pass = openssl_decrypt(hex2bin($ini['FTP_USER_PASS']), 'AES-128-ECB', $key,OPENSSL_RAW_DATA);

		$domain =$ini['DOMAIN1'];

		// 接続を確立する
		$conn_id = ftp_connect($ftp_server);	
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

		$sql = sprintf('SELECT main_pic, base_pic FROM TT_WORKS WHERE works_id=%d', $works_id);
		$record=$db->query($sql);
		$data=$record->fetch(PDO::FETCH_ASSOC);
		$picpath=NULL;

		if(!empty($data['main_pic']))
		{	
			$picpath = parse_url($data['main_pic'], PHP_URL_PATH);
			ftp_delete($conn_id, 'art'.$picpath);
		}
		/*
		if(!empty($data['base_pic']))
		{		
			$picpath = parse_url($data['base_pic'], PHP_URL_PATH);
			ftp_delete($conn_id, 'art'.$picpath);
		}
		*/
		
		// 接続を閉じる
		ftp_close($conn_id);

		//データを削除
		$sql = sprintf('DELETE FROM TT_WORKS WHERE works_id=%d',
					$works_id
					);

		$record=NULL;
		my_execute($db,$sql,$record);


		$db=NULL;	

		header('Location:workslist.php');
	}

	if(!empty($_POST['return_btn'])){
		if(!empty($_SESSION['RET_URL_WORKSLIST'])){
			header('Location:'.$_SESSION['RET_URL_WORKSLIST']);
			$_SESSION['RET_URL_WORKSLIST']=NULL;
			exit;
		}
	}

	$db = dbconnect();

	if(!empty($_POST['update_btn']))
	{
		$ar_sql=array();

		//array_push($ar_sql, sprintf('title="%s"',$_POST['text_title']));
		//array_push($ar_sql, sprintf('comment="%s"',$_POST['text_comment']));
		//array_push($ar_sql, sprintf('open_flg=%d',$_POST['open_flg']));	
		array_push($ar_sql, 'title=?,comment=?,open_flg=?');
		
		//if(!empty($_POST['top_open_flg'])){
		//	if($_POST['top_open_flg']=='ok'){
		//		
		//		if($_POST['open_flg']==1){
		//			array_push($ar_sql, 'top_open_flg=1');
		//		}else{
		//			$message='公開になっていないのでトップに表示できません';
		//			$error=1;
		//		}
		//		
		//	}else{
		//		array_push($ar_sql, 'top_open_flg=0');					
		//	}
		//}else{
		//	array_push($ar_sql, 'top_open_flg=0');			
		//}

		$sql=sprintf("SELECT COUNT(*) AS cnt FROM TT_WORKS WHERE artist_id=%d AND open_flg=1 AND top_open_flg=1 AND works_id != %s", $artist_id, $works_id);
		$record=NULL;$record=$db->query($sql);
		$num_top_open_flg=$record->fetchColumn();
		
		if(!empty($_POST['top_open_flg'])){
			if($_POST['top_open_flg']=='ok'){
				if($_POST['open_flg']==1){
					if($num_top_open_flg<6){
						$top_open_flg=1;
					}else{
						$message='6個以上はトップに公開できません';
						$error=1;						
					}
					
				}else{
					$message='公開になっていないのでトップに表示できません';
					$error=1;
				}
				
			}else{$top_open_flg=0;}
		}else{$top_open_flg=0;}
		array_push($ar_sql, 'top_open_flg=?');			
		
		
		//if(!empty($_POST['text_size_width'])){
		//	array_push($ar_sql, sprintf('size_width=%d',$_POST['text_size_width']));
		//}else{
		//	array_push($ar_sql, 'size_width=0');		
		//}
		
		if(!empty($_POST['text_size_width'])){$text_size_width=$_POST['text_size_width'];
		}else{$text_size_width=0;}
		array_push($ar_sql, 'size_width=?');			
		
		//if(!empty($_POST['text_size_height'])){
		//	array_push($ar_sql, sprintf('size_height=%d',$_POST['text_size_height']));
		//}else{
		//	array_push($ar_sql, 'size_height=0');				
		//}
		
		if(!empty($_POST['text_size_height'])){$text_size_height=$_POST['text_size_height'];
		}else{$text_size_height=0;}
		array_push($ar_sql, 'size_height=?');			

		
		//if(!empty($_POST['slt_tech'])){
		//	array_push($ar_sql, sprintf('tech=%d',$_POST['slt_tech']));
		//}else{
		//	array_push($ar_sql, 'tech=0');						
		//}

		if(!empty($_POST['slt_tech'])){$slt_tech=$_POST['slt_tech'];
		}else{$slt_tech=0;}
		array_push($ar_sql, 'tech=?');			

		//array_push($ar_sql, sprintf('tech_other="%s"',$_POST['text_tech_other']));
		array_push($ar_sql, 'tech_other=?');
		
		
		//if(!empty($_POST['slt_base'])){
		//	array_push($ar_sql, sprintf('base=%d',$_POST['slt_base']));
		//}else{
		//	array_push($ar_sql, 'base=0');								
		//}

		if(!empty($_POST['slt_base'])){
			$slt_base=$_POST['slt_base'];
		}else{
			$slt_base=0;								
		}
		array_push($ar_sql,'base=?');
		
		//array_push($ar_sql, sprintf('base_other="%s"',$_POST['text_base_other']));
		array_push($ar_sql,'base_other=?');
		
		
		/*
		if(!empty($_POST['text_price'])){
			if(intval($_POST['text_price'])==0){
				if(intval($_POST['text_insert_zaiko_num'])>0){
					$message='価格は設定されていないので在庫は作れません';
					$error=1;				
					
				}else{
					array_push($ar_sql, 'price=0');					
				}
			}else{
				if(intval($_POST['text_price'])>=intval($ini['PRICE_MIN'])){
					array_push($ar_sql, sprintf('price=%d',$_POST['text_price']));
				}else{
					$message=number_format($ini['PRICE_MIN']).'円未満の価格は設定できません';
					$error=1;				
				}				
			}
		}else{
			if(intval($_POST['text_insert_zaiko_num'])>0){
				$message='価格は設定されていないので在庫は作れません';
				$error=1;				
			}else{
				array_push($ar_sql, 'price=0');					
			}
		}
		*/
		
		if(!empty($_POST['text_price'])){
			if(intval($_POST['text_price'])==0){
				if(intval($_POST['text_insert_zaiko_num'])>0){
					$message='価格は設定されていないので在庫は作れません';
					$error=1;				
					
				}else{
					$text_price=0;
				}
			}else{
				if(intval($_POST['text_price'])>=intval($ini['PRICE_MIN'])){
					$text_price=$_POST['text_price'];
				}else{
					$message=number_format($ini['PRICE_MIN']).'円未満の価格は設定できません';
					$error=1;				
				}				
			}
		}else{
			if(intval($_POST['text_insert_zaiko_num'])>0){
				$message='価格は設定されていないので在庫は作れません';
				$error=1;				

			}else{
				$text_price=0;
			}
		}
		array_push($ar_sql, 'price=?');
		
		
		$val_sql='';
		for ($i = 0 ; $i < count($ar_sql); $i++) 
		{
			if($i==0){
				$val_sql .= $ar_sql[$i];
			}else{
				$val_sql .= ','.$ar_sql[$i];			
			}
		}

		if($val_sql!='' && $error==0)
		{
			//TT_WORKSにマスター情報をセット
			$sql = sprintf('UPDATE TT_WORKS SET %s WHERE works_id=%d',
						$val_sql,
						$works_id
						);

			$record=NULL;
			
		$stmt = $db->prepare( $sql );
		$stmt->bindParam(1, $_POST['text_title'], PDO::PARAM_STR);	
		$stmt->bindParam(2, $_POST['text_comment'], PDO::PARAM_STR);	
		$stmt->bindParam(3, $_POST['open_flg'], PDO::PARAM_INT);
		$stmt->bindParam(4, $top_open_flg, PDO::PARAM_INT);
		$stmt->bindParam(5, $text_size_width, PDO::PARAM_INT);
		$stmt->bindParam(6, $text_size_height, PDO::PARAM_INT);
		$stmt->bindParam(7, $slt_tech, PDO::PARAM_INT);
		$stmt->bindParam(8, $_POST['text_tech_other'], PDO::PARAM_STR);
		$stmt->bindParam(9, $slt_base, PDO::PARAM_INT);
		$stmt->bindParam(10, $_POST['text_base_other'], PDO::PARAM_STR);
		$stmt->bindParam(11, $text_price, PDO::PARAM_INT);
			
		$stmt->execute();			
			
			//my_execute($db,$sql,$record);			
			
			//TT_WORKS_ZAIKOに在庫数分のレコードを作成
			$insert_zaiko_num = intval($_POST['text_insert_zaiko_num']);
			
			$sql=NULL;
			if($insert_zaiko_num >0 )
			{
				$sql='INSERT INTO TT_WORKS_ZAIKO (works_id,price) VALUES ';
				for ($i = 1; $i <= $insert_zaiko_num; $i++)
				{
					$sql.=sprintf('(%d,%d),', $works_id, $_POST['text_price']);
				}
				$sql = substr_replace($sql, ';', -1, 1);
				$record=NULL;
				my_execute($db,$sql,$record);					
			}
			
			if(!empty($_SESSION['RET_URL_WORKSLIST'])){
				header('Location:'.$_SESSION['RET_URL_WORKSLIST']);
				$_SESSION['RET_URL_WORKSLIST']=NULL;
				exit;
			}
		}
	}

	$sql=NULL;$sql=sprintf("SELECT * FROM TT_WORKS WHERE works_id=%d", $works_id);
	$record=NULL;$record=$db->query($sql);
	$data=$record->fetch(PDO::FETCH_ASSOC);
	
	if(empty($_POST)){
		

		$params['works_id']=$data['works_id'];
		$params['text_works_id']=sprintf('A%08d',$data['works_id']);
		$params['open_flg']=$data['open_flg'];
		$params['top_open_flg']=$data['top_open_flg'];

		$params['main_pic']=$data['main_pic'];
		$params['text_title']=$data['title'];
		$params['text_comment']=$data['comment'];
		$params['text_size_width']=$data['size_width'];
		$params['text_size_height']=$data['size_height'];
		$params['slt_tech']=$data['tech'];

		$params['text_tech_other']=$data['tech_other'];
		$params['slt_base']=$data['base'];
		//$params['base_pic']=$data['base_pic'];
		$params['text_base_other']=$data['base_other'];

		$sql=NULL;$sql=sprintf("SELECT COUNT(*) AS cnt FROM TT_WORKS_ZAIKO WHERE works_id=%d AND order_id IS NULL", $works_id);
		$record=NULL;$record=$db->query($sql);
		$params['text_zaiko_num']=$record->fetchColumn();

		$params['text_price']=$data['price'];
		$params['text_insert_zaiko_num']=NULL;
		
	}else{
		
		$params['works_id']=$_POST['works_id'];
		$params['text_works_id']=sprintf('A%08d',$_POST['works_id']);
		$params['open_flg']=$_POST['open_flg'];
		
		if(empty($_POST['top_open_flg'])){$params['top_open_flg']=0;}
		else{$params['top_open_flg']=1;}
	
		$params['main_pic']=$data['main_pic'];
		$params['text_title']=$_POST['text_title'];
		$params['text_comment']=$_POST['text_comment'];
		$params['text_size_width']=$_POST['text_size_width'];
		$params['text_size_height']=$_POST['text_size_height'];
		$params['slt_tech']=$_POST['slt_tech'];

		$params['text_tech_other']=$_POST['text_tech_other'];
		$params['slt_base']=$_POST['slt_base'];
		//$params['base_pic']=$data['base_pic'];
		$params['text_base_other']=$_POST['text_base_other'];

		$sql=NULL;$sql=sprintf("SELECT COUNT(*) AS cnt FROM TT_WORKS_ZAIKO WHERE works_id=%d AND order_id IS NULL", $works_id);
		$record=NULL;$record=$db->query($sql);
		$params['text_zaiko_num']=$record->fetchColumn();

		if($params['text_zaiko_num']>0){$params['text_price']=number_format($data['price']);}
		else{$params['text_price']=$_POST['text_price'];}
		
		$params['text_insert_zaiko_num']=$_POST['text_insert_zaiko_num'];
	
	}
	
	$sql=NULL;
	$sql=sprintf("SELECT COUNT(*) AS cnt FROM TT_WORKS WHERE artist_id=%d AND open_flg=1 AND top_open_flg=1", $artist_id);
	$record=NULL;$record=$db->query($sql);
	$params['num_top_open_flg']=$record->fetchColumn();
	$params['price_min']=number_format($ini['PRICE_MIN']);
	$params['message']=$message;
	
	$record=NULL;$db=NULL;

	$o_smarty->assign( 'body_tpl', 'body_editworks.tpl' );
	$o_smarty->assign( 'params', $params );
	$o_smarty->assign( 'footer_tpl', 'footer.tpl' );
	$o_smarty->display( 'template.tpl' );

	
	
}else{
	$o_smarty->assign( 'header_tpl', 'header_none.tpl' );
	$o_smarty->assign( 'body_tpl', 'body_session_out.tpl' );
	$o_smarty->assign( 'params', NULL );
	$o_smarty->assign( 'footer_tpl', 'footer.tpl' );
	$o_smarty->display( 'template.tpl' );	
}

?>