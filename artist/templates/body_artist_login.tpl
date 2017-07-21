<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
	<h1><font size="+2"><b>アーティストログイン</b></font></h1>
</div>


<form action="" method="post" name="frm_login_user"  onSubmit="return check()">

<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
	<p>※インターネットエクスプローラー9（IE9）以前のバージョンでは表示できません</p>
	<p>※Google Chromeを推奨</p>
</div>
   
{if $params.login =='error' }
<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
	<div  class="input_error">ログインできませんでした。</div>
    <input type="button" value="ログインしなおす" onClick="location.href='artist_login.php'" class="bigbutton">
</div>
{else}

<!--メールアドレス-->
<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center; margin-top:30px;">
	<label for="text_mailaddress"><font size="+1">メールアドレス</font></label>

	<div id="error_text_mail" class="input_error"></div>

	<div style="margin:0 auto; width: 300px;">
	<input name="text_mailaddress" id="text_mailaddress" size="40" maxlength="255" placeholder=""  type="text" value="{$params.text_mailaddress|escape:'html':'UTF-8'}">
	</div>
</div>

<!--パスワード-->
<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; margin-top:10px;">
	<label for="text_mailaddress"><font size="+1">パスワード</font></label>

	<div id="error_text_password" class="input_error"></div>

	<div style="margin:0 auto; width: 300px;">
	<input name="text_password" type="password" id="text_password" size="40" maxlength="250" value="{$params.text_password|escape:'html':'UTF-8'}"/>
	</div>
</div>
   
<!-- 自動ログイン -->
<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; margin-top:30px;">
	<input id="autosave" type="checkbox" name="autosave" {if $params.autosave =='on' }checked="checked"{/if} value="on">
	<label for="autosave">次回からは自動的にログインする</label>
</div>


<!--ボタン-->
<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; margin-top:30px;">
	<input type="submit" value="ログイン" class="bigbutton"/>
</div>

<!-- パスワード忘れた -->
<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; margin-top:30px;">
	<a href="artist_lostpassword.php">&laquo;&nbsp;パスワードを忘れた</a>
</div>


{/if}

</form>
