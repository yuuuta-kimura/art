<form action="" method="post" name="frm_login_artist">
   
{if $params.send=='done'}

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; margin-top:50px;">
	<font size="+1">{$params.message nofilter}</font>
</div>

<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; margin-top:30px;">
	<a href="artist_login.php">&laquo;&nbsp;ログインに戻る</a>
</div>

{else}

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
	<h3>パスワード再発行</h3>
	<p>ご登録のメールアドレスを入力してください。</p>
	<p>新しいパスワードをメールで送信いたします。</p>
</div>


<!--メールアドレス-->
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
	<div style="margin:0 auto; width: 300px;">
	<input name="text_mailaddress" id="text_mailaddress" size="40" maxlength="255" placeholder=""  type="text">
	</div>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; margin-top:20px;">
	<font size="+1" color="red">{$params.message nofilter}</font>
</div>

<!--ボタン-->

<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; margin-top:30px;">
	<input type="submit" name="sendpass" value="パスワード再発行" class="bigbutton"/>
</div>

<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; margin-top:30px;">
	<a href="artist_login.php">&laquo;&nbsp;ログインに戻る</a>
</div>

{/if}

</form>
