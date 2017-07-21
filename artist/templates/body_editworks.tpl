<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
	<h1><font size="+3"><b>作品の編集</b></font></h1>
</div>

<form action="" method="post" name="frm_EditWork" onSubmit="return check()">
<input type='hidden' name='artist_id' id='artist_id' value='{$params.artist_id}'/>
<input type='hidden' name='works_id' id='works_id' value='{$params.works_id}'/>
<input type='hidden' name='num_top_open_flg' id='num_top_open_flg' value='{$params.num_top_open_flg}'/>

<!-- アップロードボタン（ヒドゥン） headで埋め込み -->
<div id="upload_btn_no"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:50px; text-align:center;">
	<font size="+1"><b><div id="error_all" class="input_error">{$params.message}</div></b></font>
</div>

{if $params.text_zaiko_num == 0}
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">
	<div style="float: right; width: 100px;">
	<input type="submit" name="delete_btn" id="delete_btn" value="削除する" style="color:red;" class="bigbutton" />
	<div id="error_delete_btn" class="input_error" style="float:left; margin-left:20px;"></div>
	</div>
</div>
{/if}



<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
	<div style="float: left; width: 100px;">
	<input type="submit" name="return_btn" id="return_btn" value="戻る" class="bigbutton" />
	</div>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
    <div id="main_pic"><img src="{$params.main_pic}" class="mainpic"></div>
</div>
			
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">
	<input type="file" name="mainpic" id="mainpic"/>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:5px;">
	<input type="button" name="mainpic_btn" id="mainpic_btn" value="作品画像の登録"  onClick="uploadpicture('mainpic')"  style="float:left;" class="smallbutton" />
	<div id="error_mainpic_btn" class="input_error" style="float:left; margin-left:20px;"></div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:50px;">
	<label for="text_works_id"><font size="+1">●e-ART作品ID</font></label>
	<div>{$params.text_works_id}</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:50px;">
	<label for="text_title"><font size="+1">●作品タイトル</font></label>
	<div id="error_text_title" class="input_error"></div>
	<div id="text_normal"><input name="text_title" id="text_title" size="50" maxlength="50" value="{$params.text_title}" type="text"></div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:50px;">
	<label for="text_comment"><font size="+1">●作品の説明</font></label>
	<div id="error_text_comment" class="input_error"></div>
	<textarea name="text_comment" id="text_comment" style="width:90%; height:200px;">{$params.text_comment}</textarea>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:50px;">
	<label for="text_size"><font size="+1">●サイズ（幅cm × 高さcm）</font></label>
	<div id="error_size" class="input_error"></div>		
	<div style="float: left;">
		<input name="text_size_width" type="number" id="text_size_width" min="0" max="9999" value="{$params.text_size_width}" style="width:100px;"/>
	</div>        
	<div style="float: left; padding-top:20px; text-align:center; width:30px;">
		<font size="+1">×</font>
	</div>
	<div style="float: left; margin-left: 10px;">
		<input name="text_size_height"  type="number" id="text_size_height" min="0" max="9999" value="{$params.text_size_height}" style="width:100px;"/>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:50px;">
	<label for="slt_tech"><font size="+1">●主な技法</font></label>
	<div>技法をお選びください</div>
	<div id="error_slt_tech" class="input_error"></div>
	<select id="slt_tech" name="slt_tech">
	<option value="0" {if $params.slt_tech==0}selected{/if}>ー</option>
	<option value="1" {if $params.slt_tech==1}selected{/if}>油画</option>
	<option value="2" {if $params.slt_tech==2}selected{/if}>水彩画</option>
	<option value="3" {if $params.slt_tech==3}selected{/if}>アクリル画</option>
	<option value="4" {if $params.slt_tech==4}selected{/if}>鉛筆・ペン画</option>
	<option value="5" {if $params.slt_tech==5}selected{/if}>クレヨン画</option>
	<option value="6" {if $params.slt_tech==6}selected{/if}>水墨画</option>
	<option value="7" {if $params.slt_tech==7}selected{/if}>書道</option>
	<option value="8" {if $params.slt_tech==8}selected{/if}>木版画</option>
	<option value="9" {if $params.slt_tech==9}selected{/if}>リトグラフ</option>
	<option value="10" {if $params.slt_tech==10}selected{/if}>銅板画</option>
	<option value="11" {if $params.slt_tech==11}selected{/if}>シルクスクリーン</option>
	<option value="12" {if $params.slt_tech==12}selected{/if}>デジタルアート</option>
	</select>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div>その他の技法はこちらにお書きください</div>
	<input name="text_tech_other" id="text_tech_other" maxlength="100"  style="width:90%;" value="{$params.text_tech_other}" type="text">
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:50px;">
	<label for="slt_base"><font size="+1">●支持体</font></label>
	<div>支持体をお選びください</div>
	<div id="error_slt_base" class="input_error"></div>
	<select id="slt_base" name="slt_base">
	<option value="0" {if $params.slt_base==0}selected{/if}>ー</option>
	<option value="1" {if $params.slt_base==1}selected{/if}>布</option>
	<option value="2" {if $params.slt_base==2}selected{/if} >紙</option>
	<option value="3" {if $params.slt_base==3}selected{/if}>木</option>
	</select>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div>その他の支持体はこちらにお書きください</div>
	<input name="text_base_other" id="text_base_other" maxlength="100"  style="width:90%;" value="{$params.text_base_other}" type="text">
