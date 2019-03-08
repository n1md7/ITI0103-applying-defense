<?php
class Bootstrap{
	private $controller;
	private $action;
	private $request;

	public function __construct($request){
		$this->request = $request;
		if(!isset($request['controller']) || $this->request['controller'] == ""):
			$this->controller = 'user';
		else:
			$this->controller = $this->request['controller'];
		endif;

		if(!isset($request['action']) || $this->request['action'] == ""):
			$this->action = 'index';
		else:
			$this->action = $this->request['action'];
		endif;
	}

	public function createController(){
		if(class_exists($this->controller)):
			$parents = class_parents($this->controller);
			if(in_array("Controller", $parents)):
				if(method_exists($this->controller, $this->action)):
					return new $this->controller($this->action, $this->request);
				else:
					DEBUG ? print('Method doesn\'t exist!'):header("location: " . ROOT_URL );
					return;
				endif;
			else:
				DEBUG ? print('Base controller not found!'):header("location: " . ROOT_URL );
				return;
			endif;
		else:
			DEBUG ? print('Controller class doesn\'t exist!'):header("location: " . ROOT_URL );
			return;
		endif;
	}
}
