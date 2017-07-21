
<form action="" method="post" name="frm_user_logout">

{if $message==""}
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">
	<input type="submit" name="destroy_btn" class="bigbutton" value="ログアウト"/>
</div>

{else}
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px">
{$message nofilter}
</div>
{/if}

</form>
