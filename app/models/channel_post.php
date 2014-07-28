<?php

class ChannelPost extends ActiveRecord\Model {

	static $table_name = 'channels_posts';

	public function toArray() {
		print_r(get_object_vars($this));
		return get_object_vars($this);
	}

	public static function generateId($length) {
		$idExists = true;

		while($idExists) {
			$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$id = '';
		
			for ($i = 0; $i < $length; $i++) {
				$id .= $chars[rand(0, strlen($chars) - 1)];
			}

			$idExists = ChannelPost::exists(array('id' => $id));
		}

		return $id;
	}

}