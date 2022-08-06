<?php
    /**
    * Clase enterprise, contiene los datos de una empresa determinada, de acuerdo con la lógica del negocio
    * @package   includes
    * @author   Grupo 3 SW2
    * @copyright Todos los derechos reservados. 2022.
    * @since     Versión 1.0
    * @version   1.0
    */

    class Enterprise extends Database {
        
        protected $id;
        protected $name;
        protected $nit;
        protected $email;
        protected $phone;
        protected $sourceRetention;
        protected $ica;
        
        
        /**
        * Constructor que recibe por parámetro un valor numérico id, lo asigna al id de la empresa y realiza una consulta en la base de
        * datos para asignar la información solicitada a cada uno de los atributos de la clase
        * @param Integer id que contiene la empresa que se está consultando
        */
        public function setIdEnterprise($id){
            $this->id = $id;
            $query = $this->connect()->prepare('SELECT nombre_empresa, nit_empresa, correo_empresa, telefono_empresa, retefuente, ica FROM empresas WHERE id_empresa = :id');

            $query->execute(['id'=>$id]);

            foreach ($query as $currentEnterprise) {
                $this->name = $currentEnterprise['nombre_empresa'];
                $this->nit = $currentEnterprise['nit_empresa'];
                $this->email = $currentEnterprise['correo_empresa'];
                $this->phone = $currentEnterprise['telefono_empresa'];
                $this->sourceRetention = $currentEnterprise['retefuente'];
                $this->ica = $currentEnterprise['ica'];
            } 
        }

        public function setId($id){
            $this->setIdEnterprise($id);
        }
        
        /**
        * Obtiene el id de la empresa, de acuerdo a la consulta realizada en la base de datos
        * @return int id de la empresa
        **/
        function getId(){
            return $this->id;
        }
        
        /**
        * Obtiene el nombre de la empresa, de acuerdo a la consulta realizada en la base de datos
        * @return string nombre de la empresa
        **/
        function getName(){
            return $this->name;
        }

        public function getFullName(){
            return $this->name;
        }
        
        /**
        * Obtiene el NIT de la empresa, de acuerdo a la consulta realizada en la base de datos
        * @return int NIT de la empresa
        **/
        function getNit(){
            return $this->nit;
        }
        
        /**
        * Obtiene el correo electrónico de la empresa, de acuerdo a la consulta realizada en la base de datos
        * @return string correo electrónico de la empresa
        **/
        function getEmail(){
            return $this->email;
        }
        
        /**
        * Obtiene el teléfono de la empresa, de acuerdo a la consulta realizada en la base de datos
        * @return string teléfono de la empresa
        **/
        function getPhone(){
            return $this->phone;
        }
        
        /**
        * Obtiene el valor de retención de fuente, de acuerdo a la consulta realizada en la base de datos
        * @return byte En caso de que la empresa presente retención de fuente, retorna 1, de lo contrario retorna 0
        **/
        function getSourceRetention(){
            return $this->sourceRetention;
        }
        
        /**
        * Obtiene el valor de otro impuesto en caso de que la empresa solicitada lo contenga, de acuerdo a la consulta realizada en la base 
        * de datos
        * @return Float Valor de otro impuesto
        **/
        function getICA(){
            return $this->ica;
        }   
    }
?>
