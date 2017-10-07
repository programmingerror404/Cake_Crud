<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */

class UsersController extends AppController {

	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|void
	 */

	public $components = array('Session');
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		//$this->SessionComponent->hasuser();
		// if (!$this->SessionComponent->hasuser()) {
		// 	$this->Session->setFlash('You need to be logged in to access this area');
		// 	$this->redirect('/users/login/');
		// 	exit();
		// }
		$this->Auth->allow('logout');
	}

	public function index() {
		$users   = $this->paginate($this->Users);
		$session = $this->request->session();
		debug($_SESSION['Auth']['User']);
		$this->set(compact('users'));
		$this->set('_serialize', ['users']);
	}

	public function login() {
		if ($this->request->is('post')) {
			$user = $this->Auth->identify();
			if ($user != false) {
				$this->Auth->setUser($user);

				if ($this->Auth->authenticationProvider()->needsPasswordRehash()) {
					$user           = $this->Users->get($this->Auth->user('id'));
					$user->password = $this->request->data('password');
					$this->Users->save($user);
					$session = $this->request->session();
					$session->write('id', $this->Auth->user('id'));

				}

				return $this->redirect($this->Auth->redirectUrl());
			} else {
				$this->Flash->error(__('Invalid username or password, try again'));
			}

		}
	}

	public function logout() {
		$session = $this->request->session();
		$session->destroy();
		$this->Flash->success(__('Successfully Logout!'));
		return $this->redirect($this->Auth->logout());
	}

	/**
	 * View method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|void
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null) {
		$user = $this->Users->get($id, [
				'contain' => []
			]);

		$this->set('user', $user);
		$this->set('_serialize', ['user']);
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add() {
		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->getData());
			if ($this->Users->save($user)) {
				$this->Flash->success(__('The user has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The user could not be saved. Please, try again.'));
		}
		$this->set(compact('user'));
		$this->set('_serialize', ['user']);
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null) {
		$user = $this->Users->get($id, [
				'contain' => []
			]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$user = $this->Users->patchEntity($user, $this->request->getData());
			if ($this->Users->save($user)) {
				$this->Flash->success(__('The user has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The user could not be saved. Please, try again.'));
		}
		$this->set(compact('user'));
		$this->set('_serialize', ['user']);
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);
		$user = $this->Users->get($id);
		if ($this->Users->delete($user)) {
			$this->Flash->success(__('The user has been deleted.'));
		} else {
			$this->Flash->error(__('The user could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
