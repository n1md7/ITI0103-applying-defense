<?php
class User extends Controller{

	protected function Index(){
		$viewmodel = new UserModel();
		$this->returnView($viewmodel->Index(), 'main.php');
	}

	protected function SignIn(){
		$viewmodel = new UserModel();
		$this->returnView($viewmodel->SignIn(), 'main.php');
	}

	protected function SignUp(){
		$viewmodel = new UserModel();
		$this->returnView($viewmodel->SignUp(), 'main.php');
	}

	protected function Ajax(){
		$viewmodel = new UserModel();
		$this->returnView($viewmodel->Ajax(), False);
	}


	protected function signout(){
		if(isset($_SESSION['islogged_in'])):
			unset($_SESSION['islogged_in']);
			unset($_SESSION['user']);
			unset($_SESSION['student']);
			session_destroy();
		endif;
		/*
			Redirect
		*/
			header('Location: '.ROOT_URL);

		return;
	}
}
