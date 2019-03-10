<?php
class HomeModel extends Model{
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

        switch ($post['action']) {
            case 'check':
                if( !isDefined($post['task']) ){ 
                	Encode::json([
                            'status' => 'error',
                            'msg' => 'Empty field detected'
                        ]);
                }

                $status = 'bug';
                $task = (int)$post['task'];
                if($task === 1){

                    $resp = Curl::send(TARGET, ['search' => 'h', 'action' => 'search']);
                    if(strpos($resp, '<!doctype html>') !== false){
                        $status = 'fixed';
                    }

                }elseif ($task === 2) {

                    $resp = json_decode(Curl::send(TARGET.'/home/ajax', ['action' => 'search', 'search' => "___'or'1=1"]))->{"data"};
                    if( $resp !== null && gettype($resp) === "array" && count($resp) === 0){
                        $status = 'fixed';
                    }
                   
                }

                $this->query("INSERT INTO logs (student_name, challenge_level, task_number, status, update_time, answered) 
                    VALUES (:student_name, :challenge_level, :task_number, :status, :update_time, :answered)");
                $this->bind(':student_name', $_SESSION['student']);
                $this->bind(':challenge_level', LAB_TYPE);
                $this->bind(':task_number', '-1');
                $this->bind(':status', $status);
                $this->bind(':update_time', time());
                $this->bind(':answered', '');

                $this->execute();
                sleep(1);
                if($this->lastInsertId() > 0){
                    if($status === 'fixed'){
                        Encode::json([
                                'status' => 'success',
                                'msg' => $status,
                                'resp' => $resp,
                                'target' => TARGET
                            ]);
                    }else{
                        Encode::json([
                                'status' => 'error',
                                'msg' => $status,
                                'resp' => $resp,
                                'target' => TARGET
                            ]);
                    }
                }else{
                    Encode::json([
                            'status' => 'error',
                            'msg' => 'something went wrong'
                        ]);
                }


                Encode::json([
                    'status' => 'success',
                    'data' => $this->resultSet()
                ]);

                break;

            default:
                Encode::json([
                    'status' => 'error',
                    'msg' => 'No data'
                ]);
                break;
        }
    }
}

