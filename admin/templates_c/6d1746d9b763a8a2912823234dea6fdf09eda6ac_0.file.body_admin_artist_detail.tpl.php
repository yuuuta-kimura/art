<?php
/* Smarty version 3.1.30, created on 2017-02-21 03:00:23
  from "/Applications/MAMP/htdocs/kaisya/art/admin/templates/body_admin_artist_detail.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58ab9f37153eb2_62434244',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6d1746d9b763a8a2912823234dea6fdf09eda6ac' => 
    array (
      0 => '/Applications/MAMP/htdocs/kaisya/art/admin/templates/body_admin_artist_detail.tpl',
      1 => 1487642421,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58ab9f37153eb2_62434244 (Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:50px 0 0 0;">
	<font size="+1"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['kanji_sei'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['kanji_mei'], ENT_QUOTES, 'UTF-8', true);?>
</font>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	<font size="+1"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['kana_sei'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['kana_mei'], ENT_QUOTES, 'UTF-8', true);?>
</font>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	ID: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['artist_id'], ENT_QUOTES, 'UTF-8', true);?>

</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	Check: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['check_flg'], ENT_QUOTES, 'UTF-8', true);?>

</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	Mailaddress: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['mailaddress'], ENT_QUOTES, 'UTF-8', true);?>

</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	Tel: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['tel'], ENT_QUOTES, 'UTF-8', true);?>

</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	Birthday: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['birthday'], ENT_QUOTES, 'UTF-8', true);?>

</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	Gender: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['gender'], ENT_QUOTES, 'UTF-8', true);?>

</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	Record1: <BR><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['main_record'], ENT_QUOTES, 'UTF-8', true);?>

</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	Record2: <BR><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['sub_record'], ENT_QUOTES, 'UTF-8', true);?>

</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	URL: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['kiji_link'], ENT_QUOTES, 'UTF-8', true);?>

</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['post'], ENT_QUOTES, 'UTF-8', true);?>
<BR>
	<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['jyusyo'], ENT_QUOTES, 'UTF-8', true);?>

</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:10px 0 0 0;">
	Regist: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['regist_time'], ENT_QUOTES, 'UTF-8', true);?>
<BR>
	Update: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['update_time'], ENT_QUOTES, 'UTF-8', true);?>

</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin:20px 0 0 0;">
<div  class="input_error"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['done'], ENT_QUOTES, 'UTF-8', true);?>
</div>
</div>

<form action="" method="post" name="frm_admin_artist_detail">
<input type=hidden name="text_name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['kanji_sei'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['kanji_mei'], ENT_QUOTES, 'UTF-8', true);?>
">
<input type=hidden name="text_mailaddress" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['mailaddress'], ENT_QUOTES, 'UTF-8', true);?>
">
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
<?php }
}
