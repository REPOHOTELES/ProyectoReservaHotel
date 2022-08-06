<?php
/**
*Obtiene un titular dependiendo si es empresa o persona
*/
class Holder extends Database {
	protected $id;
	protected $identification;
	protected $name;
	protected $phone;
	protected $email;

	public function setId($id,$type){
		$this->id = $id;

		if($type=='T'){
			$query = $this->connect()->prepare('SELECT CONCAT_WS(" ",nombres_persona,apellidos_persona) nombre,numero_documento doc, telefono_persona telefono,correo_persona correo
				FROM personas WHERE id_persona=:id');
		}else{
			$query = $this->connect()->prepare('SELECT nombre_empresa nombre,nit_empresa doc, telefono_empresa telefono,correo_empresa correo
				FROM empresas WHERE id_empresa=:id');
		}

        $query->execute([':id'=>$id]);

        foreach ($query as $current) {
            $this->identification= $current['doc'];
            $this->name= $current['nombre'];
            $this->phone= $current['telefono'];
            $this->email=$current['correo'];
        }
	}

	public function getId(){
		return $this->id;
	}

	public function getIdentification(){
		return $this->identification;
	}

	public function getName(){
		return $this->name;
	}

	public function getPhone(){
		return $this->phone;
	}
	
	public function getEmail(){
		return $this->email;
	} 
}
?>
