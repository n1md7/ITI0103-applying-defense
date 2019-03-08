<?php
class HomeModel extends Model{
    public function Index(){
        return;
    }

    public function Ajax(){

        header('Content-type: application/json');

        // $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $post = $_POST;

        if( !isset($post['action'])){
                Encode::json([
                            'status' => 'error',
                            'msg' => ':)'
                        ]);
        }

        if( $_SESSION['csrf'] !== $post['csrf'] ){
                Encode::json([
                    'status' => 'error',
                    'msg' => 'CSRF Token is Invalid'
                ]);
        }

        switch ($post['action']) {
            case 'search':
                if( !isset($post['search']) || empty($post['search'])){ 
                	Encode::json([
                            'status' => 'error',
                            'msg' => 'Empty field detected'
                        ]);
                }

                $search = $post['search'];

                $this->query("SELECT * FROM books WHERE title LIKE '$search%' ORDER BY 1 DESC LIMIT 50");

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

