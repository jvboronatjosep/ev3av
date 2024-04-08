<?php
    require_once "autoloader.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">

    <?php 

        $gestion = new Gestion();
        $gestion->getBrands();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if(isset($_POST['checkbox'])) {
    
                $gestion = new Gestion();
    
                foreach ($_POST['checkbox'] as $selectedCheckbox) {               
                    
                    $gestion->getClientsBrand($selectedCheckbox);
                    
                }
            } else {
                echo "No checkboxes were selected." . "<br>";
            }
        }
    ?>    
    
    
    <input type="submit" name="select" value="Select">
        
    </form>
</body>
</html>