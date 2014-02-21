<?php
require_once('base.php');

class FileController {
	function __construct(){
	}

	public function writeFile($filePath, $mode, $data){
		$fp = fopen($filePath, $mode);

		if ($fp){
			flock($fp, LOCK_EX);
			fwrite($fp,  $data);
			fflush($fp);
			flock($fp, LOCK_UN);
			fclose($fp);
		}
		
		return;
	}
}
?>