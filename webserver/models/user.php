<?php
class UserModel extends Model{
	public function Index(){
		return;
	}

	public function SignUp(){
		return;
	}

	public function SignIn(){
		return;
	}

	public function Ajax(){

		header('Content-type: application/json');

		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

		if( !isset($post['action'])){
			Encode::json([
					'status' => 'error',
					'msg' => ':)'
				]);
		}

		switch ($post['action']) {
			case 'signin':
				if( $_SESSION['csrf'] !== $post['csrf'] ){
					Encode::json([
						'status' => 'error',
						'msg' => 'CSRF Token is Invalid'
					]);
				}

				if( 
					!isset($post['user']) || empty($post['user']) || 
					!isset($post['pass']) || empty($post['pass'])
				){
					Encode::json([
						'status' => 'error',
						'msg' => 'Some Data is missing'
					]);
				}

				$password = Generate::sha512($post['pass']);

				$this->query('SELECT * FROM users WHERE user = :user AND pass = :passwd');
				$this->bind(':user',   $post['user']);
				$this->bind(':passwd', $password);

				if( $this->rowCount() > 0){
					
					$_SESSION['islogged_in'] = True;
					$_SESSION['user'] = $post['user'];

					Encode::json([
						'status' => 'success'	
					]);
				}else{
					Encode::json([
						'status' => 'error',
						'msg' => 'Wrong Credentials'	
					]);
				}
				break;
			
			case 'signup':
				if( $_SESSION['csrf'] !== $post['csrf'] ){
					Encode::json([
						'status' => 'error',
						'msg' => 'CSRF Token is Invalid'
					]);
				}

				if( 
					!isset($post['user'])  || empty($post['user'])  || 
					!isset($post['pass0']) || empty($post['pass0']) ||
					!isset($post['pass1']) || empty($post['pass1'])
				){
					Encode::json([
						'status' => 'error',
						'msg' => 'Some Data is missing'
					]);
				}

				if( 
					strlen($post['user']) < 6   || 
					strlen($post['pass0']) < 6  ||
					strlen($post['pass1']) < 6 
				){
					Encode::json([
						'status' => 'error',
						'msg' => 'Length should be at least 6 characters!'
					]);
				}

				if( $post['pass0'] !== $post['pass1'] ){
					Encode::json([
						'status' => 'error',
						'msg' => 'Passwords didn\'t match'
					]);
				}

				$password = Generate::sha512($post['pass0']);

				$this->query('SELECT * FROM users WHERE user = :user');
				$this->bind(':user',   $post['user']);

				if( $this->rowCount() > 0){
					Encode::json([
						'status' => 'error',
						'msg' => 'User already in DB'
					]);	
				}


				$this->query('INSERT INTO users (user, pass) VALUES (:user, :passwd)');
				$this->bind(':user',   $post['user']);
				$this->bind(':passwd', $password);

				$this->execute();
				if( $this->lastInsertId() > 0){
					Encode::json([
						'status' => 'success'	
					]);
				}else{
					Encode::json([
						'status' => 'error',
						'msg' => 'Something went wrong'	
					]);
				}
				break;
			
			default:
				Encode::json([
					'status' => 'error',
					'msg' => ':)'
				]);
				break;
		}
	}
}



