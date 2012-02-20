<?php

class AppController extends Controller {
	var $components = array('Auth', 'Session');
	
	function beforeFilter() {
		//$this->Auth->allow('index', 'view');
		$this->Auth->authError = 'Please log in to view this page';
		$this->Auth->loginError = 'Incorrect username/password.';
		//$this->Auth->loginRedirect = array('controller'=>'posts', );
		
		$this->disableCache();
		$this->set('admin', $this->_isAdmin());
		$this->set('logged_in', $this->_loggedIn());
		$this->set('users_username', $this->_usersUsername());
	}

	function endsWith($haystack, $needle, $case=FALSE) {
		if ($case) {
			return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
		}
		return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
	}

	function startsWith($haystack, $needle, $case=FALSE) {
		if ($case) {
			return (strcmp(substr($haystack, 0, strlen($needle)),$needle)===0);
		}
		return (strcasecmp(substr($haystack, 0, strlen($needle)),$needle)===0);
	}

/**
 * Take a list (usually of db row results) and create a hash/associated array of those rows
 * by the unique key passed in
 * @author Dmitri Zagidulin
 * @param array $rowList
 * @param string $key
 * @return array $hash
 */
	function hashByKey($rowList, $model, $key) {
		$hash = array();
		if(!$rowList) {
			return $hash;
		}
		foreach($rowList as $row) {
			// Hideous hack to deal with a bug in CakePHP
			if(is_array($model)) {
				foreach($model as $attempt) {
					if(array_key_exists($attempt, $row) && array_key_exists($key, $row[$attempt])) {
						$key_value = $row[$attempt][$key];
						break;
					}
				}
			} else {
				$key_value = $row[$model][$key];
			}
			$hash[$key_value] = $row;
		}
		return $hash;
	}

/**
 * Take a list (usually of db row results) and create an array of arrays
 * grouped by the unique key passed in. For example, if the rows were:
 * | spot_oid | location      |
 * |        1 | Main Office   |
 * |        1 | Branch Office |
 * |        2 | HQ            |
 * Then the result of hashListByKey(spot_oid) would be an associative array:
 *   '1' => array( array('spot_oid'=>1, 'location'=>'Main Office'),
 *                 array('spot_oid'=>1, 'location'=>'Branch Office') ),
 *   '2' => array( array('spot_oid'=>2, 'location'=>'HQ') )
 * @author Dmitri Zagidulin
 * @param array $rowList
 * @param string $key
 * @return array $hash
 */
	function hashListByKey($rowList, $model, $key) {	
		$hash = array();
		if(!$rowList) {
			return $hash;
		}
		foreach($rowList as $row) {
			// Hideous hack to deal with a bug in CakePHP
			if(is_array($model)) {
				foreach($model as $attempt) {
					if(array_key_exists($attempt, $row)) {
						$key_value = $row[$attempt][$key];
						break;
					}
				}
			} else {
				$key_value = $row[$model][$key];
			}
			$hash[$key_value][] = $row;
		}
		return $hash;
	}
	
	private function _isAdmin() {
		$admin = FALSE;
		if($this->Auth->user('roles') == 'admin') {
			$admin = TRUE;
		} 
		return $admin;
	}
	
	private function _loggedIn() {
		$logged_in = FALSE;
		if($this->Auth->user()) {
			$logged_in = TRUE;
		}
		return $logged_in;
	}
	
	private function _usersUsername() {
		$users_username = NULL;
		if($this->Auth->user()) {
			$users_username = $this->Auth->user('username');
		}
		return $users_username;
	}
}