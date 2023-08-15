<?php

    namespace Service;
    class EmployeeService {

        private $db;

        public function __construct($db) {
            $this->db = $db;
        }


        public function getEmployeeById($id){
            $sql = "SELECT * FROM employees WHERE employeeNumber = ? ";
            $result = $this->db->prepare($sql);
            $result->bind_param('i',$id);
            $result->execute();
            $result = $result->get_result();

            $employees = array();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    array_push($employees,$row);
                }

            }

            return $employees;
        }


        public function getAllEmployees(){
            $sql = "SELECT * FROM employees";
            $result = $this->db->query($sql);
            $employees = array();
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    array_push($employees,$row);
                }

            }

            return $employees;
        }

        public function insertEmployees($data){

                try {

                    $options = [
                        'cost' => 10
                    ];

                    $psh = password_hash($data['password'], PASSWORD_BCRYPT, $options);
                    $sql = "INSERT INTO employees(employeeNumber, lastName, firstName, extension, email, password, officeCode, reportsTo, jobTitle) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $this->db->prepare($sql);
                    $stmt->bind_param(
                        'isssssiss',
                        $data['employeeNumber'],
                        $data['lastName'],
                        $data['firstName'],
                        $data['extension'],
                        $data['email'],
                        $psh,
                        $data['officeCode'],
                        $data['reportsTo'],
                        $data['jobTitle']
                    );
                       
                    if ($stmt->execute()) {
                        if ($stmt->affected_rows == 1) {
                            return 'Insert Employee Success';
                        } else {
                            return 'Insert Employee Failed';
                        }
                    } else {
                        // Check for unique constraint violation (MySQL-specific)
                        if ($this->db->errno === 1062) {
                            return 'Insert Employee Failed: Email already exists.';
                        } else {
                            return 'Insert Employee Failed: ' . $this->db->error;
                        }
                    }

                } catch (Exception $e) {
                    return 'Insert Employee Failed: ' . $e->getMessage();
                }
        }

        public function updateEmployeeById($emp_number , $data){
            try{

                if (empty($emp_number) || $emp_number == '' || !$emp_number) {
                    return 'EmployeeNumber is required!';
                }
    
                // query user
    
                $userAlready = $this->getEmployeeById($emp_number);
    
    
                if(!$userAlready){
                    return 'User not found';
                }
                
    
    
                $options = [
                    'cost' => 10
                ];
                
                $psh = password_hash($data['password'], PASSWORD_BCRYPT, $options);
                
                $sql = "UPDATE employees SET lastName=?, firstName=? , extension=? ,email=? , password=?, jobTitle = ? , officeCode = ? , reportsTo = ? WHERE employeeNumber = ?";
                $stmt = $this->db->prepare($sql);
                
                if (!$stmt) {
                    return 'Update Employee Failed: ' . $this->db->error;
                }
    
    
                $stmt->bind_param(
                    'ssssssssi',
                    $data['lastName'],
                    $data['firstName'],
                    $data['extension'],
                    $data['email'],
                    $psh,
                    $data['jobTitle'],
                    $data['officeCode'],
                    $data['reportsTo'],
                    $emp_number
                );
                
                if ($stmt->execute()) {
                    if ($stmt->affected_rows == 1) {
                        return 'Update Employee Success';
                    } else {
                        return 'Update Employee Failed';
                    }
                } else {

                    return 'Update Employee Failed: ' . $stmt->error;
                }
    
            }catch(err){
                return 'Update Employee';
            }
        }

        public function deleteEmployeeById($data){
            
            if(empty($data['employeeNumber']) || $data['employeeNumber'] == '') return 'EmployeeNumber is required.!';

            $sql = "DELETE FROM employees WHERE employeeNumber = ?  ";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param('i', $data['employeeNumber']);

            if ($stmt->execute()) {
                if ($stmt->affected_rows == 1) {
                    return 'Delete Employee Success';
                } else {
                    return 'Delete Employee Failed';
                }
            }

        }
        


    }

?>