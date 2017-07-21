<form action="" method="post" name="frm_order_detail" onSubmit="return check()">

<div class="detail_work col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:30px 0 0 0;">
	<font size="+1">
	{$params.html nofilter}
	</font>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:10px;">
     <div  class="input_error">{$params.message}</div>
</div>

{if $params.receive !="yes"}

	{if $params.receivelimit !="yes"}
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:30px 0 0 0; text-align: center;">
			<input type="submit" id="receive_btn" name="receive_btn" class="bigbutton" disabled=disabled value="受注する" style="color:#CCCCCC" />
		</div>
		
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0; text-align: center;">
			<div  class="input_error">注文後の30分後に、受注確定処理が可能です</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0; text-align: center;">
			<div  class="input_error">上記のボタンをクリックする事で、お客様が注文をキャンセルできなくなります<BR>
			ボタンをクリックしない場合は、お客様のキャンセルが可能となりますのでご注意ください</div>
		</div>
	{else}
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:30px 0 0 0; text-align: center;">
			<input type="submit" id="receive_btn" name="receive_btn" class="bigbutton" value="受注する"  onClick="set_clickbtn('receive_btn')"/>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0; text-align: center;">
			<div  class="input_error">上記のボタンをクリックする事で、お客様が注文をキャンセルできなくなります<BR>
			ボタンをクリックしない場合は、お客様のキャンセルが可能となりますのでご注意ください</div>
		</div>
	{/if}

{else}

	{if $params.send !="yes"}

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:30px 0 0 0; text-align: center;">
		<input type="submit" id="send_btn" name="send_btn" class="bigbutton" value="発送する"  onClick="set_clickbtn('send_btn')"/>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:30px 0 0 0; text-align: center;">
		 <div  class="input_error">上記のボタンをクリックする事で、お客様に発送済みである事をお知らせします</div>
	</div>

	{else}
	
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:30px 0 0 0; text-align: center;">
		 <div  class="input_error">既に発送処理済みです</div>
	</div>

	{/if}
                    
{/if}


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" style="margin:30px 0 0 0;">
    <input type="submit" id="return_btn" name="return_btn" class="bigbutton" value="戻る"  onClick="set_clickbtn('return_btn')"/>
</div>

<input type="hidden" name="onbtn" value=""> 


</form>

