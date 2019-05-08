<?php


    class apiController extends Controller {
        
        public function __construct() {
            
        }

        public function users() {
            if ($this->get()) {
                $userObject = $this->model('User');
                $userArray = $userObject->getUsers();
                
                foreach($userArray as $user){

                    $singleUserArray['user_id'] = $user[0];
                    $singleUserArray['username'] = $user[1];
                    $usersObject[] = $singleUserArray;
                }
                
                echo json_encode($usersObject);
                
            }
        } 

        public function pictures($param,$userid) {
            //GET user pictures
            if ($this->get()) {
                if ($param == "user") {
                    
                    $userObject = $this->model('User');
                    $userArray = $userObject->getUsers();
                    
                    foreach($userArray as $user) {
                        if ($userid == $user[0]) {
                            $userPosts = $userObject->fetchUserPosts($userid);
                            if ($userPosts != null) {
                                foreach ($userPosts as $userPost) {
                                    $postArray['user_post_id'] = $userPost[0];
                                    $postArray['user_post_time'] = $userPost[1];
                                    $postArray['user_post_header'] = $userPost[2];
                                    $postArray['user_post_description'] = $userPost[3];
                                    $postArray['user_post_url'] = $userPost[4];
                                    $usersObject[] = $postArray;
                                    
                                }
                                
                            }
                            
                        }
                    }
                    
                    echo json_encode($usersObject);
                }
            }

        }

        // public function test($id) {
        //     $userObject = $this->model('User');
        //     $array = $userObject->fetchUserPosts($id);
        //     foreach($array as $a) {
        //         foreach ($a as $s) {
        //             echo $s;
        //             echo "<br>";
        //         }
                
        //     }
        // }

        
        // public function test() {
        //     echo 'hello';
        // }
    }

    
?>