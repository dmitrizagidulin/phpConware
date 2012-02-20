<?php
class User extends AppModel {
	var $name = 'User';
	var $useDbConfig = 'readercon_mgt';
	var $validate = array(
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'The password must be between 5 and 15 characters.'
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'The password must be between 5 and 15 characters.' => array(
				'rule' => array('between', 5, 15),
				'message' => 'The password must be between 5 and 15 characters.'
			),
			'The passwords do not match' => array(
				'rule' => 'matchPasswords',
				'message' => 'The passwords do not match.'
			)
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter the name.',
				//'allowEmpty' => false,
				'required' => true
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'roles' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	function matchPasswords($data) {
		if($data['password'] == $this->data['User']['password_confirmation']) {
			return TRUE;
		} 
		$this->invalidate('password_confirmation', 'The passwords do not match.');
		return FALSE;
	}
	
	function hashPasswords($data) {
		if(isset($this->data['User']['password'])) {
			$this->data['User']['password'] = Security::hash($this->data['User']['password'], NULL, TRUE);
		}
		return $data;
	}
	
	function beforeSave() {
		$this->hashPasswords(NULL, TRUE);
		return TRUE;
	}
}
?>