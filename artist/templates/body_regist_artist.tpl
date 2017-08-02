{if $frm_type=="regist"}
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:15px;">
	<h3><p>本サービスの申請ページ</p></h3>
	<h5>
	<p>本サービス利用をご希望の場合は、下記フォームを入力して申請を行ってください。</p>
	<p>後日、当社担当より、詳しい内容をお伺いするため、メールにてご返信させていただきます。</p>
	</h5>
</div>
{/if}

{if $frm_type=="profile"}
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;">        
	<h1><font size="+3"><b>作品の編集</b></font></h1>	
</div>
{/if}

{if $frm_type=="regist"}    
<form action="" method="post" name="frm_regist_artist"  onSubmit="return check_regist()">
{/if}

{if $frm_type=="profile"}    
<form action="" method="post" name="frm_regist_artist"  onSubmit="return check_profile()">
{/if}

<input type='hidden' name='artist_id' id='artist_id' value='{$params.artist_id}'/>			



<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:15px;">

{if $frm_type=="profile"}<div style="margin:0 auto; width: 350px;">{/if}

	<div style="float: left;">
		<label for="text_kanji_sei">●姓</label>
		<div id="error_text_kanji_sei" class="input_error"></div>
		<div id="text_normal" style="display:inline-flex">
		<input name="text_kanji_sei"  type="text" id="text_kanji_sei" size="15" maxlength="30" value="{$params.text_kanji_sei}" />
		</div>
	</div>

	<div style="float: left; margin-left: 10px;">
		<label for="text_kanji_mei">●名</label>
		<div id="error_text_kanji_mei" class="input_error"></div>
		<div id="text_normal" style="display:inline-flex">
		<input name="text_kanji_mei"  type="text" id="text_kanji_mei" size="15" maxlength="30"  value="{$params.text_kanji_mei}" /></div>
	</div>

{if $frm_type=="profile"}</div>{/if}	
</div> 


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:15px;">
{if $frm_type=="profile"}<div style="margin:0 auto; width: 350px;">{/if}

	<div style="float: left;">
		<label for="text_kana_sei">●せい</label>

		<div id="error_text_kana_sei" class="input_error"></div>
		<div id="text_normal" style="display:inline-flex">
		<input name="text_kana_sei"  type="text" id="text_kana_sei" size="15" maxlength="30"  value="{$params.text_kana_sei}" /></div>
	</div>        

	<div style="float: left; margin-left: 10px;">
		<label for="text_kana_mei">●めい</label>

		<div id="error_text_kana_mei" class="input_error"></div>
		<div id="text_normal" style="display:inline-flex">
		<input name="text_kana_mei"  type="text" id="text_kana_mei" size="15" maxlength="30"  value="{$params.text_kana_mei}" /></div>
	</div>

{if $frm_type=="profile"}</div>{/if}
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:15px;">
{if $frm_type=="profile"}<div style="margin:0 auto; width: 350px;">{/if}
	<p><label for="text_mailaddress">●メールアドレス</label></p>

	<div id="error_text_mail" class="input_error"></div>

	<div id="text_normal">
	<input name="text_mailaddress" id="text_mailaddress" size="40" maxlength="255" placeholder="" value="{$params.text_mailaddress|escape:'html':'UTF-8'}" type="text" onChange="mail_check()"></div>
{if $frm_type=="profile"}</div>{/if}
</div>


{if $frm_type=="regist"}

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:15px;">
		<p><label for="slt_gender">●性別</label></p>

		<div id="error_slt_gender" class="input_error"></div>
		<div id="text_normal">
		<select id="slt_gender" name="slt_gender" >
		<option value="" selected>ー</option><option value="1">男</option><option value="2">女</option>
		</select>
		</div>
	</div>

		        
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:15px;">
       
        <p><label for="slt_birth_year">●生年月日</label></p>
		
		<p>
        <div style="float: left;">

            <div id="error_slt_birth_year" class="input_error"></div>

           <div id="text_normal" style="display:inline-flex">
           
            <select id="slt_birth_year" name="slt_birth_year">
            <option value="" selected>ー</option>
            {section name=i loop=$smarty.now|date_format:'%Y'  max=100 step=-1}
            <option value="{$smarty.section.i.index}">{$smarty.section.i.index}年</option>
            {/section}
            </select></div>
        </div>

        <div style="float: left;">

            <div id="error_slt_birth_month" class="input_error"></div>

           <div id="text_normal" style="display:inline-flex">
           
            <select id="slt_birth_month" name="slt_birth_month">
            <option value="" selected>ー</option>
            {section name=i  start=1 loop=13 max=12 step=1}
            <option value="{$smarty.section.i.index}">{$smarty.section.i.index}月</option>
            {/section}
            </select></div>
        </div>

        <div style="float: left;">

            <div id="error_slt_birth_day" class="input_error"></div>

           <div id="text_normal" style="display:inline-flex">
           
            <select id="slt_birth_day" name="slt_birth_day">
            <option value="" selected>ー</option>
            {section name=i  start=1 loop=32 max=31 step=1}
            <option value="{$smarty.section.i.index}">{$smarty.section.i.index}日</option>
            {/section}
            </select></div>
        </div>
		
       </p>
        
	</div>
      
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:15px;">
		<p><label for="text_main_record"><p>●受賞歴など主な実績を３つ教えてください</p>
		</label></p>


		<div id="error_text_main_record" class="input_error"></div>
		<div id="text_normal" style="width:100%;">
  		<textarea name="text_main_record" id="text_main_record" class="main_record" style="width:90%; height:200px;">{$params.text_main_record}</textarea>
   		</div>
    </div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:15px;">

		<p><label for="text_sub_record"><p>●美術に関わる出身大学、または職歴を教えてください</p>
		</label></p>

		<div id="error_text_sub_record" class="input_error"></div>
		<div id="text_normal" style="width:100%;">
   		<textarea name="text_sub_record" id="text_sub_record" class="sub_record" style="width:90%; height:200px;">{$params.text_sub_record}</textarea>
   		</div>
   		
    </div>


	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:15px;">
		<p><label for="text_kiji_link">●ホームページがあればURLを教えてください</label></p>

		<div id="error_text_kiji_link" class="input_error"></div>

		<div id="text_normal" style="display:inline-flex"><input name="text_kiji_link" id="text_kiji_link" size="40" maxlength="1000" placeholder="" value="{$params.text_kiji_link}" type="text"></div>
	</div>



	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:15px;">
		<p><label for="text_kiyaku">下記の規約を必ず全てお読みください。</label></p>

		<div id="error_doui" class="input_error"></div>

		<div style="width:100%;">
		<textarea name="text_kiyaku" class="textarea_kiyaku" id="text_kiyaku" style="width:90%;height:200px;">{$kiyaku}
		</textarea>
		</div>

	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:15px; width:100%;">
	<div style="margin:0 auto; width: 200px; text-align: center;">
		<input type="checkbox" id="chkbox_doui" name="chkbox_doui" value="ok" />
		<label for="openworks">規約に同意する</label>
	</div>
	</div>

{/if}

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:50px; text-align:center;">
		<font size="+1"><b><div id="error_all" class="input_error">{$params.message}</div></b></font>
	</div>
	
	<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; margin-top:30px;">

{if $frm_type=="regist"}
		<input type="submit" name="input_btn" value="登録を申請する"  class="bigbutton"/>
{/if}
{if $frm_type=="profile"}
		<input type="submit" name="input_btn" value="更新する"  class="bigbutton"/>
{/if}
	</div>
    
    
</form>