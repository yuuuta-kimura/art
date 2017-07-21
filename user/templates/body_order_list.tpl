<form action="" method="post" name="frm_order_list">
<input type="hidden" name="artist_id" id="artist_id" value="{$params.artist_id}"/>

<div class="row" style="margin:50px 0 0 0;">
{$params.html nofilter}
</div>

<div class="row" style="margin:50px 0 0 0;">
	<div class="paging" style="margin:0 auto; width: 200px; text-align: center;">
	<font size="+3" color="#444444">
	{$params.paging nofilter}
	</font>
	</div>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" style="margin:30px 0 0 0;">
    <input type="submit" id="return_btn" name="return_btn" class="bigbutton" value="戻る" />
</div>

</form>

