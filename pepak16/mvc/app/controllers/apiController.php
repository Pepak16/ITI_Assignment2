<?php

require_once $_SERVER["DOCUMENT_ROOT"].'/pepak16/mvc/app/models/Post.php';
    class apiController extends Controller {
        
        // public function __construct() {
        //     header('Acces-Control-Allow-Origin: *');
        //     header('Content-Type: application/json; charset=UTF-8');            
        // }

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
            $userObject = $this->model('User');
            //GET user pictures
            if ($this->get()) {
                
                if ($param == "user") {
                    $userArray = $userObject->getUsers();
                    
                    foreach($userArray as $user) {
                        if ($userid == $user[0]) {
                            $userPosts = $userObject->fetchUserPosts($userid);
                            if ($userPosts != null) {
                                foreach ($userPosts as $userPost) {
                                    
                                    $base64decodedimg = base64_encode(file_get_contents('../app/'.$userPost[4]));
                                    
                                    $postArray['image'] = $base64decodedimg;
                                    $postArray['title'] = $userPost[2];
                                    $postArray['description'] = $userPost[3];
                                    //$postArray['user_post_id'] = $userPost[0];
                                    //$postArray['user_post_time'] = $userPost[1];
                                    
                                    $usersObject[] = $postArray;
                                }
                                
                            }
                            
                        }
                    }
                    //echo "\n";
                    echo json_encode($usersObject);
                    //echo "\n\n";
                }
            }

            if ($this->post()) {
                if ($param == "user") {
                    
                    //header("Content-Type:application/json");
                    if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] === 'POST')) {
                        $strJsonFileContents = file_get_contents("php://input");
                        
                        //	echo json_decode($strJsonFileContents);
        
                        //	print_r($strJsonFileContents);
        
                        $decoder = json_decode($strJsonFileContents, true);
                        
                        $img_base64 = $decoder["image"];
                        $imgheader = $decoder["title"];
                        $imgdesc = $decoder["description"];
                        $username = $decoder["username"];
                        $password = $decoder["password"];
                        
                        $postedby = $userObject->getUserIdByUsername($username);

                        if($userid != null) {
                            if ($postedby == $userid) {
                                $hashed_password = $userObject->getHashedPasswordById($userid);
                                if (password_verify($password, $hashed_password)) {
                                    
                                    $imgstring = $img_base64;
                                    $ext = '';
                                    $image_name = uniqid();
                                    //checking whether the base64 code contains any of the given cases for picture extension.
                                    preg_match("/\b(webp|jpeg|JPEG|jpg|JPG|png|PNG|gif|GIF)\b/", $imgstring, $output_array);
                                    //echo $output_array[0];
                                    $image_name_with_ext = $image_name.'.'.$output_array[0];
    
                                    $path = '../app/uploads/'.$image_name_with_ext;
    
                                    $insertion_url = 'uploads/'.$image_name_with_ext;
    
                                    //echo "Logged in! ";
                                    
                                    $returnedId = $userObject->insertPost($imgheader,$imgdesc,$insertion_url,$userid);
                                    
                                    if ($returnedId != null) {

                                            $imgstring = trim( str_replace('data:image/'.$output_array[0].';base64,', "", $imgstring ) );
                                            
                                            
                                            $imgstring = str_replace( ' ', '+', $imgstring );
                                            $data = base64_decode( $imgstring );

                                            $status = file_put_contents($path, $data );
    
    
                                            if($status){
                                                //$imageIdString='{"image_id": "'.$returnedId.'"}"';
                                                $val = json_encode(array(
                                                    "image_id"=>$returnedId,
                                                    // "test2" =>'test',
                                                    // "description" => 'description'
                                                ));
                                                
                                                $data = json_decode($val);
                                                // return $data;
                                                //echo "\n";
                                                // $postObject = new Post();
                                                // $postObject->setPostId($insertCheck);
                                                
                                                //str_replace("\'","'",$imageIdString);
                                                echo json_encode($data);
                                                //echo "\n\n";
                                             //echo "Successfully Uploaded! ";
                                            }else{
                                             //echo "Upload failed... ";
                                            }
                                        
    
                                        //echo "Picture uploaded successfully! ";
                                    } else {
                                        echo "Cannot upload... ";
                                    }
                                }
                            } else {
                                echo "Userid doesn't match with the given username... ";
                            }
                            
                        } else { 
                            echo "Not logged in. 😞 ";
                        }
                    }
                }
            }
        }
    }
    
?>
