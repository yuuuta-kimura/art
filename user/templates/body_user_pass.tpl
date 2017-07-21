<form action="" method="post" name="frm_user_pass">

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">
    <h2>
    <p>パスワードの変更</p>
    </h2>
    <p>※８文字以上、３２文字以下の半角英数字</p>
	<div id="box"><div  class="input_error">{$message}</div></div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">
<p><label>変更前のパスワード</label></p>
<div style="display:inline-flex">
<input name="before_pass"  type="text" id="before_pass" size="20" maxlength="255"/>
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">
<p><label>変更後のパスワード</label></p>
<div style="display:inline-flex">
<input name="after_pass1"  type="text" id="after_pass1" size="20" maxlength="255"/>
</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">
<p><label>変更後のパスワード（確認用）</label></p>
<div style="display:inline-flex">
<input name="after_pass2"  type="text" id="after_pass2" size="20" maxlength="255"/>
</div>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">
	<input type="submit" name="change_pass" class="bigbutton" value="変更"/>
</div>

</form>
