<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form' );
	
//	function beforeFilter() {
//		$this->name / $this->action
//		parent::beforeFilter();
//		$this->Auth->allow('add');
//		if($this->action == 'add' || $this->action == 'edit') {
//			$this->Auth->authenticate = $this->User;
//		}
//	}
	
	function login() {
		if ($this->data) {
			$results = $this->User->findByEmail($this->data['User']['email']);
			if(!$results) {
				$this->Session->setFlash('No user found for that email. Please <a href="/pro_signup/users/register">Register</a> a new account.');
				return;
			}
			if ($results['User']['password'] == Security::hash($this->data['User']['password'], NULL, TRUE)) {
				$this->Session->write('user_email', $this->data['User']['email']);
				$this->Session->write('user_id', $results['User']['id']);
				$this->redirect(array('controller'=>'dashboards', 'action' => 'index'));
			} else {
				$this->Session->setFlash('Incorrect password; please try again, or <a href="/pro_signup/users/reset_password">reset your password</a>.');
			}
		}
	}
	
	function logout() {
		$this->Session->delete('user');
		$this->Session->delete('user_id');
		$this->Session->destroy();
		$this->redirect(array('controller'=>'dashboards', 'action' => 'index'), null, true);
	}
	
	function register() {
		if (!empty($this->data)) {
			if ($this->User->save($this->data)) {
				$this->Session->setFlash('Thank you, your account has been created.');
				$this->Session->write('user_id', $this->data['User']['id']);
				$this->Session->write('user_email', $this->data['User']['email']);
				$this->redirect(array('controller' => 'dashboards', 'action' => 'view'));
			} else {
				$this->Session->setFlash('There was a problem creating this account. Please try again.');
			}
		}
	}
	
	function reset_password() {
		if (!empty($this->data)) {
			$email = $this->data['User']['email'];
			$user = $this->User->find('first', array(
				'conditions' => array('User.email' => $email),
			));
			if(!$user) {
				$this->Session->setFlash('No user found for that email. Please check spelling or <a href="/pro_signup/users/register">Register</a> a new account.');
			} else {
				$this->data['User']['id'] = $user['User']['id'];
				$this->data['User']['name'] = $user['User']['name'];
				$this->data['User']['roles'] = $user['User']['roles'];
				if ($this->User->save($this->data)) {
					$this->Session->setFlash('Thank you, your password has been reset. Please try logging in.');
					$this->redirect(array('controller' => 'users', 'action' => 'login'));
				} else {
					$this->Session->setFlash('There was a problem re-setting your password. Please try again.');
				}
			}
		}
		
	}
}
?>