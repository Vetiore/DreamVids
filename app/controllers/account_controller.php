<?php

require_once SYSTEM.'controller.php';
require_once SYSTEM.'actions.php';
require_once SYSTEM.'view_response.php';
require_once SYSTEM.'view_message.php';
require_once SYSTEM.'redirect_response.php';

require_once MODEL.'user_channel.php';

class AccountController extends Controller {

	public function __construct() {
		$this->denyAction(Action::GET);
		$this->denyAction(Action::CREATE);
		$this->denyAction(Action::DESTROY);
	}

	public function index($request) {
		if(Session::isActive()) {
			$data['user'] = Session::get();
			$data['username'] = Session::get()->username;
			$data['email'] = Session::get()->email;
			$data['current'] = 'account';
			
			return new ViewResponse('account/profile', $data);
		}
		else
			return new RedirectResponse(WEBROOT.'login');
	}

	public function update($id, $request) {
		if(!Session::isActive()) {
			return new RedirectResponse(WEBROOT.'login');
		}

		$req = $request->getParameters();
		$data = $req;
		$data['current'] = 'account';
		$data['email'] = Session::get()->email;

		if($id == 'mail') {
			if(isset($req['profileSubmit']) && Session::isActive()) {
				$currentMail = Session::get()->email;
				$currentUsername = Session::get()->username;

				if(isset($req['email']) && $req['email'] != $currentMail) {
					$newMail = Utils::secure($req['email']);

					if(Utils::validateMail($newMail)) {
						Session::get()->setEmail($newMail);

						$data['email'] = $newMail;
						$response = new ViewResponse('account/profile', $data);
						$response->addMessage(ViewMessage::success('Préférences enrigistrées !'));

						return $response;
					}
					else {
						$response = new ViewResponse('account/mail', $data);
						$response->addMessage(ViewMessage::error('L\'adresse E-Mail n\'est pas valide'));

						return $response;
					}
				}
			}
		}

		if($id == 'password') {
			if(isset($req['passwordSubmit']) && Session::isActive()) {
				if(isset($req['newPass']) && isset($req['newPassConfirm']) && isset($req['currentPass'])) {
					if($req['newPass'] == $req['newPassConfirm']) {
						$currentPass = sha1($req['currentPass']);
						$newPass = sha1($req['newPass']);
						$data = $req;
						$data['current'] = 'password';
						
						if($currentPass == Session::get()->pass) {
							Session::get()->setPassword($newPass);

							$response = new ViewResponse('account/password', $data);
							$response->addMessage(ViewMessage::success('Préférences enregistrées !'));

							return $response;
						}
						else {
							$response = new ViewResponse('account/password', $data);
							$response->addMessage(ViewMessage::error('Le mot de passe actuel est erroné'));

							return $response;
						}
					}
					else {
						$response = new ViewResponse('account/password', $data);
						$response->addMessage(ViewMessage::error('Les mots de passe ne sont pas identiques'));

						return $response;
					}
				}
			}
		}
		else
			return new ViewResponse('account/profile', $data);
	}

	public function mail($request) {
		if(Session::isActive()) {
			$data['user'] = Session::get();
			$data['username'] = Session::get()->username;
			$data['email'] = Session::get()->email;
			$data['current'] = 'account';
			
			return new ViewResponse('account/profile', $data);
		}
		else
			return new RedirectResponse(WEBROOT.'login');
	}

	public function password($request) {
		if(Session::isActive()) {
			$data['user'] = Session::get();
			$data['username'] = Session::get()->username;
			$data['current'] = 'password';

			return new ViewResponse('account/password', $data);
		}
		else {
			header('Location: '.WEBROOT.'login');
			exit();
		}
	}

	public function videos($request) {
		if(Session::isActive()) {
			$data['user'] = Session::get();
			$data['videos'] = Session::get()->getMainChannel()->getPostedVideos();
			$data['current'] = 'videos';

			return new ViewResponse('account/videos', $data);
		}
		else
			return new RedirectResponse(WEBROOT.'login');
	}

	public function messages($request) {
		if(Session::isActive()) {
			$data = array();
			$data['current'] = 'messages';

			$data['channels'] = Session::get()->getOwnedChannels();

			return new ViewResponse('account/messages', $data);
		}
		else
			return new RedirectResponse(WEBROOT.'login');
	}

	public function channels() {
		if(Session::isActive()) {
			$data['user'] = Session::get();
			$data['channels'] = Session::get()->getOwnedChannels();
			$data['current'] = 'channels';

			return new ViewResponse('account/channels', $data);
		}
		else
			return new RedirectResponse(WEBROOT.'login');
	}

	public function get($id, $request) {}
	public function create($request) {}
	public function destroy($id, $request) {}

}