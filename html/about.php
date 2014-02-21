<?php
require_once('../lib/base.php');
require_once(LIB_DIR . 'Io.php');

// クラスオブジェクト
$ioObj = new Io();

// 画面表示
$ioObj->display('about.tmpl', array());

?>