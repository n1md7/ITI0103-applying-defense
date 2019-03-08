<?php
abstract class Controller{
	protected $request;
	protected $action;

	public function __construct($action, $request){
		$this->action = $action;
		$this->request = $request;
	}

	public function executeAction(){
		return $this->{$this->action}();
	}

	/* $templateName = false if dont want to use any template */
	protected function returnView($viewmodel, $templateName){
		$view = 'views/'. get_class($this). '/' . $this->action. '.php';
		if($templateName){
			if(file_exists('views/_templates/'.$templateName)){
				$csrf = Generate::csrf();
				//include $view inside template and assign $csrf var
				//for ajax requests it should update with other data
				require('views/_templates/'.$templateName);
			}else{
				exit($templateName.' doesn\'n exist in _templates folder!');
			}
		} else {
			require($view);
		}
	}
}