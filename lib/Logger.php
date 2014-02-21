<?php
require_once('base.php');
require_once('FileController.php');

class Logger {
	private $commentRegLog = array(
		'topic_id',
		'comment_id',
		'comment',
		'name',
		'font_color'
	);

	private $topicRegLog = array(
		'topic_id',
		'topic',
		'explanation',
		'url'
	);
	
	private $commonLog = array(
		'date',
		'remote_addr',
		'ua'
	);

	function __construct(){
	}

	public function writeLog($logInfo, $logType){
		// 現在日付1 (例：年月(201301))
		$date1 = date('Ym');
		
		// 現在日付2 (例：日(01))
		$date2 = date('d');
		
		// 現在日付3 (例：時分秒(010101))
		$date3 = date('His');

		// 現在日時
		$logInfo['date'] = $date1 . $date2 . $date3;
		
		// ログディレクトリ指定
		if($logType == LOG_TYPE_TOPIC_REG){
			// トピック投稿
			$logDir = TOPIC_LOG_DIR;
		} else if($logType == LOG_TYPE_COMMENT_REG){
			// コメント投稿
			$logDir = COMMENT_LOG_DIR;
		} else {
			return false;
		}
		$dirPath = $this->_getLogDir($logDir, $date1);
		if($dirPath === false) return false;
		
		// ログファイルに出力するデータフォーマットを整形する
		$logStr = $this->_formatLog($logType, $logInfo);

		// ログファイルパスを指定
		$logFile = $dirPath . '/' . $date2 . '.log';
		
		// ログファイルに書き込む (書き込み失敗したときどうしようかなぁ。。)
		$fileConObj = new FileController();
		$fileConObj->writeFile($logFile, 'a', $logStr);
		
		return;
	}
	
	private function _formatLog($logType, $logInfo){
		$log = $this->_getLogParams($logType, $logInfo);

		return implode("\t", $log) . "\n";
	}
	
	private function _getLogParams($logType, $logInfo){
		$log = array();

		if($logType == LOG_TYPE_COMMENT_REG){
			$logParamList = array_merge($this->commonLog, $this->commentRegLog);
		} else {
			$logParamList = array_merge($this->commonLog, $this->topicRegLog);
		}

		foreach($logParamList as $paramName){
			if(isset($logInfo[$paramName])){
				$logInfo[$paramName] = mb_convert_encoding($logInfo[$paramName], 'UTF-8', 'auto');
				$log[$paramName] = $this->_omitWords($logInfo[$paramName]);
			} else if($paramName == 'remote_addr'){
				// クライアントIPアドレス
				$log[$paramName] = $_SERVER['REMOTE_ADDR'];
			} else if($paramName == 'ua'){
				// UA
				$log[$paramName] = $_SERVER['HTTP_USER_AGENT'];
			} else {
				$log[$paramName] = '';
			}
		}

		return $log;
	}
	
	private function _omitWords($str){
		// 改行コードとタブは取る
		return str_replace(array("\r\n","\r","\n", "\t"), '', $str);
	}
	
	private function _getLogDir($logBaseDir, $logSubDir){
		// ログのルートディレクトリを生成する
		if(!is_dir($logBaseDir)){
			if(!mkdir($logBaseDir)){
				return false;
			}
		}
		
		// ログのサブディレクトリを生成する
		$subDir = $logBaseDir . $logSubDir . '/';
		if(!is_dir($subDir)){
			if(!mkdir($subDir)){
				return false;
			}
		}
		
		return $subDir;
	}
}
?>