<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class SessionComponent extends Component {
	public $components = array('Session');
	// public function hasuser() {
	// 	if ($this->Session->read("Auth.User.id") == '') {
	// 		return false;
	// 	} else {
	// 		return true;
	// 	}
	// }
}
