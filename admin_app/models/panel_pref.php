<?php
define('NO_THANKS', 0);
define('WATCH', 1);
define('PARTICIPATE', 2);


class PanelPref extends AppModel {
	var $name = 'PanelPref';
	
//	var $virtualFields = array('interest_count' => 'COUNT(*)');
	
	var $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'panel_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'interest' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'panel_rating_id' => array(
			'rule' => array('checkRating'),
//				'required' => false,
//				'allowEmpty' => true,
			'message' => 'Please rate the panel',
				//'allowEmpty' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
		'opt_panelist' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'allowEmpty' => true,
				'required' => false,
				'message' => 'Invalid option for Panelist checkbox',
			),
		),
		'opt_leader' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'allowEmpty' => true,
				'required' => false,
				'message' => 'Invalid option for Leader checkbox',
			),
		),
		'opt_moderator' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'allowEmpty' => true,
				'required' => false,
				'message' => 'Invalid option for Moderator checkbox',
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Panel' => array(
			'className' => 'Panel',
			'foreignKey' => 'panel_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PanelRating' => array(
			'className' => 'PanelRating',
			'foreignKey' => 'panel_rating_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function checkRating($check) {
		if(!$this->data['PanelPref']['interest']) {
			return TRUE;
		}
		if(!is_numeric($check['panel_rating_id'])) {
			return FALSE;
		}
		return TRUE;
	}
	
	public function isParticipating() {
		if(!isset($this->data['PanelPref']['interest'])) {
			return FALSE;
		}
		return $this->data['PanelPref']['interest'] == PARTICIPATE;
	}
	
	public function notInterested() {
		if(!isset($this->data['PanelPref']['interest'])) {
			return FALSE;
		}
		return $this->data['PanelPref']['interest'] == NO_THANKS;
	}
	
	public function beforeSave($options) {
		if(!$this->isParticipating()) {
			$this->data['PanelPref']['opt_panelist'] = 0;
			$this->data['PanelPref']['opt_leader'] = 0;
			$this->data['PanelPref']['opt_moderator'] = 0;
		}
		if($this->notInterested()) {
			$this->data['PanelPref']['panel_rating_id'] = NULL;
		}
		return TRUE;
	}
	
	
	public function lastPanelForUser($user_id) {
		$last_panel = $this->find('first', 
									array('fields' => 'PanelPref.panel_id',
										'recursive' => -1,
										'order' => 'PanelPref.panel_id DESC',
										'conditions' => array('PanelPref.user_id' => $user_id)));

		if($last_panel) {
			return $last_panel['PanelPref']['panel_id'];
		} else {  // User has not filled out any panels
			return NULL;
		}
	}
}
?>