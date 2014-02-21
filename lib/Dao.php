<?php
	require_once("base.php");
	class Dao {
		private $link;

		function __construct(){
			$url  = DB_URL;
			$user = DB_USER;
			$pass = DB_PASS;
			$db   = DB_NAME;

			// MySQLへ接続する
			$link = new mysqli($url, $user, $pass, $db);
			if(@mysqli_connect_error()){
				echo "SYSTEM ERROR:10100";
				exit;
			}

			$link->query('set character set utf8');

			$this->link = $link;
		}
		
		function __destruct(){
			if(!empty($this->link)){
				$this->link->close();
			}
		}

		function getEscapeVal ($val) {
			return $this->link->real_escape_string($val);
		}

		function selectData($table, $whereArray=array(), $selectArray=array()){
			if(empty($selectArray)){
				$select = "*";
			} else {
				$select    = "";
				$selectCnt = count($selectArray);
				$cnt = 0;
				foreach($selectArray as $selectCol){
					if($selectCnt-1 === $cnt){
						$select = $this->link->real_escape_string($selectCol);
					} else {
						$select = $this->link->real_escape_string($selectCol) . ", ";
					}
				}
			}

			$sql = "SELECT " . $select . " FROM " . $table . $this->_setWhere($whereArray) . ";";

			return $this->_selectDataCommon($sql);
		}

		function countData($table, $whereArray=array()){

			$sql = "SELECT COUNT(*) AS count FROM " . $table . $this->_setWhere($whereArray) . ";";
			$res = $this->_selectDataCommon($sql);

			return $res[0]['count'];
		}

		function selectDataCustomSql($sql){
			return $this->_selectDataCommon($sql);
		}

		function updateData($table, $data, $whereArray){
			$updateArray = array();

			foreach($data as $colName => $val){
				$escapeVal = $this->link->real_escape_string($val); 
				$updateArray[] = $colName . "='" . $escapeVal . "'";
			}
			
			$updateStr = implode(", ", $updateArray);

			// 更新
			$sql = "UPDATE ".$table." SET ".$updateStr.$this->_setWhere($whereArray).";";

			return $this->link->query($sql);
		}

		function insertData($table, $data){
			$colArray = array();
			$valArray = array();

			foreach($data as $colName => $val){
				$colArray[] = $colName;

				$escapeVal = $this->link->real_escape_string($val); 
				$valArray[] = "'" . $escapeVal . "'";
			}

			$colStr = implode(", ", $colArray);
			$valStr = implode(", ", $valArray);

			// 格納
			$sql = "INSERT INTO " . $table . "(" .
				$colStr .
				") values ( " .
				$valStr .
				");";

			$res = $this->link->query($sql);

			if($res === false) return false;
			
			return $this->link->insert_id;
		}

		function deleteData($table, $where){
			$sql = "DELETE FROM " . $table . $this->_setWhere($where) . ";";

			return $this->link->query($sql);
		}

		// where区でorとかinを使いたい時とか
		function deleteDataCustomSql($sql){
			return $this->link->query($sql);
		}

		function startTransaction(){
			$this->link->query('set autocommit = 0');
			$this->link->query('begin');
		}

		function endTransaction(){
			$this->link->query('set autocommit = 1');
		}

		function lockTables4Write($tableList){
			$tableStr = implode(', ', $tableList);

			$this->link->query('LOCK TABLES ' . $tableStr . ' WRITE');
		}

		function unlockTables(){
			$this->link->query('UNLOCK TABLES');
		}

		function commit(){
			$this->link->query('commit');
		}

		function rollback(){
			$this->link->query('rollback');
		}

		private function _selectDataCommon($sql){
			$setNameRes = $this->link->query('SET NAMES utf8');
			$result = $this->link->query($sql);
			if($result === false) return false;
		
			$resArray = array();
			while($row = $result->fetch_assoc()){
				array_push($resArray, $row);
			}

			$result->free();

			return $resArray;
		}

		private function _setWhere($whereList){
			$where = "";
			foreach($whereList as $colName => $colValue){
				if($where == ""){
					$where = " WHERE " . $this->link->real_escape_string($colName) . " = '" . $this->link->real_escape_string($colValue) . "'"; 
				} else {
					$where .= " AND " . $this->link->real_escape_string($colName) . " = '" . $this->link->real_escape_string($colValue) . "'";
				}
			}

			return $where;
		}
	}
?>
