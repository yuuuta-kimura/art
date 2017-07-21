<form action="" method="post" name="frm_toiawase"  onSubmit="return check()">

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:40px 0 0 0; text-align:center;">
	<h2>お問い合わせ</h2>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0; text-align:center;">
 	<input type="submit" name="close_btn" value="閉じる" class="bigbutton" onClick="window.close(); return false;" />
 	
</div>

<input type="hidden" name="artist_id" id="artist_id" value="{$params.artist_id}"/>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0;">
	<div class="indexlabel">件名</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0;">
	<div id="error_text_kenmei" class="input_error"></div>
	<input name="text_kenmei"  type="text" id="text_kenmei" size="50" maxlength="100"  value="{$params.text_kenmei}" />
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0;">
	<div class="indexlabel">お客様情報</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:50px;">

	<p><label for="slt_customer">●個人／法人</label></p>

	<div id="error_slt_customer" class="input_error"></div>
	<select id="slt_customer" name="slt_customer" >
	<option value="個人" {if $params.slt_customer=='個人'}selected{/if}>個人</option>
	<option value="法人" {if $params.slt_customer=='法人'}selected{/if}>法人</option>
	</select>
	
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:15px 0 0 0;">

	<div style="clear: both;">
		<p><label>●法人名（法人を選んだ場合は必須）</label></p>

		<div id="error_text_hojin" class="input_error"></div>
		<input name="text_hojin"  type="text" id="text_hojin" size="50" maxlength="100" value="{$params.text_hojin}" />

	</div>

	<div style="clear: both;">

		<p><label>●氏名</label></p>

		<div style="float: left;">
			<div id="error_text_sei" class="input_error"></div>
			<input name="text_sei"  type="text" id="text_sei" size="15" maxlength="30" value="{$params.text_sei}" />
		</div>

		<div style="float: left; margin-left: 10px;">
			<div id="error_text_mei" class="input_error"></div>
			<input name="text_mei"  type="text" id="text_mei" size="15" maxlength="30"  value="{$params.text_mei}" />
		</div>
		
	</div>

</div>        

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:15px;">

	<p><label for="text_mailaddress">●メールアドレス</label></p>

	<div id="error_text_mail" class="input_error"></div>

	<input name="text_mailaddress" id="text_mailaddress" size="40" maxlength="255" placeholder="" value="{$params.text_mailaddress|escape:'html':'UTF-8'}" type="text" onChange="mail_check()">

</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0;">
	<div class="indexlabel">内容</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:15px;">

	<div id="error_text_naiyo" class="input_error"></div>
	<textarea name="text_naiyo" id="text_naiyo" style="width:90%; height:200px;">{$params.text_naiyo}</textarea>

</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0; font-size:12px;">
<p>※問い合わせの回答は、運営会社である株式会社ニューディメンションがいたします</p>
<p>※アーティストへの直接のお問い合わせはお請けしておりません</p>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:50px; text-align:center;">
	<font size="+1"><b><div id="error_all" class="input_error">{$params.message}</div></b></font>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0; text-align:center;">
	<input type="submit" name="send_btn" value="送信" class="bigbutton" onClick="set_clickbtn('regist')" />
    
</div>

<input type="hidden" name="onbtn" value=""> 

</form>