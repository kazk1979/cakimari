<?php /* Smarty version Smarty-3.1.12, created on 2014-03-13 20:53:29
         compiled from "/Applications/XAMPP/htdocs/aws/cakimari/tmpl/topicInput.tmpl" */ ?>
<?php /*%%SmartyHeaderCode:159441832553219c39ba1621-71710357%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dfd930e640374028b0d358d3d98254c28861b25d' => 
    array (
      0 => '/Applications/XAMPP/htdocs/aws/cakimari/tmpl/topicInput.tmpl',
      1 => 1393051984,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '159441832553219c39ba1621-71710357',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
    'errorType' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_53219c39d21af1_03487131',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53219c39d21af1_03487131')) {function content_53219c39d21af1_03487131($_smarty_tpl) {?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Comment Vision トピック登録</title>
<meta name="robots" content="noindex,nofollow">
</head>
<body>
<?php  $_smarty_tpl->tpl_vars['errorType'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['errorType']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['errorList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['errorType']->key => $_smarty_tpl->tpl_vars['errorType']->value){
$_smarty_tpl->tpl_vars['errorType']->_loop = true;
?>
<?php if ($_smarty_tpl->tpl_vars['errorType']->value==1){?>
<font color="red">登録に失敗してしまいました。。もう一度お願いします。。</font><br />
<?php }elseif($_smarty_tpl->tpl_vars['errorType']->value==2){?>
<font color="red">そのトピックはもう登録されちゃってます</font><br />
<?php }elseif($_smarty_tpl->tpl_vars['errorType']->value==3){?>
<font color="red">トピックは1文字〜30文字を入力して下さい</font><br />
<?php }elseif($_smarty_tpl->tpl_vars['errorType']->value==4){?>
<font color="red">トピックの説明は200文字以下で入力して下さい</font><br />
<?php }elseif($_smarty_tpl->tpl_vars['errorType']->value==5){?>
<font color="red">URLは200文字以下で入力して下さい</font><br />
<?php }elseif($_smarty_tpl->tpl_vars['errorType']->value==6){?>
<font color="red">URLはhttp://またはhttps://から入力してください</font><br />
<?php }?>
<?php } ?>
<br />
<form name="form1" method="POST" action="topicInput.php">
<input type="hidden" name="mode" value="w">
<span style="color: red"; ><b>【必須】</b></span> トピック  (最大30文字)<br />
<input type="text" name="topic" size="30" maxlength="30"><br /><br />
トピックの説明  (最大200文字)<br />
<textarea name="topic_explanation" rows="5" cols="45"></textarea><br /><br />
URL (最大200文字)<br />
<div style="font-size: 0.8em">※<font color="red"><b>http://</b></font>または<font color="red"><b>https://</b></font>から入力してください</div>
<input type="text" name="url" size="50" maxlength="200"><br /><br />
<input type="button" onclick="window.close(); return false;" value="閉じる">
　<input type="button" onclick="return send()" value="送信">
</form>

<script type="text/javascript">
<!--

window.onload = function(){
	document.form1.topic.focus();
}
function send(){
	document.form1.submit();
	return false;
}
// -->
</script>
</body>
</html><?php }} ?>