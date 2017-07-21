<img src="./images/logo_eart.png" class="header_img">
<HR class="header_img">

{if $login_flg=="yes"}
<div id="header_login_sts">ログイン中</div>
{/if}

<div id="header"></div>
<nav class="navbar navbar-default" style="margin:0; padding:0; border:0; border-radius:0;">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
   </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="defaultNavbar1" style="width:100%; text-align:center;">
      <ul class="nav navbar-nav">
       
        {if $login_flg=="yes"}
        <li><a href="gallery.php?artist_id={$artist_id}"><span class="glyphicon glyphicon-picture"></span> ギャラリー</a></li>
        <li><a href="order_list.php?artist_id={$artist_id}"><span class="glyphicon glyphicon-gift"></span> 注文履歴</a></li>
        <li><a href="user_changeprofile.php?artist_id={$artist_id}"><span class="glyphicon glyphicon-envelope"></span> メールアドレス変更</a></li>
        <li><a href="user_changepassword.php?artist_id={$artist_id}"><span class="glyphicon glyphicon-lock"></span> パスワード変更</a></li>
		<li><a href="order_cart.php?artist_id={$artist_id}"><span class="glyphicon glyphicon-shopping-cart">カート</span></a></li>
        <li><a href="user_logout.php?artist_id={$artist_id}"><span class="glyphicon glyphicon-off"></span> ログアウト</a></li>
        {else}
        <li><a href="user_login.php">ログイン・注文履歴</a></li>
        {/if}
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

