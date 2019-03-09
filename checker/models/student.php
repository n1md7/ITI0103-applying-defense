<?php
class StudentModel{
	private $db;
	public function __construct(){
		$this->db = new Model('138.68.96.132', 'bloom_assessment', 'student_root', 'MICRosoFT_Sucks_for_real', '3306');
	}

	public function Index(){
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

		if( $_SESSION['csrf'] !== $post['csrf'] ){
                Encode::json([
                    'status' => 'error',
                    'msg' => 'CSRF Token is Invalid',
                    'a' => $_SESSION['csrf'] . ' - ' . $post['csrf']
                ]);
        }

		switch ($post['action']) {
			case 'check':
				if( !isDefined($post['task']) || !isDefined($post['answer']) ){ 
                	Encode::json([
                            'status' => 'error',
                            'msg' => 'Gimme more data'
                        ]);
                }
                $lab = require('./questions.php');
                //white list according keys from lab tasks
                if(!in_array((int)$post['task'], range(0, count($lab['questions']) - 1))){
                	Encode::json([
                            'status' => 'error',
                            'msg' => 'task out of range'
                        ]);
                }

                $status = 'wrong';
                $task = (int)$post['task'];
                $answer = trim($_POST['answer']);
                foreach ($lab['questions'] as $key => $question) {
                 	if($task === $key){
                 		if($lab['answers'][$key] === $answer){
	                		$status = 'correct';
	                		break;
                 		}
                 	}
                } 

                $this->db->query("INSERT INTO logs (student_name, challenge_level, task_number, status, update_time, answered) 
                	VALUES (:student_name, :challenge_level, :task_number, :status, :update_time, :answered)");
                $this->db->bind(':student_name', $_SESSION['student']);
                $this->db->bind(':challenge_level', LAB_TYPE);
                $this->db->bind(':task_number', $post['task']);
                $this->db->bind(':status', $status);
                $this->db->bind(':update_time', time());
                $this->db->bind(':answered', $post['answer']);

                $this->db->execute();

                if($this->db->lastInsertId() > 0){
                	if($status === 'correct'){
	                	Encode::json([
	                            'status' => 'success',
	                            'msg' => $status
	                        ]);
                	}else{
                		Encode::json([
	                            'status' => 'error',
	                            'msg' => $status
	                        ]);
                	}
                }else{
                	Encode::json([
                            'status' => 'error',
                            'msg' => 'something went wrong'
                        ]);
                }

			break;
			case 'highlight':
				$this->db->query("SELECT task_number FROM logs WHERE challenge_level = :level AND status = 'correct' AND student_name = :name");
				$this->db->bind(':level', LAB_TYPE);
				$this->db->bind(':name', $_SESSION['student']);

		        Encode::json([
					'status' => 'success',
					'msg' => ':)',
					'data' => $this->db->resultSet()
				]);
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



