<?php

include_once "Connection.php";


class Gestion extends Connection {
    public function getBrands(){
        
        $this->connect();
        $conn = $this->getConn();

        $sql = "SELECT brandId, brandName FROM brands";

        $result = $conn->query($sql);

        while ($brand = $result->fetch_assoc()){
            echo "<input type='checkbox' value='".$brand["brandId"]."' name=checkbox[]> ".$brand["brandName"]." <br>";        
        }

        $conn->close();
    }

    public function getClientsBrand($brandId) {
        $this->connect();
        $conn = $this->getConn();

        $sql = "SELECT * FROM `brandCustomer` INNER JOIN customers ON customers.customerId = brandCustomer.customerId Where brandId = ".$brandId;

        $result = $conn->query($sql);

        $brandName = $this->getBrandName($brandId);

        echo "<h2>La marca $brandName le gusta a: </h2>";

        while ($clients = $result->fetch_assoc()){
            echo "<p>" .$clients["customerName"]. "</p>";       
        }

        $conn->close();        
    }

    private function getBrandName($brandId) {
        $this->connect();
        $conn = $this->getConn();

        $consulta = $conn->prepare("SELECT brandName FROM brands WHERE brandId = ?");
        $consulta->bind_param("s", $brandId);
        $consulta->execute();
        $result = $consulta->get_result();    

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $brandName = $row['brandName'];
            return $brandName;
        } else {

            return null;
        }
    }    
}




?>