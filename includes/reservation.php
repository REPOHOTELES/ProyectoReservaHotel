<?php

/**
 * Clase reservation
 * Contiene las variables generales de una reserva
 */

class Reservation extends Database{
    protected $id;
    protected $startDate;
    protected $finishDate;
    protected $roomsQuantity;
    protected $titular;
    protected $room;

    /**
    * Constructor que recibe por parámetro un valor numérico id y lo asigna al id del cliente
    */
    public function setId($id){
        $this->id = $id;
        $query = $this->connect()->prepare('SELECT DISTINCT date_format(r.fecha_ingreso,"%X-%m-%d") fecha_ingreso, 
                date_format(r.fecha_salida,"%X-%m-%d") fecha_salida, 
                COUNT(rh.id_registro_habitacion) cantidad_habitaciones,
                r.id_titular, r.id_empresa
                FROM reservas r 
                INNER JOIN registros_habitacion rh ON rh.id_reserva=r.id_reserva
                WHERE r.id_reserva=:id
                GROUP BY fecha_ingreso');

        $query->execute([':id'=>$id]);

        foreach ($query as $current) {
            $this->startDate= $current['fecha_ingreso'];
            $this->finishDate= $current['fecha_salida'];
            $this->roomsQuantity= $current['cantidad_habitaciones'];
            $t=new Holder();

            if($current['id_titular']!=""){
                $t->setId($current['id_titular'],'T');
            }else{
                $t->setId($current['id_empresa'],'E');
            }

            $this->titular=$t;
        }
    }

    public function setId2($id){
        $this->id = $id;
        $query = $this->connect()->prepare('SELECT date_format(r.fecha_ingreso,"%X-%m-%d") fecha_ingreso, 
                date_format(r.fecha_salida,"%X-%m-%d") fecha_salida, 
                r.id_titular, r.id_empresa
                FROM reservas r 
                WHERE r.id_reserva=:id');

        $query->execute([':id'=>$id]);

        foreach ($query as $current) {
            $this->startDate= $current['fecha_ingreso'];
            $this->finishDate= $current['fecha_salida'];

            if($current['id_titular']==""){
                $t=new Enterprise();
                $t->setId($current['id_empresa']);
            }else{
                $t=new Person();
                $t->setId($current['id_titular']);
            }

            $this->titular=$t;
        }
    }

    public function setRoom($room){

         $query = $this->connect()->prepare('SELECT rh.id_registro_habitacion
                FROM reservas r 
                INNER JOIN registros_habitacion rh ON rh.id_reserva=r.id_reserva
                WHERE r.id_reserva=:id
                AND rh.id_habitacion=:room
                GROUP BY fecha_ingreso');

        $query->execute([':id'=>$this->id,':room'=>$room]);

        foreach ($query as $current) {
            $this->room= $current['id_registro_habitacion'];
        }
    }


    public function getRegRoom($id){
        $query = $this->connect()->prepare('SELECT numero_habitacion, valor_ocupacion, cantidad_huespedes
                FROM registros_habitacion rh
                INNER JOIN habitaciones h ON rh.id_habitacion=h.id_habitacion
                INNER JOIN tarifas t ON rh.id_tarifa=t.id_tarifa
                WHERE rh.id_reserva=:id
                AND rh.id_registro_habitacion=:reg_id');

        $query->execute([':id'=>$this->id,':reg_id'=>$id]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getRegRooms(){
        $query = $this->connect()->prepare('SELECT id_registro_habitacion
                FROM registros_habitacion rh
                WHERE rh.id_reserva=:id');

        $query->execute([':id'=>$this->id]);

        return $query;
    }

    public function getRegClients($id){
        $query = $this->connect()->prepare('SELECT p.id_persona, CONCAT_WS(" ",p.nombres_persona,p.apellidos_persona) nombres
                FROM registros_habitacion rh
                INNER JOIN registros_huesped rc ON rc.id_registro_habitacion=rh.id_registro_habitacion
                INNER JOIN personas p ON rc.id_huesped=p.id_persona 
                WHERE rh.id_reserva=:id
                AND rh.id_registro_habitacion=:reg_id');

        $query->execute([':id'=>$this->id,':reg_id'=>$id]);

        return $query;
    }

    public function getId(){
        return $this->id;
    }

    public function getStartDate(){
        return $this->startDate;
    }

    public function getFinishDate(){
        return $this->finishDate;
    }
    
    public function getRoomsQuantity(){
        return $this->roomsQuantity;
    }

    public function getTitular(){
        return $this->titular;
    }

    public function getRoom(){
        return $this->room;
    }
}

?>
