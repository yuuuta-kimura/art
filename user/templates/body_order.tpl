{literal}
<script>
$("frm_order").submit(function() {
  var self = this;
  $(":submit", self).prop("disabled", true);
  setTimeout(function() {
    $(":submit", self).prop("disabled", false);
  }, 10000);
});
</script>
{/literal}

<form action="" method="post" name="frm_order"  onSubmit="return check()">

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:40px 0 0 0;">
	<h2>支払い情報の入力</h2>
</div>

{if $login_flg != 'yes'}
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0;">
セッションがなくなりました。再度ログインが必要です。
</div>
{else}

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0;">
	<div  class="input_error">{$params.error_message}</div>
    <input type="submit" id="return_btn" name="return_btn" class="bigbutton" value="戻る" onClick="set_value('return')" />
</div>

<input type="hidden" name="onbtn">
<input type="hidden" name="token" value="{$token}">

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0;">
	<div class="indexlabel">内容</div>
</div>

{$params.cart nofilter}

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0;">
	<div class="indexlabel">カード情報</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0;">
    <label for="text_cardno"><p>●クレジットカード番号</p><p style="font-size:12px">※すべてのクレジットカードでご利用できます</p></label>

    <p><div id="error_text_cardno" class="input_error"></div></p>
    <input name="text_cardno"  type="text" id="text_cardno" size="16" maxlength="16" value="" />
</div>        

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0;">
    <label for="text_code">●セキュリティコード（3〜4桁）</label>

    <p><div id="error_text_code" class="input_error"></div></p>
    <input name="text_code"  type="text" id="text_code" size="4" maxlength="4" value="" />
</div>        

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0;">
    <label>●有効期限　month(月)／year(年)</label>

    <p><div id="error_slt_mmyy" class="input_error"></div></p>

        <div style="clear:both; float:left;">
			<select id="slt_month" name="slt_month">
			<option value="" selected>-</option>
			<option value="01">01</option>
			<option value="02">02</option>
			<option value="03">03</option>
			<option value="04">04</option>
			<option value="05">05</option>
			<option value="06">06</option>
			<option value="07">07</option>
			<option value="08">08</option>
			<option value="09">09</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
			</select>
        </div>
		<div style="float:left; padding:12px 3px 0 3px;">／</div>
        <div style="float:left;">
			<select id="slt_year" name="slt_year">
			<option value="" selected>-</option>
			{$slt_year nofilter}
			</select>
		</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0; font-size:12px;">
