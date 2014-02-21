<?php
	require_once("base.php");
	
	class Pager{
		private $currentPage;
		private $firstDsipPage;
		private $lastDispPage;
		private $totalPageNum;

		function __construct($currentPage, $dataNum, $maxListNum){
			$this->_setTotalPageNum($dataNum, $maxListNum);
			$this->_setCurrentPage($currentPage);
			$this->_setDispPageRange();
		}

		public function getPageInfo(){
			$pageInfo['pageList'] = $this->_getPageList();
			$pageInfo['hasFirstPageNaviFlg'] = $this->_hasFirstPageNaviFlg();
			$pageInfo['hasLastPageNaviFlg'] = $this->_hasLastPageNaviFlg();
			$pageInfo['currentPage'] = $this->currentPage;
			$pageInfo['totalPageNum'] = $this->totalPageNum;

			return $pageInfo;
		}

		private function _getPageList(){
			$pageList = array();
			$i = $this->firstDispPage;
			for($i; $i <= $this->lastDispPage; $i++){
				$pageList[] = $i;
			}
			
			return $pageList;
		}

		private function _hasFirstPageNaviFlg(){
			if($this->firstDispPage == 1){
				$res = FALSE;
			} else {
				$res = TRUE;
			}
			
			return $res;
		}

		private function _hasLastPageNaviFlg(){
			if($this->lastDispPage == $this->totalPageNum){
				$res = FALSE;
			} else {
				$res = TRUE;
			}
			
			return $res;
		}

		private function _setCurrentPage($currentPage){
			// 指定ページが不正の場合は１ページ目と見なす
			if(($currentPage < 1) || ($this->totalPageNum < $currentPage)) $currentPage = 1;
			
			$this->currentPage = $currentPage;
		}

		private function _setDispPageRange(){
			if(($this->currentPage - floor(MAX_PAGE_NUM / 2)) <= 1){
				// 1ページ目が1の場合
				$firstPage = 1;
				
				if($firstPage + (MAX_PAGE_NUM - 1) <= $this->totalPageNum){
					$lastPage = $firstPage + (MAX_PAGE_NUM - 1);
				} else {
					$lastPage = $this->totalPageNum;
				}
			} else {
				// 1ページ目が1以外の場合
				if(($this->currentPage + floor(MAX_PAGE_NUM / 2)) <= $this->totalPageNum){
					$lastPage = $this->currentPage + floor(MAX_PAGE_NUM / 2);
				} else {
					$lastPage = $this->totalPageNum;
				}
				
				if($lastPage - (MAX_PAGE_NUM - 1) <= 1){
					$firstPage = 1;
				} else {
					$firstPage = $lastPage - (MAX_PAGE_NUM - 1);
				}
			}

			$this->firstDispPage = $firstPage;
			$this->lastDispPage = $lastPage;
		}

		private function _setTotalPageNum($dataNum, $maxListNum){
			$pageNum = floor($dataNum / $maxListNum);

			if(($dataNum % $maxListNum) != 0) $pageNum++;
			$this->totalPageNum = $pageNum;
		}
	}
?>
