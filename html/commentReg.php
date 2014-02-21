<?php
require_once('../lib/base.php');
require_once(LIB_DIR . 'Dao.php');
require_once(LIB_DIR . 'Io.php');
require_once(LIB_DIR . 'Comment.php');
require_once(LIB_DIR . 'Logger.php');

$ioObj = new Io();

$topicId = isset($_REQUEST['topic_id']) ? $_REQUEST['topic_id'] : '';
$commentId = isset($_REQUEST['comment_id']) ? $_REQUEST['comment_id'] : '';

// パラメータ不正エラー
if($topicId == ''){
	// 必須パラメータエラー
	$assignList['comForbidStatus'] = 1;
} else {
	$assignList['comForbidStatus'] = 0;
}

// テンプレートファイル
$tmpl = 'commentReg.tmpl';

// cookieに保持するニックネーム
$cookieNickName = '';

// コメントIDが指定されていない場合はランダム投稿と見なす
$randFlg = 0;
if($commentId == ''){
	$randFlg = 1;
}

// コメント書き込み
$regErrorList = array();
if($assignList['comForbidStatus'] == 0){
	$dao = new Dao();
	$commentObj = new Comment($dao);

	if(isset($_POST['mode']) && $_POST['mode'] == 'w'){
		// コメント書きこみ
		$comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
		if(isset($_POST['name']) && $_POST['name'] != ''){
			$name = trim($_POST['name']);
		} else {
			$name = '';
		}

		// デフォルトコメントがそのまま飛んできた場合は削除
		if ($comment == DEFAULT_COMMENT) $comment = '';

		// 入力値のエラーチェック
		$regError = 0;
		if($comment == '' || mb_strlen($comment, 'UTF-8') > 50){
			$regErrorList[] = 'コメントは1文字〜50文字を入力して下さい';
			$regError = 1;

			if((mb_strlen($name, 'UTF-8') >= 1) && (mb_strlen($name, 'UTF-8') <= 10)){
				// ランダム投稿でない場合、ニックネームをcookieに設定
				if($randFlg == 0){
					setcookie("commentvision_nname", $name, time()+60*60*24*7);
					$cookieNickName = $name;
				}
			}
		}

		if (mb_strlen($name, 'UTF-8') > 10){
			$regErrorList[] = '名前は0文字〜10文字を入力して下さい';
			$regError = 1;
		} else {
			// ランダム投稿でない場合、ニックネームをcookieに設定
			if($randFlg == 0){
				setcookie("commentvision_nname", $name, time()+60*60*24*7);
				$cookieNickName = $name;
			}
		}
		
		if($regError == 0){
			// コメントフォント色
			$rand = rand(0, 9);
			if($rand == 7){
				$fontColor = "red";
			} elseif($rand == 8){
				$fontColor = "blue";
			} elseif($rand == 9){
				$fontColor = "green";
			} else {
				$fontColor = "black";
			}

/*
			if($name == '') {
				$name = 'NOBODY';
			}
*/

			if($randFlg == 1){
				// コメントをランダムに表示させる場合
				$max_cnt = 20;  // コメント欄が他ユーザに取られた場合、最大20回別の欄を探しに行く
				$name = '';
				for($i = 0; $i < $max_cnt; $i++){
					$commentId = $commentObj->getBlankCommentIdAtRandom($topicId);
					$registRes = $commentObj->registerComment($topicId, $commentId, $comment, $name, $fontColor);

					if($registRes !== false){
						break;
					}
				}
			} else {
				// コメント表示欄が指定されている場合
				$registRes = $commentObj->registerComment($topicId, $commentId, $comment, $name, $fontColor);
			}

			if($registRes === false){
				$regErrorList[] = 'コメントの投稿に失敗しました';
			} else {
				// ログを吐く
				$logInfo = array(
					'comment_id' => $commentObj->getInsertId(),
					'topic_id' => $topicId,
					'comment' => $comment,
					'name' => $name,
					'font_color' => $fontColor
				);
				
				$loggerObj = new Logger();
				$loggerObj->writeLog($logInfo, LOG_TYPE_COMMENT_REG);

				// ランダム投稿でない場合、書き込みに成功したら完了画面表示（ただし、JSで一瞬でwindow.close()する)
				if($randFlg == 0) {
					// ランダム投稿でない場合はコメント一覧画面を表示
					$tmpl = 'commentComp.tmpl';
					$ioObj->display($tmpl, $assignList);
					exit;
				}
			}
		}
	} else if(!isset($_POST['mode']) || $_POST['mode'] != 'w'){
		// 初期画面表示
		$commentExistFlg = $commentObj->checkCommentExistance($topicId, $commentId);
		if($commentExistFlg === false){
			$assignList['comForbidStatus'] = 2;
		}
	}
}

// ランダム投稿の場合は書き込みの成否にかかわらずTOP画面へリダイレクト
if($randFlg == 1){
	$url = 'index.php';
	if($topicId !== '') $url .= '?topic_id=' . $topicId;
	header('Location:' . $url);
	exit;
}

if (isset($_COOKIE['commentvision_nname']) && $cookieNickName == '') {
	$cookieNickName = $_COOKIE['commentvision_nname'];
}


// 画面表示
$assignList['name'] = $cookieNickName;
$assignList['regErrorList'] = $regErrorList;
$assignList['topic_id'] = $topicId;
$assignList['comment_id'] = $commentId;

$ioObj->display($tmpl, $assignList);
?>