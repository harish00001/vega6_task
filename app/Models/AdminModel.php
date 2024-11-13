<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
	protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'password', 'profile_picture'];

	public function login(string $email, string $password)
	{
		$row = $this->select('name', 'email', 'password', 'profile_picture')
			->where('email', $email)
			->get()
			->getRow();

		if (is_null($row)) {
			return false;
		}

		$dbPassword = $row->password;

		if (password_verify($password, $dbPassword)) {
			unset($row->password);
			unset($row->remember_token);
			return $row;
		} else {
			return false;
		}
	}
	
	public function checkLogin($user_login, $password)
	{
		$builder = $this->db->table($this->table);
		$builder->where('email', trim($user_login));


		$hashedPassword = md5_password($password);
		$builder->where('password', $hashedPassword);

		$select = $builder->get();
		return $select->getRow();
	}

	
	public function getUserById(int $id)
	{
		$row = $this->where('id', $id)->get()->getRow();
		unset($row->password);
		unset($row->remember_token);
		return $row;
	}

	

	
}
