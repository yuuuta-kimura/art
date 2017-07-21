<form action="" method="post" name="frm_user_profile">

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">
    <h2>
    <p>E-MAILの変更</p>
    </h2>
	<div  class="input_error">{$message}</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">
<p><label>変更先のメールアドレス</label></p>
<div style="display:inline-flex">
	<input name="text_mailaddress" id="text_mailaddress" size="50" maxlength="255" placeholder="" value="{$params.text_mailaddress|escape:'html':'UTF-8'}" type="text">
</div>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">
	<input type="submit" name="change_pass" class="bigbutton" value="変更"/>
</div>

</form>
