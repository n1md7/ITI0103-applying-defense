<?php
class HomeModel extends Model{
    public function Index(){
        return;
    }

    public function Ajax(){

        header('Content-type: application/json');

        $post = $_POST;

        if( !isset($post['action']) ){
            Encode::json([
                        'status' => 'error',
                        'msg' => ':)',
                    ]);
        }
 

        switch ($post['action']) {
            case 'search':
                if( !isDefined($post['search']) ){ 
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

