<?php

require_once('../lib/base.php');
require_once(LIB_DIR . 'FileController.php');

deleteLog($argv, COMMENT_LOG_DIR);		// コメント登録ログを削除
deleteLog($argv, TOPIC_LOG_DIR);		// トピック登録ログを削除

exit;


function deleteLog($argv, $rootDir){
	if(isset($argv[1]) && strlen_mb($argv[1]) == 6){
		// ユーザが日付を指定した場合
		$targetDate = $argv[1];
	} else {
		// ユーザが日付を指定しなかった場合
		// 実行日の日にち
		$todayDate = date('Ymd');

		// 4か月前以前のログを削除
		$minusMonth = 4;
		$targetDate = computeDate($todayDate, $minusMonth);
	}

	$cnt = 0;
	while(1){
		// 削除対象月を特定
		$targetDate = computeDate($targetDate, $cnt);

		// 削除対象ディレクトリを指定
		$dir = $rootDir . '/' . $targetDate . '/';

		if(is_dir($dir)){
			// ディレクトリ削除
			deleteDir($dir);
		} else {
			break;
		}

		$cnt++;
	}
	
	return;
}

// 過去の年月を算出
function computeDate($date, $num){
	return = date('Ym', strtotime($date . " -" . $num . " month"));
}

// ディレクトリ削除メソッド
function deleteDir($targetDir){
	$strDir = opendir($targetDir);
	while($strFile = readdir($strDir)){
		if($strFile != '.' && $strFile != '..'){  //ディレクトリでない場合のみ
			unlink($targetDir . '/' . $strFile);
		}
	}
	rmdir($targetDir);

	return;
}

?>