<?php


    class APIController extends Controller {
        
        public function __construct() {

        }

        public function user() {
            if ($this->get()) {
                $userObject = $this->model('user');
                $userArray = $userObject->getUsers();
                
                foreach($userArray as $user){

                    $shortUser['user_id'] = $user['user_id'];
                    $shortUser['username'] = $user['12username'];
                    $usersObject[] = $shortUser;
                }

                echo json_encode($usersObject);
                
            }
        }
        
        public function test() {
            echo 'hello';
        }
    }

    
?>