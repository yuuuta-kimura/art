<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  style="width:100%; margin:0; padding:0;">
<head>
<meta charset="<?php bloginfo( 'charset' );//文字コードを出力するタグ ?>" />
<meta name="viewport" content="width=device-width ">
<title>中村綾花</title>


<link rel="pingback" href="<?php bloginfo( 'pingback_url' );//pingback URLを取得 ?>" />
<?php wp_head();//プラグインの実行に必要なタグ ?>


<link rel="icon" href="favicon.ico">

<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">

<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' );//スタイルシートのURLの取得 ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_directory' );?>/bootstrap.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_directory' );?>/style_org.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_directory' );?>/lity.min.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_directory' );?>/swiper.min.css" />


<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' );?>/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' );?>/js/lity.min.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'stylesheet_directory' );?>/js/swiper.min.js"></script>


<body style="width:100%; margin:0; padding:0;">

<div id="header"><!-- ここからヘッダー(タイトルロゴなど)　-->

<img src="<?php bloginfo( 'template_directory' );?>/img/logo_eart.png" class="header_img">

<HR class="header_img">

<nav class="navbar navbar-default" style="margin:0; padding:0; border:0; border-radius:0;">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
   </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="defaultNavbar1" style="width:70%; margin:0 auto;">
      <ul class="nav navbar-nav">
        <li><a href="http://e-art.tokyo/nakamura_ayaka/">TOP</a></li>
        <li><a href="<?php bloginfo( 'template_directory' );?>/eventnewslist">Event & News</a></li>
        <li><a href="<?php bloginfo( 'template_directory' );?>/bloglist">Blog</a></li>
        <li><a href="http://e-art.tokyo/user/gallery.php?artist_id=1" target="_blank">Gallery e-ART</a></li>
        <li><a href="<?php bloginfo( 'template_directory' );?>/profile-jp">Profile</a>
        </li>
      </ul>
              
      
	  <!--            
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="記事を検索" style="font-size:12px;">
        </div>
        <button type="submit" class="btn btn-default" style="border:none; padding:0px; background-color:#BABABA;">
		<span class="glyphicon glyphicon-search" style="color:#FFFFFF;"></span>
        </button>
      </form>
      -->
      
    </div>
    <!-- /.navbar-collapse --> 
  </div>
  <!-- /.container-fluid --> 
</nav>

</div>