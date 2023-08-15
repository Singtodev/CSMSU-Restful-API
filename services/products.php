<?php


    namespace Service;
    class ProductService {

        private $db;

        public function __construct($db) {
            $this->db = $db;
        }


        public function getProductById($id){
            $sql = "SELECT * FROM products WHERE productCode = ? ";
            $result = $this->db->prepare($sql);
            $result->bind_param('s',$id);
            $result->execute();
            $result = $result->get_result();

            $$products = array();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    array_push($$products,$row);
                }

            }

            return $$products;
        }


        public function getAllProducts(){

            $sql = "SELECT * FROM products";
            $result = $this->db->query($sql);
            $products = array();
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        array_push($products,$row);
                    }
    
            }
    
            return $products;

        }

        public function insertProduct($data){
            try {
                $sql = "INSERT INTO products (
                    productCode,
                    productName,
                    productLine,
                    productScale,
                    productVendor,
                    productDescription,
                    quantityInStock,
                    buyPrice,
                    MSRP
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
                $stmt = $this->db->prepare($sql);
            
                // Assuming $data is an associative array containing your product data
                $stmt->bind_param(
                    'ssssssidd', // Corrected data types
                    $data['productCode'],
                    $data['productName'],
                    $data['productLine'],
                    $data['productScale'],
                    $data['productVendor'],
                    $data['productDescription'],
                    $data['quantityInStock'],
                    $data['buyPrice'],
                    $data['MSRP']
                );
            
                if ($stmt->execute()) {
                    if ($stmt->affected_rows == 1) {
                        return 'Insert Product Success';
                    } else {
                        return 'Insert Product Failed';
                    }
                } else {
                    // Check for unique constraint violation (MySQL-specific)
                    if ($this->db->errno === 1062) {
                        return 'Insert Product Failed: Duplicate entry';
                    } else {
                        return 'Insert Product Failed: ' . $this->db->error;
                    }
                }
            } catch (Exception $e) {
                return 'Insert Product Failed: ' . $e->getMessage();
            }
        }

        public function updateProductById($id , $data){
            try{
                $sql = "UPDATE products SET 
                productName = ?,
                productLine = ?,
                productScale = ?,
                productVendor = ?,
                productDescription = ?,
                quantityInStock = ?,
                buyPrice = ?,
                MSRP = ?
                WHERE productCode = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param(
                    'sssssidds', // Corrected data types
                    $data['productName'],
                    $data['productLine'],
                    $data['productScale'],
                    $data['productVendor'],
                    $data['productDescription'],
                    $data['quantityInStock'],
                    $data['buyPrice'],
                    $data['MSRP'],
                    $id,
                );
                if ($stmt->execute()) {
                    if ($stmt->affected_rows == 1) {
                        return 'Update Product Success';
                    } else {
                        return 'Update Product Failed';
                    }
                } else {
                    // Check for unique constraint violation (MySQL-specific)
                    if ($this->db->errno === 1062) {
                        return 'Update Product Failed: ';
                    } else {
                        return 'Update Product Failed: ' . $this->db->error;
                    }
                }
            }catch(Exception $e){
                return 'Something went wrong!';
            }

        }

        public function deleteProductById($data){

                if(empty($data['productCode']) || $data['productCode'] == '') return 'productCode is required.!';
    
                $sql = "DELETE FROM products WHERE productCode = ?  ";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param('s', $data['productCode']);
    
                if ($stmt->execute()) {
                    if ($stmt->affected_rows == 1) {
                        return 'Delete Product Success';
                    } else {
                        return 'Delete Product Failed';
                    }
                }
    

        }
        


    }

?>