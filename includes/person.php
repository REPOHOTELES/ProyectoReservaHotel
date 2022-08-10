<?php

/**
 * Clase person
 * Contiene las variables generales de una persona
 */

class Person extends Database{
    protected $id;
    protected $name;
    protected $lastName;
    protected $typeDocument;
    protected $numberDocument;
    protected $placeBirth;
    protected $placeExpedition;
    protected $gender;
    protected $birthDate;
    protected $typeRH;
    protected $phone;
    protected $email;
    protected $profession;

    /**
    * Constructor que recibe por parámetro un valor numérico id y lo asigna al id del cliente
    */
    public function setId($id){
        $this->id = $id;
        $query = $this->connect()->prepare('SELECT nombres_persona, apellidos_persona, tipo_documento, numero_documento,genero_persona, fecha_nacimiento, tipo_sangre_rh, telefono_persona, correo_persona, id_profesion, id_lugar_nacimiento,id_lugar_expedicion FROM personas p WHERE id_persona =:id');
        
        $query->execute(['id'=>$id]);
        
        foreach ($query as $currentPerson) {
            $this->name = $currentPerson['nombres_persona'];
            $this->lastName = $currentPerson['apellidos_persona'];
            $this->typeDocument = $currentPerson['tipo_documento'];
            $this->numberDocument = $currentPerson['numero_documento'];
            $this->placeBirth = $currentPerson['id_lugar_nacimiento'];
            $this->placeExpedition = $currentPerson['id_lugar_expedicion'];
            $this->gender = $currentPerson['genero_persona'];
            $this->birthDate = $currentPerson['fecha_nacimiento'];
            $this->typeRH = $currentPerson['tipo_sangre_rh'];
            $this->phone = $currentPerson['telefono_persona'];
            $this->email = $currentPerson['correo_persona'];
            $this->profession = $currentPerson['id_profesion'];
        } 
    }
    
  
    function getId(){
        return $this->id;
    }
    
    function getName(){
        return $this->name;
    }
    
    function getLastName(){
        return $this->lastName;
    }

    public function getFullName(){
        return $this->name.' '.$this->lastName;
    }
    
    function getTypeDocument(){
        return $this->typeDocument;
    }
    
    function getNumberDocument(){
        return $this->numberDocument;
    }
    
     function getPlaceBirth(){
        return $this->placeBirth;
    }
    
    function getPlaceExpedition(){
        return $this->placeExpedition;
    }
    
    function getGender(){
        return $this->gender;
    }
    
    function getBirthDate(){
        return $this->birthDate;
    }
    
    function getTypeRH(){
        return $this->typeRH;
    }
    
    function getPhone(){
        return $this->phone;
    }
    
    function getEmail(){
        return $this->email;
    }
    
    function getProfession(){
        return $this->profession;
    }
    
    function getSignRh(){
        return substr($this->typeRH, -1);
    }
    
    function getBlood(){
        return substr($this->typeRH, 0, strlen($this->typeRH)-1);
    }
    
    function getidSignRh(){
        switch($this->getSignRh()){
            case '+':
                return 0;
                break;
            case '-':
                return 1;
                break;
            default:
                return 0;
        }
    }
    
    function getIdBlood(){
        switch($this->getBlood()){
            case 'O':
                return 0;
                break;
            case 'A':
                return 1;
                break;
            case 'B':
                return 2;
                break;
            case 'AB':
                return 3;
                break;
            default:
                return 0;
        }
    }
}

?>
