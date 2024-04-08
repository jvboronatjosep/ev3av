<?php

include_once "Connection.php"; 

class Importar extends Connection { 

    public function customers() {
        $this->connect();
        $conn = $this->getConn();

        if (($gestor = fopen("customers.csv", "r")) !== FALSE) {
            $consulta = $conn->prepare("UPDATE customers SET customerName = ? WHERE customerId = ?");

            if ($consulta) {
                while (($datos = fgetcsv($gestor, 1000, "#")) !== FALSE) {
                    $nombreCliente = $datos[1];
                    $nombreId = $datos[0];
                    $consulta->bind_param("ss", $nombreCliente, $nombreId); 
                    if (!$consulta->execute()) {
                        echo "Error en la inserción: " . $conn->error . "\n"; 
                    }
                }
                
                $consulta->close();
                fclose($gestor);
                echo "Importación completada.\n";
            } else {
                echo "Error al preparar la consulta: " . $conn->error . "\n";
            }
        } else {
            echo "No se pudo abrir el archivo CSV.\n";
        }
        
        $conn->close();
    }
    
    
    public function getBrandId($brand) {
        $this->connect();
        $conn = $this->getConn();

        $consulta = $conn->prepare("SELECT brandId FROM brands WHERE brandName = ?");
        $consulta->bind_param("s", $brand);
        $consulta->execute();
        $result = $consulta->get_result();    

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $brandId = $row['brandId'];
            return $brandId;
        } else {

            return null;
        }
    }
    

    public function brandCustomer() {
        $this->connect();
        $conn = $this->getConn();

        if (($gestor = fopen("customers.csv", "r")) !== FALSE) {


            $consulta = $conn->prepare("INSERT INTO brandCustomer (brandId, customerId) VALUES (?,?)");

            if ($consulta) {
                while (($datos = fgetcsv($gestor, 1000, "#")) !== FALSE) {

                    $brands = $datos[2];
                    $customerId = $datos[0];

                    if ($brands !== '') {

                    $brandlist = explode(", ", $brands);

                    foreach ($brandlist as $brand) {                        
                        
                        $brandId = $this->getBrandId($brand);

                        if ($brandId !== null) { 
                            $consulta->bind_param("ss", $brandId, $customerId); 
                            if (!$consulta->execute()) {
                                echo "Error en la inserción: " . $conn->error . "\n"; 
                            }                      
                    
                        };
                    }
                }
            }
                
                $consulta->close();
                fclose($gestor);
                echo "Importación completada.\n";
            } else {
                echo "Error al preparar la consulta: " . $conn->error . "\n";
            }
        } else {
            echo "No se pudo abrir el archivo CSV.\n";
        }
        
        $conn->close();
    }
    

}


?>
