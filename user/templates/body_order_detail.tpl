<form action="" method="post" name="frm_order_detail" onSubmit="return check()">


<div class="detail_work col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:30px 0 0 0;">
	注文番号：{$params.order_char nofilter}
</div>

<div class="detail_work col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	注文日時：{$params.order_time nofilter}
</div>

{if $params.cancel_time!=''}

<div class="detail_work text-danger col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	キャンセル日時：{$params.cancel_time nofilter}
</div>

{/else}

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" style="margin:30px 0 0 0;">
    <input type="submit" id="receipt_btn" name="receipt_btn" class="smallbutton" value="領収書" onClick="set_clickbtn('receipt')"/>
</div>

{/if}



<div id="cart-table" class="detail_work col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:30px 0 0 0;">
	{$params.html nofilter}
</div>

<div class="detail_work col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" style="margin:30px 0 0 0;">
	小計：{$params.small_sum_price nofilter}
</div>

<div class="detail_work col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" style="margin:10px 0 0 0;">
	消費税：{$params.tax nofilter}
</div>

<div class="detail_work col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" style="margin:10px 0 0 0;">
	合計：{$params.all_sum_price nofilter}
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:10px;">
     <div  class="input_error">{$params.message}</div>
</div>

{if $params.cancel_enable==true}
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:30px 0 0 0; text-align: center;">
    <input type="submit" id="cancel_btn" name="cancel_btn" class="bigbutton" value="注文を取消する"  onClick="set_clickbtn('cancel')"/>
</div>
{/if}

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" style="margin:30px 0 0 0;">
    <input type="submit" id="return_btn" name="return_btn" class="bigbutton" value="戻る" onClick="set_clickbtn('return')"/>
</div>

<input type="hidden" name="onbtn" value=""> 


</form>

