<?php
/**
*Clase Room
* Contiene las variables generales para una habitación
*/
class Room extends Database{
	   
	protected $id;
    protected $number;
    protected $type;
    protected $reservation;

    /**
    * Constructor que recibe por parámetro un valor numérico id y lo asigna al id del cliente
    */
    public function setId($id){
        $this->id = $id;
        $query = $this->connect()->prepare('SELECT id_habitacion,numero_habitacion,id_tipo_habitacion
        	FROM habitaciones h
        	WHERE id_habitacion=:id');

        $query->execute([':id'=>$id]);

        foreach ($query as $current) {
            $this->number= $current['numero_habitacion'];
            $this->type= $current['id_tipo_habitacion'];
        }
    }

    public function getId(){
    	return $this->id;
    }

    public function getNumber(){
        return $this->number;
    }

    public function getType(){
        return $this->type;
    }
}
?>
