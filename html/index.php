<?php
require_once('../lib/base.php');
require_once(LIB_DIR . 'Dao.php');
require_once(LIB_DIR . 'Topic.php');
require_once(LIB_DIR . 'Pager.php');
require_once(LIB_DIR . 'Io.php');

// クラスオブジェクト
$dao = new Dao();
$topicObj = new Topic($dao);
$ioObj = new Io();

// トピック一覧取得
if(isset($_REQUEST['searchType']) && $_REQUEST['searchType'] !== '' &&
	isset($_REQUEST['topicSearch']) && $_REQUEST['topicSearch'] !== ""){
	$searchType = $_REQUEST['searchType'];
	$keyWord = $_REQUEST['topicSearch'];
} else {
	$searchType = '';
	$keyWord = '';
}

// トピック検索キーワードがデフォルト文字列の場合は空とみなす
if ($keyWord == DEFAULT_TOPIC_SEARCH) $keyWord = '';

$assignList['defaultTopicSearch'] = DEFAULT_TOPIC_SEARCH;
$assignList['topicSearch'] = $keyWord;

// リクエストパラメータのトピックID
$reqTopicId = '';
if(isset($_REQUEST['topic_id'])){
	$reqTopicId = $_REQUEST['topic_id'];
}

if(isset($_REQUEST['page']) && $_REQUEST['page'] > 0){
	$currentPage = $_REQUEST['page'];
} else {
	$currentPage = 1;
}

// トピック総数取得
$totalTopicNum = $topicObj->getTopicNum($keyWord);
$assignList['totalTopicNum'] = $totalTopicNum;

$pager = new Pager($currentPage, $totalTopicNum, TOPIC_NUM);
$assignList['pageInfo'] = $pager->getPageInfo();

// 1ページあたりに表示されるトピックリストを取得
$topicList = $topicObj->getTopicList($keyWord, $currentPage);
$assignList['topicList'] = $topicList;

// コメント一覧取得用のトピックID取得(コメント一覧はajaxで取得)
if(isset($topicList[0]['topic_id']) && $topicList[0]['topic_id'] !== ''){
	// トピック一覧が取得できた
	$firstTopicId = $topicList[0]['topic_id'];
	// リクエストパラメータのトピックIDとトピックリストの先頭IDのどちらを優先するか
	if($searchType == 1){
		// トピック検索タイプ1
		$topicId = $firstTopicId;
	} elseif($searchType == 2){
		// トピック検索タイプ2
		$topicId = $reqTopicId; 
	} else {
		// トピック検索ではない
		if($reqTopicId !== ''){
			// トピックIDが指定されている
			$topicId = $reqTopicId; 
		} else {
			// トピックIDが指定されていない
			$topicId = $firstTopicId;
		}
	}
} else {
	// トピック一覧が取得できなかった
	$topicId = '';
}
$assignList['topic_id'] = $topicId;

// トピック情報取得
//$assignList['topicInfo'] = $topicObj->getTopicInfoByTopicId($topicId);
$topicInfo = $topicObj->getTopicInfoByTopicId($topicId);

$assignList['topicName']        = isset($topicInfo['topic']) ? $topicInfo['topic'] : '';
$assignList['topicExplanation'] = isset($topicInfo['explanation']) ? $topicInfo['explanation'] : '';
$assignList['topicUrl']         = isset($topicInfo['url']) ? $topicInfo['url'] : '';

// デフォルトコメント文字列
$assignList['default_comment'] = DEFAULT_COMMENT;

// 画面表示
$ioObj->display('index.tmpl', $assignList);

?>