</div>



<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:50px;">
	<div><label for="text_zaiko_num"><font size="+1">●現在の未注文在庫個数</font></label></div>
	<div><font size="+1">　{$params.text_zaiko_num}個</font></div>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:50px;">
	<label for="text_price"><font size="+1">●価格（税抜き）</font></label>
	<div id="error_text_price" class="input_error"></div>		
	<div style="float: left;">
		{if $params.text_zaiko_num == 0}
		<div style="float: left;">
		<input name="text_price" type="number" id="text_price" placeholder="0" min="0" max="99999999" value="{$params.text_price}" style="width:200px;"/>
		</div>
		<div style="float: left; padding-top:20px;"><font size="+1">円</font></div>
		<div style="clear: both;">※{$params.price_min}円未満は設定できません</div>
		<div>※作品情報のみ登録したい場合は0円のまま更新してください</div>		
		{else}
		<input name="text_price" type="number" id="text_price" readonly value="{$params.text_price}" style="width:200px;"/>
		{/if}
	</div>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:50px;">
	<label for="text_insert_zaiko_num"><font size="+1">●追加する在庫個数</font></label>
	<div id="error_text_insert_zaiko_num" class="input_error"></div>		
	<div style="float: left;">
		<div style="float: left;"><input name="text_insert_zaiko_num" type="number" id="text_insert_zaiko_num" placeholder="0" min="1" max="999" value="{$params.text_insert_zaiko_num}" style="width:70px;"/></div>
		<div style="float: left; padding-top:20px;"><font size="+1">個</font></div>
	</div>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:50px;">
	<div style="margin:0 auto; width: 200px;">
	<font size="+2">
	<input type="radio" name="open_flg" value="0" {if $params.open_flg==0}checked{/if}>非公開
	<input type="radio" name="open_flg" value="1" {if $params.open_flg==1}checked{/if} style="margin-left: 10px;">公開
	</font>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px; width:100%;">
	<div style="margin:0 auto; width: 300px; text-align: center;">
		<font size="+1">
		<input type="checkbox" id="top_open_flg" name="top_open_flg" value="ok" {if $params.top_open_flg==1}checked="checked"{/if}/>
			<label for="openworks">トップに表示する<BR>（最大６アイテム）</label>
			<p>現在{$params.num_top_open_flg}アイテム</p>
		</font>
	</div>
</div>


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:60px;">
	<div style="margin:0 auto; width: 200px;">
	<input type="submit" name="update_btn" id="update_btn" value="情報を更新する" style="float:left; color:red;" class="bigbutton" />
	<div id="error_update_btn" class="input_error" style="float:left; margin-left:20px;"></div>
	</div>
</div>


</div>

</form>
