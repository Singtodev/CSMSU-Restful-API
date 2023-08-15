<?php

    namespace Service;
    class CustomerService {

        private $db;

        public function __construct($db) {
            $this->db = $db;
        }


        public function getCustomerById($id){
            try{
                $sql = "SELECT * FROM customers WHERE customerNumber = ? ";
                $result = $this->db->prepare($sql);
                $result->bind_param('i',$id);
                $result->execute();
                $result = $result->get_result();
                $customer = array();
    
                if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                                array_push($customer,$row);
                        }
            
                }
            
                return $customer;
            }catch(Exception $e){
                return [];
            }

        }


        public function getAllCustomers(){
            try{
                $sql = "SELECT * FROM customers WHERE customerNumber ";
                $result = $this->db->prepare($sql);
                $result->execute();
                $result = $result->get_result();
                $customer = array();
    
                if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                                array_push($customer,$row);
                        }
            
                }
            
                return $customer;
            }catch(Exception $e){
                return [];
            }
        }

        public function getAllCustomersBySearch($keyword){
            try{
                $search_word = '%' . $keyword . '%';

                $sql = "SELECT * FROM customers 
                        WHERE customerNumber LIKE ? 
                        OR customerName LIKE ? 
                        OR  contactLastName LIKE ? 
                        OR contactFirstName LIKE ? 
                        OR phone LIKE ?
                        OR addressLine1 LIKE ?
                        OR addressLine2 LIKE ?
                        OR city LIKE ?
                        OR state LIKE ?
                        OR state LIKE ?
                        OR country LIKE ?
                        OR salesRepEmployeeNumber LIKE ?
                        OR creditLimit LIKE ?
                        or postalCode LIKE ?
    
                         ";
                $result = $this->db->prepare($sql);
                
                if (!$result) {
                    // Handle error if prepare fails
                    die("Error: " . $this->db->error);
                }
                
                $result->bind_param('ssssssssssssss', $keyword,
                 $search_word,
                 $search_word,
                 $search_word,
                 $search_word,
                 $search_word,
                 $search_word,
                 $search_word,
                 $search_word,
                 $search_word,
                 $search_word,
                 $search_word,
                 $search_word,
                 $search_word,
                );
                
                $result->execute();
                $result = $result->get_result();
                $customer = array();
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $customer[] = $row;
                    }
                }
                
                return $customer;
            }catch(Exception $e){
                return [];
            }
        }



        public function insertCustomer($data){
            try {
                $sql = "INSERT INTO customers(
                        customerNumber,
                        customerName,
                        contactLastName,
                        contactFirstName,
                        phone,
                        addressLine1,
                        addressLine2,
                        city,
                        state,
                        postalCode,
                        country,
                        salesRepEmployeeNumber,
                        creditLimit
                    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param(
                    'issssssssssid',
                    $data['customerNumber'],
                    $data['customerName'],
                    $data['contactLastName'],
                    $data['contactFirstName'],
                    $data['phone'],
                    $data['addressLine1'],
                    $data['addressLine2'],
                    $data['city'],
                    $data['state'],
                    $data['postalCode'],
                    $data['country'],
                    $data['salesRepEmployeeNumber'],
                    $data['creditLimit']
                );
                   
                if ($stmt->execute()) {
                    if ($stmt->affected_rows == 1) {
                        return 'Insert Customer Success';
                    } else {
                        return 'Insert Customer Failed';
                    }
                } else {
                    // Check for unique constraint violation (MySQL-specific)
                    if ($this->db->errno === 1062) {
                        return 'Insert Customer Failed: ';
                    } else {
                        return 'Insert Customer Failed: ' . $this->db->error;
                    }
                }

            } catch (Exception $e) {
                return 'Insert Customer Failed: ' . $e->getMessage();
            }
        }


        public function updateCustomerById($id, $data){
            try {

                if(!$id || empty($id) || !$data || empty($data)) return 'Required Customer id';

                $sql = "UPDATE customers SET customerName=?,contactLastName=?,contactFirstName=?,phone=?,addressLine1=?,addressLine2=?,city=?,state=?,postalCode=?,country=?,salesRepEmployeeNumber=?,creditLimit=? WHERE customerNumber = ? ";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param(
                    'ssssssssssidi',
                    $data['customerName'],
                    $data['contactLastName'],
                    $data['contactFirstName'],
                    $data['phone'],
                    $data['addressLine1'],
                    $data['addressLine2'],
                    $data['city'],
                    $data['state'],
                    $data['postalCode'],
                    $data['country'],
                    $data['salesRepEmployeeNumber'],
                    $data['creditLimit'],
                    $id,
                );
                   
                if ($stmt->execute()) {
                    if ($stmt->affected_rows == 1) {
                        return 'Update Customer Success';
                    } else {
                        return 'Update Customer Failed';
                    }
                } else {
                    // Check for unique constraint violation (MySQL-specific)
                    if ($this->db->errno === 1062) {
                        return 'Update Customer Failed: ';
                    } else {
                        return 'Update Customer Failed: ' . $this->db->error;
                    }
                }

            } catch (Exception $e) {
                return 'Update Customer Failed: ' . $e->getMessage();
            }
        }

        public function deleteCustomerById($data){
            try{
                if(empty($data['customerNumber']) || $data['customerNumber'] == '') return 'CustomerNumber is required.!';

                $sql = "DELETE FROM customers WHERE customerNumber = ?  ";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param('i', $data['customerNumber']);
    
                if ($stmt->execute()) {
                        if ($stmt->affected_rows == 1) {
                            return 'Delete CustomerNumber Success';
                        } else {
                            return 'Delete CustomerNumber Failed';
                        }
                }
            }catch(Exception $e){

                return 'Delete CustomerNumber Failed';

            }
        }

        
        


    }

?>