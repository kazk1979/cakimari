<?php
require_once('base.php');
require_once(SMARTY_DIR . "Smarty.class.php");

class Io {
	public function display($tmpl, $dispData=array()){
		// create object
		$smarty = new Smarty;

		// smartyの変数未定義エラーを出さないためのおまじない
		$smarty->error_reporting = E_ALL & ~E_NOTICE;

		// JSをliteralで囲まなくて良いようにデリミタを変更
		$smarty->left_delimiter = '<{';
		$smarty->right_delimiter = '}>';
 
		// template, cache, configuration files
		$smarty->template_dir = SMARTY_OTHERS . "templates/";
		$smarty->compile_dir  = SMARTY_OTHERS . 'templates_c/';
		$smarty->config_dir   = SMARTY_OTHERS . 'configs/';
		// $smarty->cache_dir = SMARTY_OTHERS . 'cache/';

		// assign some content.
		$smarty->assign('data', $dispData);

		$smarty->display(TMPL_DIR . $tmpl);
	}
}
?>