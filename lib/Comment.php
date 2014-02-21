<?php
require_once('base.php');
require_once(LIB_DIR . 'Dao.php');

class Comment {
	const max_comment_num = 12;
	private $dao = '';
	private $comment_insert_id = 0;

	// divタグのコメント用id一覧（数値のみ）
	private $commentCdList = array(
		'11', '12', '13',
		'21', '22', '23',
		'31', '32', '33',
		'41', '42', '43',
		'51', '52', '53',
		'61', '62', '63'
	);

	function __construct($dao=''){
		$this->dao = $dao;
	}

	public function getCommentCdList(){
		return $this->commentCdList;
	}

	public function  getCommentList($topicId=''){
		$dao = $this->dao;

		$table = "comment_tbl";
		if($topicId != '') $whereArray['topic_id'] = $topicId;

		return $dao->selectData($table, $whereArray);
	}

	public function getBlankCommentIdAtRandom($topicId) {
		if($topicId == '') return false;

		$dao = $this->dao;
		$table = 'comment_tbl';
		$where = array('topic_id' => $topicId);

		$commentList = $dao->selectData($table, $where);
		if ($commentList === false) return false;

		$blankComIdListFlip = array_flip($this->commentCdList);
		foreach($commentList as $commentInfo){
			if(isset($blankComIdListFlip[$commentInfo['comment_cd2']])){
				unset($blankComIdListFlip[$commentInfo['comment_cd2']]);
			}
		}
	
		$tmpBlankComIdList = array_flip($blankComIdListFlip);

		// 配列のindexを振りなおす
		$blankComIdList = array();
		foreach($tmpBlankComIdList as $val){
			$blankComIdList[] = $val;
		}

		$idCount = count($blankComIdList);
		$blankCommentId = '';

		if($idCount > 0){
			$index = rand(0, $idCount - 1);
			$blankCommentId = HTML_COM_ID_WORD . $blankComIdList[$index];
		}

		return $blankCommentId;
	}


