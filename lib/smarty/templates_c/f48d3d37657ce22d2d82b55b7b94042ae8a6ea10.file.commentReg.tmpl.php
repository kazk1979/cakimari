<?php /* Smarty version Smarty-3.1.12, created on 2014-03-16 10:17:33
         compiled from "/Applications/XAMPP/htdocs/aws/cakimari/tmpl/commentReg.tmpl" */ ?>
<?php /*%%SmartyHeaderCode:8556541225321a364d1f3c0-89172642%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f48d3d37657ce22d2d82b55b7b94042ae8a6ea10' => 
    array (
      0 => '/Applications/XAMPP/htdocs/aws/cakimari/tmpl/commentReg.tmpl',
      1 => 1394932606,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8556541225321a364d1f3c0-89172642',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5321a364e92249_63566994',
  'variables' => 
  array (
    'data' => 0,
    'errorMsg' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5321a364e92249_63566994')) {function content_5321a364e92249_63566994($_smarty_tpl) {?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Comment Vision コメント登録</title>
<meta name="robots" content="noindex,nofollow">
</head>
<body>
<?php if ($_smarty_tpl->tpl_vars['data']->value['comForbidStatus']==1){?>
	<font color='red'>エラーが発生しました。もう一度投稿して下さい。</font><br>
<?php }elseif($_smarty_tpl->tpl_vars['data']->value['comForbidStatus']==2){?>
	<font color='red'>誰かがもうコメント書いちゃってます。</font><br>
<?php }else{ ?>
<?php  $_smarty_tpl->tpl_vars['errorMsg'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['errorMsg']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['regErrorList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['errorMsg']->key => $_smarty_tpl->tpl_vars['errorMsg']->value){
$_smarty_tpl->tpl_vars['errorMsg']->_loop = true;
?>
	<font color='red'><?php echo $_smarty_tpl->tpl_vars['errorMsg']->value;?>
</font><br>
<?php } ?>
<font color='red' id="jserror"></font><br>
<br>
<form name="form1" method="POST" action="commentReg.php">
	<input type="hidden" name="mode" value="w">
	<input type="hidden" name="topic_id" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['topic_id'];?>
">
	<input type="hidden" name="comment_id" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['comment_id'];?>
">
	<span style="color: red"; ><b>【必須】</b></span> コメント (最大50文字)<br>
	<textarea name="comment" id="comment_area" rows="3" cols="20"  onkeydown="go();"></textarea><br><br>
	名前 (最大10文字)<br>
	<input name="name" id="name_area"type="text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
" maxlength="10" size="15"><br><br>
	<input type="button" onclick="return send()" value="送信">
</form>
<?php }?>
<script type="text/javascript">
<!--
window.onload = function(){
	document.form1.comment.focus();
}

function go(){
	//EnterキーならSubmit
	if(window.event.keyCode==13) send();
	return false;
}

function send(){
	$com_length = document.getElementById('comment_area').value.length;
	$name_length = document.getElementById('name_area').value.length;
	if($com_length < 1 || $com_length > 50){
		document.getElementById('jserror').innerHTML = "コメントが未入力か文字数がオーバーしています";
	}else if($name_length > 10){
		document.getElementById('jserror').innerHTML = "名前の文字数がオーバーしています";
	} else {
		document.form1.submit();
	}
	return false;

}
// -->
</script>
</body>
</html><?php }} ?>