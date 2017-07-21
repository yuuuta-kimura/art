
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">
	<h2>e-ART ユーザー登録</h2>
</div>

    
<form action="" method="post" name="frm_regist_user"  onSubmit="return check()">


                                
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">
     <div  class="input_error">{$params.message}</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">

	<div style="display:inline-flex">
	<div id="box_left" style="clear:both; float:left;">
		<p><label for="text_kanji_sei">●姓（漢字）</label></p>

		<div id="error_text_kanji_sei" class="input_error"></div>
		<input name="text_kanji_sei"  type="text" id="text_kanji_sei" size="15" maxlength="30" value="{$params.text_kanji_sei}" />
	</div>        

	<div id="box_left" style="float:left; margin-left:20px;">
		<p><label for="text_kanji_mei">●名（漢字）</label></p>

		<div id="error_text_kanji_mei" class="input_error"></div>
		<input name="text_kanji_mei"  type="text" id="text_kanji_mei" size="15" maxlength="30" value="{$params.text_kanji_mei}" />
	</div>        
	</div>

</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">

	<div style="display:inline-flex">
	<div id="box_left" style="clear:both; float:left;">
		<p><label for="text_kana_sei">●せい（平仮名）</label></p>

		<div id="error_text_kana_sei" class="input_error"></div>
		<input name="text_kana_sei"  type="text" id="text_kana_sei" size="15" maxlength="30" value="{$params.text_kana_sei}" />
	</div>        

	<div id="box_left" style="float:left; margin-left:20px;">
		<p><label for="text_kana_mei">●めい（平仮名）</label></p>

		<div id="error_text_kana_mei" class="input_error"></div>
		<input name="text_kana_mei"  type="text" id="text_kana_mei" size="15" maxlength="30" value="{$params.text_kana_mei}" />
	</div>
	</div>

</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">

	<p><label for="text_mailaddress">●メールアドレス</label></p>

	<div id="error_text_mail" class="input_error"></div>

	<div style="display:inline-flex">
	<input name="text_mailaddress" id="text_mailaddress" size="50" maxlength="255" placeholder="" value="{$params.text_mailaddress|escape:'html':'UTF-8'}" type="text" onChange="mail_check()">
	</div>

</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">

	<p><label for="text_mailaddress">●生年</label></p>
  
   	<div id="error_slt_birth_year" class="input_error"></div>

	<div id="text_normal" style="display:inline-flex">

	<select id="slt_birth_year" name="slt_birth_year">
	<option value="" selected>ー</option>
	{section name=i loop=$smarty.now|date_format:'%Y'  max=100 step=-1}
	<option value="{$smarty.section.i.index}">{$smarty.section.i.index}年</option>
	{/section}
	</select></div>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">

	<p><label for="slt_gender">●性別</label></p>

	<div id="error_slt_gender" class="input_error"></div>
	<div id="text_normal" style="display:inline-flex">
	<select id="slt_gender" name="slt_gender" >
	<option value="" {if $params.slt_gender==""} selected{/if}>ー</option>
	<option value="1" {if $params.slt_gender==1} selected{/if}>男</option>
	<option value="2" {if $params.slt_gender==2} selected{/if}>女</option>
	</select>
	</div>
	
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">
    <p><label for="slt_prefecture">●ご出身の都道府県</label></p>

	   <div id="error_slt_prefecture" class="input_error"></div>

    <div  style="display:inline-flex">
    <select id="slt_prefecture" name="slt_prefecture">
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
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">
	<p><label for="text_kiyaku">下記の一般向け利用規約、プロライバシーポリシー、特定商取引に関する表示を必ずお読みください。</label></p>

	
	<textarea name="text_kiyaku" id="text_kiyaku" style="clear:both;float:left; width:90%; height:300px;"> 
	{$kiyaku}
	</textarea>

</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">
	<div id="error_doui" class="input_error" style="clear: both;float: width:100%; left; text-align:center;"></div>
	<div style="clear: both;float: left; width:100%; text-align:center;"><input type="checkbox" name="chkbox_doui" id="chkbox_doui" value="ok"> 一般向け利用規約、プロライバシーポリシー、特定商取引に関する表示に同意する</div>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top:30px;">
	<div id="error_all" class="input_error"></div>
	<input type="submit" name="input_btn" value="登録" class="bigbutton" onClick="set_clickbtn('regist')" />
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right" style="margin-top:30px;">
<input type="submit" id="return_btn" name="return_btn" class="bigbutton" value="ログインに戻る" onClick="set_clickbtn('return')"/>
</div>


<input type="hidden" name="onbtn" value=""> 

</form>