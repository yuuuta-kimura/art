{literal}
<script>
$("frm_order_check").submit(function() {
  var self = this;
  $(":submit", self).prop("disabled", true);
  setTimeout(function() {
    $(":submit", self).prop("disabled", false);
  }, 10000);
});
</script>
{/literal}

<form action="" method="post" name="frm_order_check"  onSubmit="return check()">

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:40px 0 0 0;">
	<h2>内容の確認</h2>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0;">
	<div  class="input_error">{$params.error_message}</div>
    <input type="submit" id="return_btn" name="return_btn" class="bigbutton" value="戻る" />
</div>

<input type="hidden" name="token" value="{$token}">

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0;">
	<div class="indexlabel">内容</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0;">
	{$params.html nofilter}	
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0;">
	<div class="indexlabel">クレジットカード</div>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0;">

<p>番号：{$params.text_cardno}</p>
<input type="hidden" name="text_cardno" id="text_cardno" value="{$params.text_cardno}"/>
<input type="hidden" name="text_code" id="text_code" value="{$params.text_code}"/>
<input type="hidden" name="slt_month" id="slt_month" value="{$params.slt_month}"/>
<input type="hidden" name="slt_year" id="slt_year" value="{$params.slt_year}"/>


</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0;">
	<div class="indexlabel">作品の送付先</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0;">

<p>郵便番号：{$params.text_post_left}ー{$params.text_post_right}</p>
<input type="hidden" name="text_post" id="text_post" value="{$params.text_post_left}-{$params.text_post_right}"/>
<p>住所：{$params.slt_prefecture}{$params.text_city}{$params.text_banchi}</p>
<input type="hidden" name="slt_prefecture" id="slt_prefecture" value="{$params.slt_prefecture}"/>
<input type="hidden" name="text_city" id="text_city" value="{$params.text_city}"/>
<input type="hidden" name="text_banchi" id="text_banchi" value="{$params.text_banchi}"/>
<p>宛名：{$params.text_atena}</p>
<input type="hidden" name="text_atena" id="text_atena" value="{$params.text_atena}"/>
<p>電話番号：{$params.text_tel_left}ー{$params.text_tel_center}ー{$params.text_tel_right}</p>
<input type="hidden" name="text_tel" id="text_tel" value="{$params.text_tel_left}-{$params.text_tel_center}-{$params.text_tel_right}"/>

</div>

{if $params.cart_num != 0}
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0;">
    <div id="cmd_regist"><input type="submit" id="order_btn" name="order_btn" class="bigbutton" style="color: red;" value="この内容で決済する" /></div>
</div>
{/if}


</form>