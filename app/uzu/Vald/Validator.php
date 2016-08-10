<?php

	namespace Uzu\Vald;

	use Violin\Violin;

	use Uzu\User\User;
	use Uzu\Help\Hash;

	class Validator extends Violin
	{

		protected $user;

		protected $hash;

		protected $auth;

		public function __construct(User $user, Hash $hash, $auth = null)
		{
			$this->user = $user;
			$this->hash = $hash;
			$this->auth = $auth;

			$this->addFieldMessages([
				'email' => [
					'uniqueEmail' => 'That email is already in use.'
				],
				'username' => [
					'uniqueUser' => 'That username is already in use.'
				]
			]);

			$this->addRuleMessages([
				'matchesCurrentPass' => 'That does not match your current password!'
			]);
		}

		public function validate_uniqueEmail($value, $input, $args)
		{
			$user = $this->user->where('email', $value);

			if ($this->auth && $this->auth->email === $value) {
				return true;
			}

			return ! (bool) $user->count();
		}

		public function validate_uniqueUser($value, $input, $args)
		{
			return ! (bool) $this->user->where('username', $value)->count();
		}

		public function validate_matchesCurrentPass($value, $input, $args)
		{
			if ($this->auth && $this->hash->passwordCheck($value, $this->auth->password)) {
				return true;
			}

			return false;
		}
	}

?>