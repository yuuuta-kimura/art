<?php
/* Smarty version 3.1.30, created on 2017-02-17 04:00:34
  from "/Applications/MAMP/htdocs/kaisya/art/admin/templates/template.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58a6675235a624_54441462',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0280482db0e86e162438853c2bc4083c478c4892' => 
    array (
      0 => '/Applications/MAMP/htdocs/kaisya/art/admin/templates/template.tpl',
      1 => 1487040680,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a6675235a624_54441462 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<title>eART for artist</title>
<meta name="keywords" content="">
<meta name="discription" content="">

<link href="./bootstrap.css" rel="stylesheet" type="text/css">
<link href="./<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['css_file']->value, ENT_QUOTES, 'UTF-8', true);?>
" rel="stylesheet" type="text/css">

<?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/bootstrap.min.js"><?php echo '</script'; ?>
>

<?php $_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['head_tpl']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>



</head>

<body>


<header>
 <?php $_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['header_tpl']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

</header>

<div id="temp_body">
	<?php $_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['body_tpl']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('params'=>$_smarty_tpl->tpl_vars['params']->value), 0, true);
?>

</div>

<footer>
    <?php $_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['footer_tpl']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

</footer>


</body>
</html>
<?php }
}
