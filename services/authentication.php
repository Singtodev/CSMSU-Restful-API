<?php


    namespace Service;

    class Authentication {
        

        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function isLoggedIn() {
            return true;  // Placeholder implementation, update as needed
        }

        public function login($data) {
            $sql = "SELECT * FROM employees WHERE email = ? ";
            $result = $this->db->prepare($sql);
            $result->bind_param('s',$data['email']);
            $result->execute();
            $result = $result->get_result();

            if($result->num_rows > 0){
                // password hash 
                $result = $result->fetch_assoc();
                $verifyPassword = password_verify($data['password'],$result['password']);

                if($verifyPassword){
                    return $result;
                }else{
                    return 'Password incorrect Please try again.';
                }
                
            }else{
                return 'User Not Found!';
            }

            // Placeholder implementation for login, update as needed
        }

        public function register() {


                // $options = [
                //     'cost' => 10
                // ];
                
                // return password_hash($data['password'], PASSWORD_BCRYPT, $options);

            // Placeholder implementation for registration, update as needed
        }

        public function forgotPassword() {
            // Placeholder implementation for forgot password, update as needed
        }
    }
?>