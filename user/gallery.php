<?php

//////////////////////////////////////
// user/gallery.php
//////////////////////////////////////


$ini = parse_ini_file('config.ini');
if($ini['DEBUG_MODE']==1){
ini_set("display_errors",1);
error_reporting(E_ALL);
}

require('dbconnect.php');
require('pdosql.php');
require('func_login_user.php');

session_start();

require_once("MySmarty.class.php");
$o_smarty=new MySmarty();
$params=array();

// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style_gallery.css');
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
$o_smarty->assign( 'header_tpl', 'header_none.tpl' );

if(empty($_GET['artist_id'])){
	//ゆくゆくは、アーティストが増えたら、まとめのインデックスページを作って飛ばす
	$artist_id=0;
}else{
	$artist_id=htmlspecialchars($_GET['artist_id'], ENT_QUOTES);
}

$time_stamp=date('Y-m-d H:i:s', strtotime(sprintf('-%d minute',$ini['ORDER_WAIT_MINUTE'])));


if(empty($_GET['page']))
{
	$v_page=1;
}else{
	$v_page=htmlspecialchars($_GET['page'], ENT_QUOTES);
}

$page_group=10;

$i_page =intval($v_page);
$_v_startpage = strval(($i_page*$page_group)-$page_group);


if(!empty($_POST['detail_btn'])){			
	header(sprintf('Location:artist_work.php?artist_id=%d&works_id=%d&page=%d',$artist_id, $_POST['works_id'], $i_page));
	exit();
}

$return_url= empty($_SERVER["HTTPS"]) ? "http://" : "https://";
$return_url.=$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$_SESSION['RET_URL_USER']=$return_url;
$_SESSION['URL_GALLERY']=$return_url;


//ログインチェック
$ret=0;$login_flg ='no';
if(!empty($_SESSION['user_id']) && !empty($_SESSION['user_pass'])){
	$db = dbconnect();
	$ret =user_login_check($_SESSION['user_id'], $_SESSION['user_pass'], $db);
	$db = NULL;
	
	if($ret){
		$login_flg ='yes';
	}
}


$db = dbconnect();

if($artist_id){
	
	$sql=sprintf('SELECT * FROM TM_ARTIST WHERE artist_id=%d',$artist_id);
	$record=$db->query($sql);
	$data=$record->fetch(PDO::FETCH_ASSOC);

	$artist_name=$data['kanji_sei'].' '.$data['kanji_mei'];

	$metaproperty='
	<meta property="og:site_name" content="e-ART" />
	<meta property="og:title" content="'.$artist_name.'" />
	<meta property="og:type" content="website" >
	<meta property="og:description" content="手描きをメインに、繊細かつ力強い画面づくりを目指し、
	アーティストのミュージックビデオやアートワーク、テレビ番組のアニメーション、装丁のイラストなどを手がける。" />
	<meta property="og:url" content="http://e-art.tokyo/user/gallery.php?artist_id='.$artist_id.'" />
	<meta property="og:image" content="http://e-art.tokyo/nakamura_ayaka/wp-content/uploads/2016/12/161125-Ayaka.jpg" />
	<meta property="fb:app_id" content="637949606391326" />
	';
	
}else{

	$metaproperty='
	<meta property="og:site_name" content="e-ART" />
	<meta property="og:title" content="アートと人をつなぐe-ART" />
	<meta property="og:type" content="website" >
	<meta property="og:description" content="アーティストのイベントや活動、新着作品をお知らせ" />
	<meta property="og:url" content="http://e-art.tokyo/user/gallery.php" />
	<meta property="og:image" content="http://e-art.tokyo/user/images/logo_eart.png" />
	<meta property="fb:app_id" content="637949606391326" />
	';
	
	$artist_name='';
}


$o_smarty->assign( 'artist_name', $artist_name );
$o_smarty->assign( 'metaproperty', $metaproperty );

//件数
if($artist_id){
	$sql = sprintf('SELECT COUNT(*) AS cnt FROM TT_WORKS WHERE artist_id=%d AND open_flg=1',
				$artist_id
				);	
}else{
	$sql = 'SELECT COUNT(*) AS cnt FROM TT_WORKS WHERE open_flg=1';
}


$res = $db->query($sql);
$CNT = $res->fetchColumn();

//表示
$html='';
if($artist_id){
	$sql=sprintf("SELECT * FROM TT_WORKS WHERE artist_id=%d AND open_flg=1 ORDER BY regist_time DESC LIMIT %d, %d",$artist_id,$_v_startpage,$page_group+1);
}else{
	$sql=sprintf("SELECT * FROM TT_WORKS WHERE open_flg=1 ORDER BY regist_time DESC LIMIT %d, %d",$_v_startpage,$page_group+1);	
}

$record=$db->query($sql);

$count=1;
$over=0;


$today = new DateTime();

