<?php


    namespace Service;

    use Service\EmployeeService;

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


        public function forgotPassword($data) {
            // Placeholder implementation for forgot password, update as needed

            try{
                $emp_srv = new EmployeeService($this->db);

                $customerAlready = $emp_srv->getEmployeeByEmail($data['email']);
    
                if(!$customerAlready) return 'Not found Employee !';
    
                // decode hash password
                $verifyPassword = password_verify($data['password'],$customerAlready[0]['password']);
    
                // check password is current 
                if($verifyPassword){
                    return 'Your password matches the current one.';
                } 
    
                
                // change password
                $id = $customerAlready[0]['employeeNumber'];
                $customerAlready[0]['password'] = $data['password'];
                
    
                $result = $emp_srv->updateEmployeeById($id , $customerAlready[0]);
                
                
                return $result == 'Update Employee Success' ? 'Update New Password Success' : 'Update Password Failed.!';
            }catch(Exception $e){
                return 'Something went wrong please try again';
            }


        }
    }
?>