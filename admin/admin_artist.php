<?php

$ini = parse_ini_file('config.ini');
if($ini['DEBUG_MODE']==1){
ini_set("display_errors",1);
error_reporting(E_ALL);
}

require('dbconnect.php');
require('pdosql.php');
require('mymail.php');
require('func_login_admin.php');

session_start();

//header('Location: regist_user.php');


require_once("MySmarty.class.php");
$o_smarty=new MySmarty();
$errors = array();
$params=array();

// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style.css');
$o_smarty->assign( 'header_tpl', 'header_none.tpl' );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );




//ログインチェック
$login_flg=0;
if(!empty($_SESSION['admin_pass']))
{
	if(admin_login_session($_SESSION['admin_pass']))
	{
		$login_flg=1;
	}
}

if($login_flg)
{
		
	if(!empty($_POST['artist_id']))
	{
		$_SESSION['artist_id']=$_POST['artist_id'];

		if(!empty($_GET['page']))
		{
			$_SESSION['page']=$_POST['page'];
		}
		header('Location:admin_artist_detail.php');
		exit();
	}

	if(empty($_GET['page']))
	{
		$v_page=1;
	}else{
		$v_page=htmlspecialchars($_GET['page'], ENT_QUOTES);
	}

	$i_page =intval($v_page);
	$_v_startpage = strval(($i_page*10)-10);

	$db = dbconnect();
	$sql=sprintf('SELECT * FROM TM_ARTIST ORDER BY regist_time DESC LIMIT %d, 11',$_v_startpage);
	$record=$db->query($sql);
	$count=1;

	$html='<table class="noline_table">';
	$html.='<tr><th width=50>審査</th><th width=150>名前</th><th width=150>登録日</th></tr>';
	while($data=$record->fetch(PDO::FETCH_ASSOC))
	{
		if($count<11)
		{
			$html.='<tr>';
			$html.='<form action="" method="post">';
			switch ($data['check_flg'])
			{
				case 0:
					$html.='<td>NG</td>';
					break;
				case 1:
					$html.='<td>OK</td>';
					break;
				default:
					$html.='<td>未</td>';
					break;
			}

			$html.='<input type=hidden name="artist_id" value="' . $data["artist_id"] . '">';		
			$html.='<td>';
			$html.='<button type="submit" id="check_artist" name="check_artist" class="check_artist">'.$data['kanji_sei']." ".$data['kanji_mei'].'</>';
			$html.='</td>';
			if($data['regist_time']==0){
				$html.= '<td></td>';
			}else{
				$regist_date = new DateTime($data['regist_time']);
				$html.= '<td>'.$regist_date->format('Y年m月d日').'</td>';
			}		
			$html.= '</form>';
			$html.='</tr>';
		}
		else
		{

		}
		$count=$count+1;
	}
	$html.='</table>';
	$params['html']=$html;

	//ページング
	$paging=NULL;
	if($count>=11){
		if($i_page<2){
			$paging=sprintf('<a href="mypage_ath_blog_list.php?page=%d>',$i_page+1).'<span class="glyphicon glyphicon-chevron-right"></a>';
		}
		else{
			$paging=sprintf('<a href="mypage_ath_blog_list.php?page=%d>',$i_page-1).'<span class="glyphicon glyphicon-chevron-left"></a>'.sprintf('<a href="mypage_ath_blog_list.php?page=%d>',$i_page+1).'<span class="glyphicon glyphicon-chevron-right"></a></div>';
		}
	}
	else{
		if($i_page>1){
			$paging=sprintf('<a href="mypage_ath_blog_list.php?page=%d>',$i_page-1).'<span class="glyphicon glyphicon-chevron-left"></a></div>';
		}
	}
	$params['paging']=$paging;
	$o_smarty->assign( 'params', $params );
}
else
{
	$o_smarty->assign( 'params', NULL );	
}

$o_smarty->assign( 'body_tpl', 'body_admin_artist.tpl' );

$o_smarty->display( 'template.tpl' );


?>