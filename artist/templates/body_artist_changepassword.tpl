<form action="" method="post" name="frm_artist_changepassword">

{if $params.send != 'done'}


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
	<h3><p>パスワードの変更</p></h3>
    <p>※８文字以上、３２文字以下の半角英数字</p>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; margin-top:30px;">
	<div style="margin:0 auto; width: 300px;">
	<label>変更前のパスワード</label>
	<input name="before_pass" id="before_pass" size="40" maxlength="255" placeholder="" type="password">
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; margin-top:30px;">
	<div style="margin:0 auto; width: 300px;">
	<label>変更後のパスワード</label>
	<input name="after_pass1" id="after_pass1" size="40" maxlength="255" placeholder="" type="password">
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; margin-top:30px;">
	<div style="margin:0 auto; width: 300px;">
	<label>変更後のパスワード（確認用）</label>
	<input name="after_pass2" id="after_pass2" size="40" maxlength="255" placeholder="" type="password">
	</div>
</div>

{/if}

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; margin-top:30px;">
	<font size="+1" color="red">{$params.message nofilter}</font>
</div>

{if $params.send != 'done'}

<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; margin-top:30px;">
	<input type="submit" name="change_pass" value="変更" class="bigbutton"/>
</div>

{/if}

</form>
