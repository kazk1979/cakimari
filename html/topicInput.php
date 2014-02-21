<?php
require_once('../lib/base.php');
require_once(LIB_DIR . 'Topic.php');
require_once(LIB_DIR . 'Dao.php');
require_once(LIB_DIR . 'Io.php');
require_once(LIB_DIR . 'Logger.php');

// クラスオブジェクト
$dao = new Dao();
$topicObj = new Topic($dao);
$ioObj = new Io();

$regRet = array();
$assignData = array();
if(isset($_POST['mode']) && $_POST['mode'] == 'w'){
	// 書き込み情報取得
	$topic = isset($_POST['topic']) ? trim($_POST['topic']) : '';
	$topic_explanation = isset($_POST['topic_explanation']) ? trim($_POST['topic_explanation']) : '';
	$url = isset($_POST['url']) ? trim($_POST['url']) : '';

	if($topic == '' || mb_strlen($topic, 'UTF-8') > 30){
		$regRet[] = $topicObj::TOPIC_LENGTH_ERROR;
	}

	if(mb_strlen($topic_explanation, 'UTF-8') > 200){
		$regRet[] = $topicObj::TOPIC_EX_LENGTH_ERROR;
	}

	if(mb_strlen($url, 'UTF-8') > 200){
		$regRet[] = $topicObj::URL_LENGTH_ERROR;
	}

	if($url != '' && !preg_match('/^(http|https):\/\//', $url)) {
		$regRet[] = $topicObj::URL_PROTOCOL_ERROR;
	}

	// 書き込み
	if(empty($regRet)){
		$regRet[] = $topicObj->resisterTopic($topic, $url, $topic_explanation);
	}

	// 書き込みに成功したら完了画面表示（ただし、JSで一瞬でwindow.close()する)
	if(isset($regRet[0]) && $regRet[0] === $topicObj::NO_ERROR){
		// ログを吐く
		$topicId = $topicObj->getTopicIdByTopic($topic);
		if(!empty($topicId)){
			// ログ
			$logInfo = array(
				'topic_id' => $topicObj->getInsertId(),
				'topic' => $topic,
				'explanation' => $topic_explanation,
				'url' => $url
			);
			
			$loggerObj = new Logger();
			$loggerObj->writeLog($logInfo, LOG_TYPE_TOPIC_REG);
		}

		$ioObj->display('topicComp.tmpl', array());
		exit;
	}
}

// エラーの場合、その種類をここでassign
$assignData['errorList'] = $regRet;

// 画面表示
$ioObj->display('topicInput.tmpl', $assignData);

?>