	public function registerComment($topicId, $commentId, $comment, $name, $fontColor){
		if(empty($topicId) || empty($commentId) || empty($comment)) return false;

		$dao = $this->dao;
		$topicId = $dao->getEscapeVal($topicId);
		$commentId = $dao->getEscapeVal($commentId);
		$comment = $dao->getEscapeVal($comment);
		$comment = $dao->getEscapeVal($comment);
		$fontColor = $dao->getEscapeVal($fontColor);

		// SQLで使うデータ
		$commentCd = $topicId . '-' . $commentId;
		$commentCd2 = str_replace(HTML_COM_ID_WORD, '', $commentId);
		$currentTime = date("Y-m-d H:i:s");
		$commentTable = "comment_tbl";
		$topicTable = "topic_tbl";

		// トランザクション開始
		$dao->startTransaction();

		// テーブルロック（write)
		$dao->lockTables4Write(array($topicTable, $commentTable));

		// コメントがすでに入力されていないか確認する
		$commentExistFlg = $this->checkCommentExistance($topicId, $commentId);
		if($commentExistFlg === false){
			$dao->unlockTables();
			$dao->endTransaction();
			return false;
		}

		// そのトピックに登録されているコメント数を調べる
		$where = array('topic_id' => $topicId);
		$countNum = $dao->countData($commentTable, $where);
		if($countNum === false || $countNum == NULL){
			$dao->unlockTables();
			$dao->endTransaction();
			return false;
		}

		// コメント数が12個以上の場合、古いコメントをdeleteする
		if((Comment::max_comment_num -1) < $countNum){
			$limit = $countNum - (Comment::max_comment_num - 1);
			$sql =<<< SQL
SELECT
	comment_cd 
FROM
	$commentTable 
WHERE
	topic_id=$topicId 
ORDER BY 
	update_date ASC 
LIMIT $limit
SQL;

			// 投稿日時の古いコメントCDをDBから取得する
			$oldCommentIdList = $dao->selectDataCustomSql($sql);
			if($oldCommentIdList === false){
				$dao->unlockTables();
				$dao->endTransaction();
				return false;
			}

			// 古いコメントを使ってSQLのwhere区(OR)作成
			$orWhere = '';
			foreach($oldCommentIdList as $commentIdInfo){
				if(isset($commentIdInfo['comment_cd'])){
					if($orWhere != ''){
						$orWhere .= ' OR ';
					}
					$orWhere .= 'comment_cd=';
					$orWhere .= '\'' . $commentIdInfo['comment_cd'] . '\'';
				 }
			}
			
			$where = '(' . $orWhere . ')';

			// 投稿日時の古いコメントCDを削除する
			$sql = "DELETE FROM " . $commentTable . ' WHERE ' . $orWhere .';';
			$ret = $dao->deleteDataCustomSql($sql);
			if($ret === false){
				$dao->unlockTables();
				$dao->endTransaction();
				return false;
			}
		}

		// コメントをインサートする
		$data = array(
			'topic_id' => $topicId,
			'comment_cd' => $commentCd,
			'comment_cd2' => $commentCd2,
			'comment' => $comment,
			'name' => $name,
			'font_color' => $fontColor,
			'create_date' => $currentTime,
			'update_date' => $currentTime
		);
		$insert_id = $dao->insertData($commentTable, $data);
		if($insert_id === false){
			// コメントのインサートに失敗したらロールバックして、オートコミットをONに戻す
			$dao->rollback();
			$dao->endTransaction();
			$dao->unlockTables();
			return false;
		}

		// トピックの更新日を更新する
		$data = array('update_date' => $currentTime);
		$where = array('topic_id' => $topicId);
		$ret2 = $dao->updateData($topicTable, $data, $where);
		if($ret2 === false){
			// トピック更新日の更新に失敗したらロールバックして、オートコミットをONに戻す
			$dao->rollback();
			$dao->endTransaction();
			$dao->unlockTables();
			return false;
		}
		
		// コメント数を1増やす
		$limit2 = 1;
		$sql2 =<<< SQL2
SELECT
	comment_cnt 
FROM
	$topicTable 
WHERE
	topic_id=$topicId 
LIMIT $limit2
SQL2;

		// 累計コメント数をDBから取得する
		$commentCnt = $dao->selectDataCustomSql($sql2);
		if($commentCnt === false || !isset($commentCnt[0]['comment_cnt'])){
			$dao->rollback();
			$dao->endTransaction();
			$dao->unlockTables();
			return false;
		}

		$commentCnt = $commentCnt[0]['comment_cnt'] + 1;
		$data = array('comment_cnt' => $commentCnt);
		$where = array('topic_id' => $topicId);
		$ret3 = $dao->updateData($topicTable, $data, $where);
		if($ret3 === false){
			// コメント数の更新に失敗したらロールバックして、オートコミットをONに戻す
			$dao->rollback();
			$dao->endTransaction();
			$dao->unlockTables();
			return false;
		}

		// コミットしてオートコミットをONに戻す
		$dao->commit();
		$dao->unlockTables();
		$dao->endTransaction();

		// コメントテーブルに登録したデータのIDをセット
		$this->comment_insert_id = $insert_id;

		return true;
	}

	// 最後にDBに挿入したデータのIDを取得
	public function getInsertId(){
		return $this->comment_insert_id;
	}

	// コメントがすでに入力されていないか確認する(countが0の場合はOK)
	public function checkCommentExistance($topicId, $commentId){
		$dao = $this->dao;
		$commentCd = $topicId . '-' . $commentId;
		$commentTable = "comment_tbl";

		$where = array(
			'topic_id' => $topicId,
			'comment_cd' => $commentCd
		);
		$ret = $dao->countData($commentTable, $where);
		if($ret != 0 || $ret === false){
			$ret = false;
		} else {
			$ret = true;
		}
		
		return $ret;
	}
}
?>