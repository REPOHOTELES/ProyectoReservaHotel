<?php 

	require '../../includes/database.php';

	switch ($_POST['entity']) {
		case 'reservation':
			updateReservation();
			break;
		case 'room':
			updateRoom();
			break;
		case 'person':
			updatePerson();
			break;
		case 'guestReg':
			updateGuestBook();
			break;
	}

	function updateReservation(){
		$database= new Database();

		$update="UPDATE reservas SET fecha_ingreso = '".$_POST['startDate']."', fecha_salida = '".$_POST['finishDate']."', id_usuario = '".$_POST['user']."', estado_reserva = 'AC', estado_pago_reserva = 'P', abono_reserva = ".$_POST['amount']."";
        
       
		
		if(isset($_POST['holder'])){
			$update=$update.",id_titular=".$_POST['holder'];
		}else{
			$update=$update.",id_empresa=".$_POST['enterprise'];
		}

		if(isset($_POST['paymentMethod'])){
			$update=$update.",medio_pago".$_POST['paymentMethod']."'";
		}

		$update=$update." WHERE id_reserva = ".$_POST['idBooking'];

		try{
			$pdo=$database->connect();
			$query=$pdo->exec($update);
			$idBooking=$_POST['idBooking'];
			echo $idBooking.';'.(isset($_POST['holder'])?$_POST['holder']:$_POST['enterprise']).';Se ha registrado una nueva reserva.('.$idBooking.')';
		}catch(PDOException $e){
			echo 'null;Error C3.1. Error al modificar nueva reserva'.$e->getMessage()."\n".$update;
		}
	}


	function updatePerson(){
		$database= new Database();

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

	function updateRoom(){
		$database= new Database();

		$pQuery=$database->connect()->prepare("SELECT id_tarifa FROM tarifas WHERE valor_ocupacion=".(isset($_POST['tariffValue'])?$_POST['tariffValue']:"0"));
		$pQuery->execute();

		if($pQuery->rowCount()){
            $tariff=$pQuery->fetch();
            $tariffId=$tariff['id_tarifa'];
        }else{
        	$database->connect()->exec('ALTER TABLE tarifas AUTO_INCREMENT = 1');
        	$pQuery=$database->connect()->prepare("SELECT id_tipo_habitacion FROM habitaciones WHERE id_habitacion=".$_POST['roomNumber']);
        	$pQuery->execute();
        	$roomType=$pQuery->fetch();
        	$pdo=$database->connect();
        	$pdo->exec("INSERT INTO tarifas (id_tipo_habitacion,valor_ocupacion,predeterminado)
        		VALUES (".$roomType['id_tipo_habitacion'].",".$_POST['tariffValue'].",0)");
        	 $tariffId=$pdo->lastInsertId();
        }

		$insert='INSERT INTO registros_habitacion(id_reserva, id_habitacion, id_tarifa, estado_registro';
		$values=$_POST['bookingId'].",".$_POST['roomNumber'].",".$tariffId.",'CI'";


		$insert=$insert.")\n VALUES (".$values.');';
		$database->connect()->exec('ALTER TABLE registros_habitacion AUTO_INCREMENT = 1');

		try{
			$pdo=$database->connect();
			$pdo->exec($insert);
			$idRoom=$pdo->lastInsertId();
			echo $idRoom.';Se ha asignado una habitacion a la reserva. ('.$idRoom.')';
		}catch(PDOException $e){
			echo 'null;Error C2.1. Error al ingresar nuevo registro'."\n".$insert.$e->getMessage();;
		}

		$database->connect()->exec('ALTER TABLE registros_habitacion AUTO_INCREMENT = 1');
	}
	

	function updateGuestBook(){
		$database= new Database();

		$insert='INSERT INTO registros_huesped (id_registro_habitacion,id_huesped,estado_huesped';
		$values=$_POST['roomReg'].",".$_POST['guestId'].",'CO'";

		$insert=$insert.")\n VALUES (".$values.");";
		$database->connect()->exec('ALTER TABLE registros_huesped AUTO_INCREMENT = 1');

		try{
			$pdo=$database->connect();
			$query=$pdo->exec($insert);
			echo $pdo->lastInsertId().';Se ha asignado un huesped a la reserva.';
		}catch(PDOException $e){
			echo 'null;Error C3.1. Error al ingresar nuevo registro'.$e->getMessage().'\n'.$insert;
		}

		$database->connect()->exec('ALTER TABLE registros_huesped AUTO_INCREMENT = 1');
	}

?>
