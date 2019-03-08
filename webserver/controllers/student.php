<?php
class Student extends Controller{

	protected function Index(){
		return;
	}


	protected function Ajax(){
		$viewmodel = new StudentModel();
		$this->returnView($viewmodel->Ajax(), False);
	}


}
