<?php
require_once('../lib/base.php');
require_once(LIB_DIR . 'Dao.php');
require_once(LIB_DIR . 'Comment.php');

$topic_id = isset($_GET['topic_id']) ? $_GET['topic_id'] : '';

// 画面表示情報取得
$dispData = array();
$dao = new Dao();
$commentObj = new Comment($dao);
if($topic_id != '') $dispData = $commentObj->getCommentList($topic_id);

$i = 0;
$comList = array();
$commentIdList = array_flip($commentObj->getCommentCdList());
// 登録済みのコメント情報を設定
foreach($dispData as $dispRow){
	$commentId = $dispRow['comment_cd2'];

	if(isset($commentIdList[$commentId])){
		unset($commentIdList[$commentId]);
	
		$comList[$i]['commentId'] = HTML_COM_ID_WORD . $commentId;
		$comList[$i]['name'] = $dispRow['name'];
		$comList[$i]['fontColor'] = $dispRow['font_color'];
		
		$str = $dispRow['comment'];
		if(mb_strlen($str, 'UTF-8') > 50){
			$comList[$i]['comment'] = mb_substr($str, 0, 49, 'UTF-8') . '…';
		} else {
			$comList[$i]['comment'] = $str;
		}
		
		if (mb_strlen($str, 'UTF-8') < 6){
			$class = 'f_big';
		} else if (mb_strlen($str, 'UTF-8') < 23){
			$class = 'f_medium';
		} else {
			$class = 'f_small';
		}
		$comList[$i]['class'] = $class;

		$i++;
	}
}

foreach($commentIdList as $noUseCommentId => $value){
	$comList[$i]['commentId'] = HTML_COM_ID_WORD . $noUseCommentId;
	$comList[$i]['comment'] = '';
	$comList[$i]['name'] = '';
	$comList[$i]['fontColor'] = '';
	$comList[$i]['fontSize'] = '';
	$i++;
}

print json_encode($comList);

?>