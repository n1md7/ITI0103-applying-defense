<?php
class Home extends Controller{
        protected function Index(){
                Restrict::view();

                $viewmodel = new HomeModel();
                $this->returnView($viewmodel->Index(), 'main.php');
        }

        protected function Ajax(){
                Restrict::view();

                $viewmodel = new HomeModel();
                $this->returnView($viewmodel->Ajax(), 'main.php');
        }

}