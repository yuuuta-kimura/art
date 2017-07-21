
<form action="" method="post" name="frm_login_user"  onSubmit="return check()">

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
	<h2>パスワード再発行</h2>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center input_error" style="margin-top:30px">
	{$message nofilter}
</div>     
     
<!--メールアドレス-->
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">    
<div id="text_normal" style="display:inline-flex"><input name="text_mailaddress" id="text_mailaddress" size="40" maxlength="255" placeholder=""  type="text"></div>
</div>

<!--ボタン-->
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">    
    <input type="submit" value="送信" class="bigbutton"/>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" style="margin-top:30px">
	<input type="submit" id="return_btn" name="return_btn" value="ログインに戻る" class="bigbutton" />
</div>

</form>
