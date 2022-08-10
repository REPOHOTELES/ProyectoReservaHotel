<?php

/**
* Se hacen las actualizaciones correspondientes en la base de datos de acuerdo a una acción que llega por POST
*/
     include 'database.php';
    
    switch ($_POST['action']) {
        case 'setCheckOn':
            setCheckOn();
            break;
        case 'deleteBooking':
            deleteBooking();
            break;
        case 'setCheckUp':
            setCheckUp();
            break;
        case 'setCheckOut':
            setCheckOut();
            break;
        case 'updateUser':
            updateUser();
            break;
        case 'deleteUser':
            deleteUser();
            break;
        case 'updateCustomer':
            updateCustomer();
            break;
        case 'deleteClient':
            deleteClient();
            break;
    }

    function setCheckOn(){
        $database=new Database();

        $update="UPDATE reservas SET estado_reserva = 'RE',fecha_ingreso = '".date('Y-m-d H:i:s')."'";

        if(isset($_POST['paymentMethod'])){
            $update=$update." ,medio_pago='".$_POST['paymentMethod']."', abono_reserva=".$_POST['amount'];
        }

        
        $update=$update." WHERE id_reserva = :idBooking";

        $query=$database->connect()->prepare($update);

        try{
            $query->execute([':idBooking'=>$_POST['idBooking']]);
            echo 'alert-s;Se ha cambiado el estado de la reserva.';
        }catch(PDOException $e){
            echo 'alert-d;Error U3.1. Error al actualizar estado de la reserva'.$update.$e->getMessage();
        }
    }

    function setCheckUp(){
        $database=new Database();

        $data=explode("?", $_POST['values']);
        $success=true;

        for ($i=0; $i < count($data)-1; $i++) { 
            $values=explode("_", $data[$i]);
            $update="UPDATE registros_huesped SET estado_huesped = '".$values[1]."' WHERE id_registro_huesped=".$values[0];
             $query=$database->connect()->prepare($update);
            try{
                $query->execute();
            }catch(PDOException $e){
                $success=false;
            }
        }
       

        if($success){
           
            echo 'alert-s;Se ha cambiado el estado de los huespedes de esta habitacion.';
        }else{
            echo 'alert-d;Error U5.1. Error al cambiar el estado de algun huesped'.$e->getMessage();
        }
    }

    function setCheckOut(){
        $database=new Database();

        $update="UPDATE reservas SET estado_reserva = 'TE',fecha_salida = '".date('Y-m-d H:i:s')."'";
        
        $update=$update." WHERE id_reserva = :idBooking";

        $query=$database->connect()->prepare($update);

        try{
            $query->execute([':idBooking'=>$_POST['idBooking']]);
            echo 'alert-s;Se ha cambiado el estado de la reserva.';
        }catch(PDOException $e){
            echo 'alert-d;Error U3.1. Error al actualizar estado de la reserva'.$update.$e->getMessage();
        }
    }

    function deleteBooking(){
        $database=new Database();

        $queryRH=$database->connect()->prepare("SELECT id_registro_habitacion FROM registros_habitacion WHERE id_reserva=".$_POST["id"]);
        $queryRH->execute();

        foreach ($queryRH as $current) {
            $database->connect()->exec("DELETE FROM registros_huesped WHERE id_registro_habitacion =".$current['id_registro_habitacion']);
        }

        $database->connect()->exec("DELETE FROM registros_habitacion WHERE id_reserva=".$_POST['id']);
        $query=$database->connect()->prepare("DELETE FROM reservas WHERE id_reserva=".$_POST['id']);

        try{
            $query->execute();
            echo 'alert-s;Se ha eliminado la reserva.';
        }catch(PDOException $e){
            echo 'alert-d;Error D3.1. Error al eliminar la reserva'.$e->getMessage();
        }
    }


    function updateUser(){
        $database=new Database();

        $update="UPDATE personas SET nombres_persona = '".$_POST['name']."', apellidos_persona = '".$_POST['lastName']."', tipo_documento = '".$_POST['typeDocument']."', numero_documento = '".$_POST['numberDocument']."', telefono_persona = '".$_POST['phone']."', id_cargo = ".$_POST['role'].", correo_persona = '".$_POST['email']."', nombre_usuario = '".$_POST['userName']."', contrasena_usuario = md5('".$_POST['password']."')";
        
        $update=$update." WHERE id_persona = ".$_POST['id'];

        $query=$database->connect()->prepare($update);

        try{
            $query->execute();
            echo 'alert-s;Se ha modificado al usuario satisfactoriamente';
        }catch(PDOException $e){
            echo 'alert-d;Error A5.2. Error al actualizar al usuario'.$update.$e->getMessage();
        }
    }

    function deleteUser(){
        $database=new Database();

        $queryRH=$database->connect()->prepare("SELECT CONCAT_WS(nombres_persona, apellidos_persona) AS nombres FROM personas WHERE id_persona=".$_POST["id"]);
        $queryRH->execute();
        $nameUser = "";
            
        foreach ($queryRH as $current) {
            $nameUser = $current['nombres'];
        }

        $query=$database->connect()->prepare("DELETE FROM personas WHERE id_persona=".$_POST['id']);

        try{
            $query->execute();
            echo 'alert-s;Se ha eliminado al usuario '.$nameUser.' satisfactoriamente';
        }catch(PDOException $e){
            echo 'alert-d;Error A5.3. Error al eliminar al usuario'.$e->getMessage();
        }
    
    }

    function updateCustomer(){
        $database=new Database();

        $update="UPDATE personas SET nombres_persona = '".$_POST['name']."', apellidos_persona = '".$_POST['lastName']."', tipo_documento = '".$_POST['typeDocument']."', numero_documento = '".$_POST['numberDoc']."', telefono_persona = '".$_POST['phone']."', correo_persona = '".$_POST['email']."', fecha_nacimiento = '".$_POST['birthDate']."', id_lugar_expedicion = ".$_POST['cityExp'].", genero_persona = '".$_POST['gender']."', tipo_sangre_rh = '".$_POST['typeBlood']."', id_profesion = ".$_POST['profession'].", id_lugar_nacimiento = ".$_POST['countryExp']."";
        
        $update=$update." WHERE id_persona = ".$_POST['id'];

        $query=$database->connect()->prepare($update);

        try{
            $query->execute();
            echo 'alert-s;Se ha modificado al cliente satisfactoriamente';
        }catch(PDOException $e){
            echo 'alert-d;Error A5.2. Error al actualizar al cliente'.$update.$e->getMessage();
        }
    }

    function deleteClient(){
        $database=new Database();

        $queryRH=$database->connect()->prepare("SELECT CONCAT_WS(nombres_persona, apellidos_persona) AS nombres FROM personas WHERE id_persona=".$_POST["id"]);
        $queryRH->execute();
        $nameUser = "";
            
        foreach ($queryRH as $current) {
            $nameUser = $current['nombres'];
        }

        $query=$database->connect()->prepare("DELETE FROM personas WHERE id_persona=".$_POST['id']);

        try{
            $query->execute();
            echo 'alert-s;Se ha eliminado al usuario '.$nameUser.' satisfactoriamente';
        }catch(PDOException $e){
            echo 'alert-d;Error A5.3. Error al eliminar al usuario'.$e->getMessage();
        }
    
    }

?>
