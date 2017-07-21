
<div class="detail_work col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:30px 0 0 0;">
	<font size="+1">
	{$params.html nofilter}
	</font>
</div>

<form action="" method="post" name="frm_order_cart">

{if $login_flg=='yes'}
{if $params.cart_num != 0}
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0; text-align: center;">
    <input type="submit" id="order_btn" name="order_btn" class="bigbutton" value="購入手続きに進む" />
</div>
{/if}
{else}
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0; text-align: center;">
    <input type="submit" id="order_btn" name="order_btn" class="bigbutton" value="購入するためにログインする" />
</div>
{/if}


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0; text-align: center;">
	<div  class="input_error">{$params.message}</div>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" style="margin:30px 0 0 0;">
    <input type="submit" id="return_btn" name="return_btn" class="bigbutton" value="ギャラリーに戻る" />
</div>

</form>

