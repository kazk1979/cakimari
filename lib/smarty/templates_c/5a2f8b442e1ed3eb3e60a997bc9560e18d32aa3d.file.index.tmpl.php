<?php /* Smarty version Smarty-3.1.12, created on 2014-03-18 21:56:44
         compiled from "/Applications/XAMPP/htdocs/aws/cakimari/tmpl/index.tmpl" */ ?>
<?php /*%%SmartyHeaderCode:474890861532055dc021c27-77243012%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5a2f8b442e1ed3eb3e60a997bc9560e18d32aa3d' => 
    array (
      0 => '/Applications/XAMPP/htdocs/aws/cakimari/tmpl/index.tmpl',
      1 => 1395147382,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '474890861532055dc021c27-77243012',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_532055dc4291e1_37952939',
  'variables' => 
  array (
    'data' => 0,
    'topicInfo' => 0,
    'pageNum' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_532055dc4291e1_37952939')) {function content_532055dc4291e1_37952939($_smarty_tpl) {?><?php echo '<?xml';?> version="1.0" encoding="UTF-8" <?php echo '?>';?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="imagetoolbar" content="no" />
<meta name="description" content="時事ネタから近所のうわさ話まで、なんでも書いちゃおう！" />
<meta name="Keywords" content="掲示板" />
<title><?php if ($_smarty_tpl->tpl_vars['data']->value['topicName']!=''){?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['topicName'], ENT_QUOTES, 'UTF-8', true);?>
-<?php }?>CAKIMARI</title>
<link rel="shortcut icon" href="cmn/img/favicon.ico" />
<link href="cmn/css/layout.css" rel="stylesheet" type="text/css" media="all" />
<link href="cmn/css/contents.css" rel="stylesheet"  />
<link rel="stylesheet" href="cmn/css/style1.css" type="text/css" id="jstyle" />
<script language="javascript" type="text/javascript" src="cmn/js/jquery-1.8.3.min.js"></script>
<script language="javascript" type="text/javascript" src="cmn/js/jquery.cookie.js"></script>
<script language="javascript" type="text/javascript" src="cmn/js/jquery.formtips.1.2.6.min.js"></script>
<script language="javascript" type="text/javascript" src="cmn/js/common.js"></script>
<script type="text/javascript" src="cmn/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="cmn/js/fancybox/jquery.easing-1.3.pack.js"></script>
<link rel="stylesheet" type="text/css" href="cmn/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
</head>
<body>
<div id="Body">
	<!--▼▼ヘッダ▼▼-->
	<div id="Header">
		<p><a href="index.php"><img src="cmn/img/logo.gif" width="235" height="28" alt="cakimari" /></a>&nbsp;かんたん書き込み リアルタイムビューBBS</p>
		<dl>
			<dt>カラー選択</dt>
			<dd>
				<ul>
					<li class="Gray"><a onclick="jstyle('cmn/css/style1.css')">グレー</a></li>
					<li class="Black"><a onclick="jstyle('cmn/css/style2.css')">ブラック</a></li>
					<li class="White"><a onclick="jstyle('cmn/css/style3.css')">ホワイト</a></li>
				</ul>
			</dd>
		</dl>
	</div>
	<!--▲▲ヘッダ▲▲-->
	<!--▼▼コンテンツ▼▼-->
	<div id="Contents" class="clearfix">
		<!--▼左-->
		<div id="C_Left">
			<!--▽-->
			<div id="L_Text">
				<h1><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['topicName'], ENT_QUOTES, 'UTF-8', true);?>
</h1>
				<p><?php echo htmlspecialchars(mb_strimwidth(htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['topicExplanation'], ENT_QUOTES, 'UTF-8', true),0,200,'…'), ENT_QUOTES, 'UTF-8', true);?>
</p>
				<?php if ($_smarty_tpl->tpl_vars['data']->value['topicUrl']!=''){?><p><a href="javascript:void(0)" onclick="openSourcePage('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['topicUrl'], ENT_QUOTES, 'UTF-8', true);?>
')"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['topicUrl'], ENT_QUOTES, 'UTF-8', true);?>
</a></p><?php }?>
			</div>
			<!--△-->
			<?php if ($_smarty_tpl->tpl_vars['data']->value['totalTopicNum']==0){?>
			<font color='red' id="commentError">一致するトピックは見つかりませんでした</font><br>
			<p><a href="index.php">&lt;&lt;TOP</a></p>
			<?php }?>
			<br>
			<?php if ($_smarty_tpl->tpl_vars['data']->value['totalTopicNum']!=0){?>
			<form action="commentReg.php" method="post" id="Contribute">
				<input type="hidden" name="mode" value="w">
				<input type="hidden" name="topic_id" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['topic_id'];?>
" />
				<input name="comment" title="<?php echo $_smarty_tpl->tpl_vars['data']->value['default_comment'];?>
" type="text" class="Text" id="com_textarea" />
				<span class="Submit"><a href="javascript:void(0)" onclick="sendCommentNoRand(this);return false;"><img src="cmn/img/contribute.gif" /></a></span>
			</form>
			<table id="Cakimarispace">
				<tr>
					<td id="com11" class="comment">&nbsp;</td>
					<td id="com12" class="comment">&nbsp;</td>
					<td id="com13" class="comment">&nbsp;</td>
				</tr>
				<tr>
					<td id="com21" class="comment">&nbsp;</td>
					<td id="com22" class="comment">&nbsp;</td>
					<td id="com23" class="comment">&nbsp;</td>
				</tr>
				<tr>
					<td id="com31" class="comment">&nbsp;</td>
					<td id="com32" class="comment">&nbsp;</td>
					<td id="com33" class="comment">&nbsp;</td>
				</tr>
				<tr>
					<td id="com41" class="comment">&nbsp;</td>
					<td id="com42" class="comment">&nbsp;</td>
					<td id="com43" class="comment">&nbsp;</td>
				</tr>
				<tr>
					<td id="com51" class="comment">&nbsp;</td>
					<td id="com52" class="comment">&nbsp;</td>
					<td id="com53" class="comment">&nbsp;</td>
				</tr>
				<tr>
					<td id="com61" class="comment">&nbsp;</td>
					<td id="com62" class="comment">&nbsp;</td>
					<td id="com63" class="comment">&nbsp;</td>
				</tr>
			</table>
			<!--▽AD--
			<ul id="Left_AD">
				<li><img src="cmn/img/ad02.gif" width="700" height="133" alt="" /></li>
				<li><img src="cmn/img/ad02.gif" width="700" height="133" alt="" /></li>
				<li><img src="cmn/img/ad02.gif" width="700" height="133" alt="" /></li>
			</ul>
			<!--△AD-->
			<?php }?>
		</div>
		<!--▲左-->
		<!--▼右-->
		<div id="C_Right">
			<!--▽AD--
			<ul id="Right_AD">
				<li><img src="cmn/img/ad01.jpg" width="420" height="289" alt="" /></li>
			</ul>
			<!--△AD-->
			<form action="index.php" method="post" id="Search">
				<input type="hidden" name="searchType" value="1" />
				<input name="topicSearch" title="<?php echo $_smarty_tpl->tpl_vars['data']->value['defaultTopicSearch'];?>
" type="text" size="30" class="Text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['topicSearch'];?>
" />
				<input type="image" src="cmn/img/search.gif" name="Submit" value="検索" title="検索" class="Submit" />
			</form>
			<!--▽板リスト-->
			<div class="R_List">
				<ul>
				<?php  $_smarty_tpl->tpl_vars['topicInfo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['topicInfo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['topicList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['topicInfo']->key => $_smarty_tpl->tpl_vars['topicInfo']->value){
$_smarty_tpl->tpl_vars['topicInfo']->_loop = true;
?>
				<?php if ($_smarty_tpl->tpl_vars['topicInfo']->value['topic_id']==$_smarty_tpl->tpl_vars['data']->value['topic_id']){?>
					<li><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['topicInfo']->value['topic'], ENT_QUOTES, 'UTF-8', true);?>
 (<?php echo $_smarty_tpl->tpl_vars['topicInfo']->value['comment_cnt'];?>
)</li>
				<?php }else{ ?>
					<li><a href="javascript:void(0)" onclick="changeCommentArea('<?php echo $_smarty_tpl->tpl_vars['topicInfo']->value['topic_id'];?>
', '<?php echo $_smarty_tpl->tpl_vars['data']->value['pageInfo']['currentPage'];?>
', '<?php echo $_smarty_tpl->tpl_vars['data']->value['topicSearch'];?>
');return false;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['topicInfo']->value['topic'], ENT_QUOTES, 'UTF-8', true);?>
</a> (<?php echo $_smarty_tpl->tpl_vars['topicInfo']->value['comment_cnt'];?>
)</li>
				<?php }?>
				<?php } ?>
				</ul>
				<p><?php if ($_smarty_tpl->tpl_vars['data']->value['pageInfo']['hasFirstPageNaviFlg']===true){?><a href="index.php?page=1">&lt;</a><?php }?>
				<?php  $_smarty_tpl->tpl_vars['pageNum'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pageNum']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value['pageInfo']['pageList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pageNum']->key => $_smarty_tpl->tpl_vars['pageNum']->value){
$_smarty_tpl->tpl_vars['pageNum']->_loop = true;
?>
				<?php if ($_smarty_tpl->tpl_vars['pageNum']->value==$_smarty_tpl->tpl_vars['data']->value['pageInfo']['currentPage']){?>
				<strong><?php echo $_smarty_tpl->tpl_vars['pageNum']->value;?>
</strong>
				<?php }else{ ?>
				<a href="index.php?page=<?php echo $_smarty_tpl->tpl_vars['pageNum']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['pageNum']->value;?>
</a>
				<?php }?>
				<?php } ?>
				<?php if ($_smarty_tpl->tpl_vars['data']->value['pageInfo']['hasLastPageNaviFlg']===true){?>
				<a href="index.php?page=<?php echo $_smarty_tpl->tpl_vars['data']->value['pageInfo']['totalPageNum'];?>
">&gt;</a>
				<?php }?></p>
				<p><a href="topicInput.php" class="new_window">トピックを作る</a></p>
			</div>
			<!--△板リスト-->
		</div>
		<!--▲右-->
		<!--▼フッタ-->
		<div id="Footer" class="clearfix">
			<p>Copyright(c) Cakimari All rights reserved.</p>
			<ul><!--
				--><li><a href="about.php" class="new_window">かきまりについて</a></li><!--
				<!--<li><a href="#">プライバシーと利用規約</a></li>
				<li><a href="#">広告</a></li>-->
			</ul>
		</div>
		<!--▲フッタ-->
	</div>
	<!--▲▲コンテンツ▲▲-->
</div>

<script type="text/javascript" language="javascript">
<!--
function getDatalist(){
	$.ajax({
		url: 'commentGet.php?date='+(new Date().getTime())+'&topic_id=<?php echo $_smarty_tpl->tpl_vars['data']->value['topic_id'];?>
',
		dataType: 'json',
		success : function(data){
			for(var i=0;i<=(data.length-1);i++){
				var commentElement = document.getElementById(data[i]['commentId']);
				if(commentElement == '') continue;

				var commentId = '#'+data[i]['commentId'];
				var topicId = '<?php echo $_smarty_tpl->tpl_vars['data']->value['topic_id'];?>
';
				if(topicId !== '' && data[i]['comment'] == ''){
					commentElement.innerHTML = '';
					$(commentId).css("cursor", "pointer");
				} else {
					$(commentId).css("cursor", "default");
					commentElement.innerHTML = data[i]['comment'];
					$(commentId).css("color", data[i]['fontColor']);
					$(commentId).addClass(data[i]['class']);
					$(commentId).attr("title", data[i]['name']);
				}
			}
		}
	})
}

$(document).ready( function() {
	$(".comment").live("hover", function(){
		$(this).fancybox({
			'href': 'commentReg.php?topic_id=<?php echo $_smarty_tpl->tpl_vars['data']->value['topic_id'];?>
&comment_id='+this.id,
			'width': 740,
			'height': 450,
			'padding': 0,
			'overlayOpacity': 0.6,
			'overlayColor': '#000',
			'type': 'iframe'
		});
	});

	$(".new_window").fancybox({
		'width': 740,
		'height': 450,
		'padding': 0,
		'overlayOpacity': 0.6,
		'overlayColor': '#000',
		'type': 'iframe'
	});

	getDatalist();
	setInterval(function(){
        getDatalist();
  },5000);
});

function openSourcePage(url){
	if(window.confirm(url+'へ遷移しようとしています')){
		w = screen.availWidth/2;
		h = screen.availHeight;

		window.open(url, '_blank', 'width='+w+', height='+h);

	}
}

function sendCommentNoRand(){
	var text_len = document.getElementById("com_textarea").value.length;

	if(text_len < 1 || text_len > 50){
		document.getElementById('commentError').innerHTML = "コメントが未入力か文字数がオーバーしています";
	} else {
		document.getElementById("Contribute").submit();
	}
}

function changeCommentArea(topic_id, page, keyWord){
	var loc = "index.php?topic_id="+topic_id;
	if(page != '')    loc += "&page="+page;
	if(keyWord != '') loc += "&searchType=2&topicSearch="+keyWord;
	location.href = loc;
}
// -->
</script>
</body>
</html>
<?php }} ?>