<p>※決済システムはGMOペイメントゲートウェイ株式会社を利用しております。</p>
<p>※本サイトはSSL暗号化通信をしておりますので、入力した情報は安全にカード会社へ送信されます。</p>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0;">
	<div class="indexlabel">商品の送付先</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0;">

    <label for="text_post">●郵便番号</label>

    <p><div id="error_text_post" class="input_error"></div></p>
    
    <div style="clear:both; float:left;">
    <input name="text_post_left"  type="tel" id="text_post_left" size="3" maxlength="3" value="{$params.text_post_left|escape:'html':'UTF-8'}" />
	</div>
	<div style="float:left; padding:20px 3px 0 3px;">ー</div>
    <div style="float:left;">
    <input name="text_post_right"  type="tel" id="text_post_right" size="4" maxlength="4" value="{$params.text_post_right|escape:'html':'UTF-8'}" />
	</div>
   
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0;">
    <label for="slt_prefecture">●都道府県</label>
    
    <p><div id="error_slt_prefecture" class="input_error"></div></p>
   
   <select id="slt_prefecture" name="slt_prefecture" >
        <option value="" {if $params.slt_prefecture==""} selected{/if}>選択してください</option>
        <option value="国外" {if $params.slt_prefecture=="国外"} selected{/if}>国外</option>
        <option value="北海道" {if $params.slt_prefecture=="北海道"} selected{/if}>北海道</option>
        <option value="青森県" {if $params.slt_prefecture=="青森県"} selected{/if}>青森県</option>
        <option value="岩手県" {if $params.slt_prefecture=="岩手県"} selected{/if}>岩手県</option>
        <option value="宮城県" {if $params.slt_prefecture=="宮城県"} selected{/if}>宮城県</option>
        <option value="秋田県" {if $params.slt_prefecture=="秋田県"} selected{/if}>秋田県</option>
        <option value="山形県" {if $params.slt_prefecture=="山形県"} selected{/if}>山形県</option>
        <option value="福島県" {if $params.slt_prefecture=="福島県"} selected{/if}>福島県</option>
        <option value="茨城県" {if $params.slt_prefecture=="茨城県"} selected{/if}>茨城県</option>
        <option value="栃木県" {if $params.slt_prefecture=="栃木県"} selected{/if}>栃木県</option>
        <option value="群馬県" {if $params.slt_prefecture=="群馬県"} selected{/if}>群馬県</option>
        <option value="埼玉県" {if $params.slt_prefecture=="埼玉県"} selected{/if}>埼玉県</option>
        <option value="千葉県" {if $params.slt_prefecture=="千葉県"} selected{/if}>千葉県</option>
        <option value="東京都" {if $params.slt_prefecture=="東京都"} selected{/if}>東京都</option>
        <option value="神奈川県" {if $params.slt_prefecture=="神奈川県"} selected{/if}>神奈川県</option>
        <option value="新潟県" {if $params.slt_prefecture=="新潟県"} selected{/if}>新潟県</option>
        <option value="富山県" {if $params.slt_prefecture=="富山県"} selected{/if}>富山県</option>
        <option value="石川県" {if $params.slt_prefecture=="石川県"} selected{/if}>石川県</option>
        <option value="福井県" {if $params.slt_prefecture=="福井県"} selected{/if}>福井県</option>
        <option value="山梨県" {if $params.slt_prefecture=="山梨県"} selected{/if}>山梨県</option>
        <option value="長野県" {if $params.slt_prefecture=="長野県"} selected{/if}>長野県</option>
        <option value="岐阜県" {if $params.slt_prefecture=="岐阜県"} selected{/if}>岐阜県</option>
        <option value="静岡県" {if $params.slt_prefecture=="静岡県"} selected{/if}>静岡県</option>
        <option value="愛知県" {if $params.slt_prefecture=="愛知県"} selected{/if}>愛知県</option>
        <option value="三重県" {if $params.slt_prefecture=="三重県"} selected{/if}>三重県</option>
        <option value="滋賀県" {if $params.slt_prefecture=="滋賀県"} selected{/if}>滋賀県</option>
        <option value="京都府" {if $params.slt_prefecture=="京都府"} selected{/if}>京都府</option>
        <option value="大阪府" {if $params.slt_prefecture=="大阪府"} selected{/if}>大阪府</option>
        <option value="兵庫県" {if $params.slt_prefecture=="兵庫県"} selected{/if}>兵庫県</option>
        <option value="奈良県" {if $params.slt_prefecture=="奈良県"} selected{/if}>奈良県</option>
        <option value="和歌山県" {if $params.slt_prefecture=="和歌山県"} selected{/if}>和歌山県</option>
        <option value="鳥取県" {if $params.slt_prefecture=="鳥取県"} selected{/if}>鳥取県</option>
        <option value="島根県" {if $params.slt_prefecture=="島根県"} selected{/if}>島根県</option>
        <option value="岡山県" {if $params.slt_prefecture=="岡山県"} selected{/if}>岡山県</option>
        <option value="広島県" {if $params.slt_prefecture=="広島県"} selected{/if}>広島県</option>
        <option value="山口県" {if $params.slt_prefecture=="山口県"} selected{/if}>山口県</option>
        <option value="徳島県" {if $params.slt_prefecture=="徳島県"} selected{/if}>徳島県</option>
        <option value="香川県" {if $params.slt_prefecture=="香川県"} selected{/if}>香川県</option>
        <option value="愛媛県" {if $params.slt_prefecture=="愛媛県"} selected{/if}>愛媛県</option>
        <option value="高知県" {if $params.slt_prefecture=="高知県"} selected{/if}>高知県</option>
        <option value="福岡県" {if $params.slt_prefecture=="福岡県"} selected{/if}>福岡県</option>
        <option value="佐賀県" {if $params.slt_prefecture=="佐賀県"} selected{/if}>佐賀県</option>
        <option value="長崎県" {if $params.slt_prefecture=="長崎県"} selected{/if}>長崎県</option>
        <option value="熊本県" {if $params.slt_prefecture=="熊本県"} selected{/if}>熊本県</option>
        <option value="大分県" {if $params.slt_prefecture=="大分県"} selected{/if}>大分県</option>
        <option value="宮崎県" {if $params.slt_prefecture=="宮崎県"} selected{/if}>宮崎県</option>
        <option value="鹿児島県" {if $params.slt_prefecture=="鹿児島県"} selected{/if}>鹿児島県</option>
        <option value="沖縄県" {if $params.slt_prefecture=="沖縄県"} selected{/if}>沖縄県</option>
    </select>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0;">
    <label for="text_city"><b>●市区町村</b></label>
    
    <p><div id="error_text_city" class="input_error"></div></p>

    <input  type="text"  name="text_city" id="text_city" size="20" maxlength="20" placeholder=""  value="{$params.text_city|escape:'html':'UTF-8'}" type="text">
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0;">
    <label for="text_banchi"><b>●番地、マンション名など</b></label>
    
    <p><div id="error_text_banchi" class="input_error"></div></p>

    <input  type="text"  name="text_banchi" id="text_banchi" size="70" maxlength="100" placeholder=""  value="{$params.text_banchi|escape:'html':'UTF-8'}" type="text">
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0;">
    <label for="text_atena"><b>●宛名</b></label>
    
    <p><div id="error_text_atena" class="input_error"></div></p>

    <input type="text"  name="text_atena" id="text_atena" size="50" maxlength="50" placeholder=""  value="{$params.text_atena|escape:'html':'UTF-8'}" type="text">
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0;">
    <label for="text_tel"><b>●電話番号</b></label>
    
    <p><div id="error_text_tel" class="input_error"></div></p>

	<div style="clear:both; float:left;">
    <input type="tel" name="text_tel_left" id="text_tel_left" size="4" maxlength="4" placeholder=""  value="{$params.text_tel_left|escape:'html':'UTF-8'}" type="text">
	</div>
    
	<div style="float:left; padding:20px 3px 0 3px;">ー</div>
    
	<div style="float:left;">    
    <input type="tel" name="text_tel_center" id="text_tel_center" size="4" maxlength="4" placeholder="" value="{$params.text_tel_center|escape:'html':'UTF-8'}" type="text">
	</div>
            
	<div style="float:left; padding:20px 3px 0 3px;">ー</div>

   	<div style="float:left;">    
    <input type="tel" name="text_tel_right" id="text_tel_right" size="4" maxlength="4" placeholder="" value="{$params.text_tel_right|escape:'html':'UTF-8'}" type="text">
	</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:100px 0 0 0;">
    <p><div id="error_all" class="input_error"></div></p>
    <div id="cmd_regist"><input type="submit" id="order_btn" class="bigbutton" name="order_btn" value="次に進む"  onClick="set_value('next')"/></div>
</div>

{/if}

</form>