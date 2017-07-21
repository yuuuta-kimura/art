
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0;">
	<font size="+1">{$params.kanji_sei} {$params.kanji_mei}</font>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	<font size="+1">{$params.kana_sei} {$params.kana_mei}</font>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	ID: {$params.artist_id}
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	Check: {$params.check_flg}
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	Mailaddress: {$params.mailaddress}
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	Tel: {$params.tel}
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	Birthday: {$params.birthday}
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	Gender: {$params.gender}
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	Record1: <BR>{$params.main_record}
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	Record2: <BR>{$params.sub_record}
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	URL: {$params.kiji_link}
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	{$params.post}<BR>
	{$params.jyusyo}
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	Regist: {$params.regist_time}<BR>
	Update: {$params.update_time}
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0;">
<div  class="input_error">{$params.done}</div>
</div>

<form action="" method="post" name="frm_admin_artist_detail">
<input type=hidden name="text_name" value="{$params.kanji_sei} {$params.kanji_mei}">
<input type=hidden name="text_mailaddress" value="{$params.mailaddress}">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0;">
<button type="submit" name="bt_OKNG" value="1">
<font size="+1">OK</font>
</button>
<button type="submit" name="bt_OKNG" value="2" style="margin-left:20px;">
<font size="+1">NG</font>
</button>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
<button type="submit" name="bt_Mail" value="1">
<font size="+1">OK Mail送信</font>
</button>
<button type="submit" name="bt_Mail" value="2" style="margin-left:20px;">
<font size="+1">NG Mail送信</font>
</button>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
<button type="submit" name="bt_Ret" value="return">
<font size="+1">戻る</font>
</button>
</div>
</form>
