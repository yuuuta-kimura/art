<form action="" method="post" name="frm_login_user"  onSubmit="return check()">

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
	<h2>ログインページ</h2>
</div>


{if $params.login =='error' }
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center input_error" style="margin-top:30px">
ログインできませんでした。
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">
	<input type="submit" id="return_btn" name="return_btn" class="bigbutton" value="ギャラリーに戻る"/>
</div>

{else}

<!--メールアドレス-->
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">
	<div>メールアドレス</div>

	<div id="error_text_mail" class="input_error"></div>

	<div id="text_normal" style="display:inline-flex"><input name="text_mailaddress" id="text_mailaddress" size="40" maxlength="255" placeholder=""  type="text"  onChange="mail_check()"  value="{$params.text_mailaddress|escape:'html':'UTF-8'}"></div>
</div>

<!--パスワード-->
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">
	<div>パスワード</div>

	 <div id="error_text_password" class="input_error"></div>

	  <div id="text_normal" style="display:inline-flex">
		  <input name="text_password" type="password" class="form_input_login_hankaku" id="text_password" size="40" maxlength="250" value="{$params.text_password|escape:'html':'UTF-8'}"/>
	  </div>
</div>

<!-- 自動ログイン -->
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">
	<input id="autosave" type="checkbox" name="autosave" {if $params.autosave =='on' }checked="checked"{/if} value="on">
	<label for="autosave">次回からは自動的にログインする</label>
</div>


<!--ボタン-->
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">
	<input type="submit" class="bigbutton" value="ログイン" />
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">
	<input type="submit" id="make_user_btn" name="make_user_btn" class="bigbutton" value="ログイン用のアカウントを作成する (初めての方はこちら)" />
</div>


<!-- パスワード忘れた -->
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">
<a href="user_lostpassword.php">&laquo;&nbsp;パスワードを忘れた</a>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
	<input type="submit" id="return_btn" name="return_btn" class="bigbutton" value="ギャラリーに戻る"/>
</div>


{/if}

</form>
