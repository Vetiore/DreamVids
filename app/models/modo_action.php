<?php

class ModoAction extends ActiveRecord\Model {

	static $table_name = 'modos_actions';

	public static function generateId($length) {
		$idExists = true;

		while($idExists) {
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$id = '';
		
			for ($i = 0; $i < $length - 2; $i++) {
				$id .= $chars[rand(0, strlen($chars) - 1)];
			}

			$id = 'a_'.$id;

			$idExists = ModoAction::exists(array('id' => $id));
		}

		return $id;
	}

}