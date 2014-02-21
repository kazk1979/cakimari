<?php
	require_once("base.php");
	
	class SessionManager{
		function startSession(){
			session_start();
		}

		function setSession($name, $value){
			$_SESSION[$name] = $value;
		}

		function destroySession(){
			$_SESSION = array();

			if (isset($_COOKIE[session_name()])) {
				setcookie(session_name(), '', time()-42000, '/');
			}

			session_destroy();
		}

		function checkSessionStatus(){
			// true:  session_startされている
			// false: session_startされていない
			return isset($_SESSION); 
		}
	}
?>
