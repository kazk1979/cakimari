<?php
require_once('base.php');
require_once(LIB_DIR . 'Dao.php');

class Topic {
	const NO_ERROR = 0;					// 正常終了
	const DB_ERROR = 1;					// DBエラー
	const TOPIC_EXIST_ERROR = 2;		// データが存在するエラー
	const TOPIC_LENGTH_ERROR = 3;		// トピックの文字の長さエラー
	const TOPIC_EX_LENGTH_ERROR = 4;	// トピックの説明の文字の長さエラー
	const URL_LENGTH_ERROR = 5;			// URLの文字の長さエラー
	const URL_PROTOCOL_ERROR = 6;		// URLのプロトコルエラー

	private $dao = '';
	private $topic_insert_id = 0;

	function __construct($dao=''){
		$this->dao = $dao;
	}

	public function getTopicList($keyWord="", $page){
		$dao = $this->dao;
		$keyWord = $dao->getEscapeVal($keyWord);
		$page =  $dao->getEscapeVal($page);

		$sql  = "SELECT ";
		$sql .= "  *";
		$sql .= " FROM";
		$sql .= "  topic_tbl";
		$sql .= " WHERE";
		$sql .= "  disp_flg = 1";
		if($keyWord != ""){
			$sql .= " AND ";
			$sql .= " topic LIKE '%" . $keyWord . "%'";
		}
		$sql .= ' ORDER BY update_date DESC';

		if($page < 1) $page = 1;
		$startNum = ($page - 1) * TOPIC_NUM;
		$sql .= ' LIMIT ' . $startNum . ',' . TOPIC_NUM;

		$sql .= ";";

		return $dao->selectDataCustomSql($sql);
	}

	public function getTopicNum($keyWord=""){
		$dao = $this->dao;
		$keyWord = $dao->getEscapeVal($keyWord);

		$sql  = "SELECT ";
		$sql .= "  count(*) AS count";
		$sql .= " FROM";
		$sql .= "  topic_tbl";
		$sql .= " WHERE";
		$sql .= "  disp_flg = 1";
		if($keyWord != ""){
			$sql .= " AND ";
			$sql .= " topic LIKE '%" . $keyWord . "%'";
		}

		$sql .= ";";

		$res = $dao->selectDataCustomSql($sql);
		
		if (isset($res[0]['count'])) {
			$cnt = $res[0]['count'];
		} else {
			$cnt = 0;
		}

		return $cnt;
	}

	public function getTopicIdByTopic($topic){
		$dao = $this->dao;

		$topicTable = 'topic_tbl';
		$whereArray['topic'] = $topic;

		$topic_info = $dao->selectData($topicTable, $whereArray);
		if(empty($topic_info) || $topic_info === false){
			// 該当するトピックがない場合は空を返す
			$ret = '';
		} else {
			$ret = $topic_info[0];
		}

		return $ret;
	}

	public function getTopicInfoByTopicId($topic_id){
		$dao = $this->dao;

		$topicTable = 'topic_tbl';
		$whereArray['disp_flg'] = 1;
		$whereArray['topic_id'] = $topic_id;
		$topic_info = $dao->selectData($topicTable, $whereArray);

		if(empty($topic_info)){
			// 該当するトピックがない場合は空を返す
			$ret = '';
		} else {
			$ret = $topic_info[0];
		}

		return $ret;
	}

	public function resisterTopic($topic, $url, $topic_explanation){
		/* 
		 テーブルにロックかけてない。
		 ので、同時に複数から同じトピックを登録された場合、
		 ふつーに同じトピックが２つできてしまう。
		 小規模サイトで↑は起こらないと思うから対策してないけど、
		 もしサイトが大きくなるとちゃんとロックかけた方が良いかも
		 */

		$dao = $this->dao;
		$table = "topic_tbl";

		// そもそも登録するトピックが指定されていない
		if(empty($topic)) return self::TOPIC_LENGTH_ERROR;

		// 同名のトピックが登録されていないかチェック
		$data = array(
			"topic" => $topic,
			"disp_flg" => 1
		);

		$countRes = $dao->countData($table, $data);
		if($countRes === false){
			// DBエラー
			$ret = self::DB_ERROR;
		} elseif($countRes > 0){
			// トピック登録済み
			$ret = self::TOPIC_EXIST_ERROR;
		} else {
			// データ挿入OK
			$ret = self::NO_ERROR;
		}

		// データを挿入
		$insert_id = "";
		if($ret == self::NO_ERROR){
			$currentTime = date("Y-m-d H:i:s");
			$data['url'] = $url;
			$data['explanation'] = $topic_explanation;
			$data['create_date'] = $currentTime;
			$data['update_date'] = $currentTime;

			$insert_id = $dao->insertData($table, $data);

			// DBエラー
			if($insert_id === false) $ret = self::DB_ERROR;
		}

		// コメントテーブルに登録したデータのIDをセット
		$this->topic_insert_id = $insert_id;

		return $ret;
	}

	// 最後にDBに挿入したデータのIDを取得
	public function getInsertId(){
		return $this->topic_insert_id;
	}
}
?>