while($data=$record->fetch(PDO::FETCH_ASSOC))
{
	if($count<=$page_group)
	{
		//$html.='<div class="row" style="margin:0 0 100px 0;">';
		
		$html.='<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 gallery_block" style="margin-bottom:100px">';
		$html.='<form action="" method="post" name="">';
		$html.='<input type="hidden" name="artist_id" id="artist_id" value="'.$artist_id.'"/>';
		$html.='<input type="hidden" name="works_id" id="works_id" value="'.$data['works_id'].'"/>';

		
			$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
			if(!empty($data['main_pic'])){
				$new_flg=0;
				if(!empty($data['open_date'])){
					
					if($data['open_date']!='0000-00-00'){
						$openday = new Datetime($data['open_date']);
						$interval = $openday->diff($today);
						if( ($interval->y == 0 ) && ($interval->m == 0) )
						{
							$new_flg=1;
						}
					}
				}
				
				
				if($new_flg){
					$new_img="new.png";
				}else{
					$new_img="new_dummy.png";					
				}
				
				$html.=sprintf('<img src="images/%s" class="gallery_img_cover"><a href="%s" data-lity><div id="gallery_img"><img src="%s" class="gallery_img"></div></a>',$new_img ,$data['main_pic'],$data['main_pic']);
				
				//$html.=sprintf('<a href="%s"><img src="%s" alt="image"></a>',$data['main_pic'],$data['main_pic']);

				
			}else{
				$html.='<div id="nopicture">no image</div>';
			}
			$html.='</div>';


			$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">';
				$html.='作品ID '. sprintf('A%08d',$data['works_id']);
			$html.='</div>';

			$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">';
				$html.=$data['title'];
			$html.='</div>';


				$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">';
					$html.='<div style="float:left;">';
					$html.='<span class="glyphicon glyphicon-resize-horizontal"></span> ';
					$html.='幅 '.$data['size_width'].'cm';
					$html.='</div>';

					$html.='<div style="float:left; margin-left:5px;">';
					$html.='<span class="glyphicon glyphicon-resize-vertical"></span> ';
					$html.='高さ '.$data['size_height'].'cm';
					$html.='</div>';
				$html.='</div>';

				$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">';
					$html.='<span class="glyphicon glyphicon-pencil"></span> ';
					//$html.='技法 ';			
					switch ($data['tech'])
					{
					case 1: 
						$html.='油画'; break;
					case 2:
						$html.='水彩画'; break;
					case 3:
						$html.='アクリル画'; break;
					case 4:
						$html.='鉛筆画'; break;
					case 5:
						$html.='クレヨン画'; break;
					case 6:
						$html.='水墨画'; break;
					case 7:
						$html.='書道'; break;
					case 8:
						$html.='木版画'; break;
					case 9:
						$html.='リトグラフ'; break;
					case 10:
						$html.='銅板画'; break;
					case 11:
						$html.='シルクスクリーン'; break;
					case 12:
						$html.='デジタルアート'; break;				
					}

					$html.=$data['tech_other'];
				$html.='</div>';

				$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">';
					$html.='<span class="glyphicon glyphicon-file"></span> ';
					//$html.='支持体 ';			
					switch ($data['base'])
					{
						case 1:
							$html.='布'; break;
						case 2:
							$html.='紙'; break;
						case 3:
							$html.='木'; break;
					}
					$html.=$data['base_other'];
				$html.='</div>';


				//$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">';
				//	$html.=$data['comment'];
				//$html.='</div>';

			$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">';
			if($data['price']>0){
				$html.='¥ '.number_format($data['price']).PHP_EOL;
			}else{
				$html.='not for sale'.PHP_EOL;					
			}
			$html.='</div>';
		
			//在庫を調べる
			$sql2=sprintf('SELECT COUNT(*) AS cnt FROM TT_WORKS_ZAIKO WHERE works_id=%d AND cart_make_time < "%s" AND order_id IS NULL', $data['works_id'], $time_stamp);
			$record2=NULL;
			$record2=$db->query($sql2);
			$zaiko_num=$record2->fetchColumn();
		
				if($data['price']>0){
					if($zaiko_num>0)
					{
						$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">';
							$html.='<input type="submit" class="gallery_btn" name="detail_btn" id="detail_btn" value="購入へ"/>';			
					}else{
						$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">';
							$html.='<input type="submit" class="gallery_btn" name="detail_btn" id="detail_btn" value="SOLD OUT"/>';						
					}
				}else{
					$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">';
						$html.='<input type="submit" class="gallery_btn" name="detail_btn" id="detail_btn" value="作品情報"/>';							
				}
		
		
			$html.='</div>';	
		
		$html.='</form>';	
		$html.='</div>';
		
		//$html.='</div>';
		
		$count=$count+1;
		
	}else{
		//$over=$over+1;
		$over=1;
		break;
	}
}


$record=NULL;

$params['html']=$html;



//ページング
$paging=NULL;
if($count>$page_group){

	if($page_group!=$CNT){
		if($i_page<2){
			$paging=sprintf('<a href="gallery.php?artist_id=%d&page=%d">',$artist_id, $i_page+1).'<span class="glyphicon glyphicon-chevron-right"></a>';
		}
		else{

			if($over){
				$paging=sprintf('<a href="gallery.php?artist_id=%d&page=%d">',$artist_id, $i_page-1).'<span class="glyphicon glyphicon-chevron-left"></a>'.sprintf('<a href="gallery.php?artist_id=%d&page=%d">',$artist_id, $i_page+1).'<span class="glyphicon glyphicon-chevron-right"></a>';
			}else{
				$paging=sprintf('<a href="gallery.php?artist_id=%d&page=%d">',$artist_id, $i_page-1).'<span class="glyphicon glyphicon-chevron-left"></a>';			
			}
		}		
	}
}
else{
	if($i_page>1){	
		$paging=sprintf('<a href="gallery.php?artist_id=%d&page=%d">',$artist_id, $i_page-1).'<span class="glyphicon glyphicon-chevron-left"></a>';
	}
}

$db=NULL;		


$params['paging']=$paging;
$o_smarty->assign( 'body_tpl', 'body_gallery.tpl' );
$o_smarty->assign( 'params', $params );
$o_smarty->assign( 'login_flg', $login_flg );
$o_smarty->assign( 'artist_id', $artist_id );
$o_smarty->assign( 'URL_GALLERY', NULL );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );
$o_smarty->display( 'template.tpl' );


?>