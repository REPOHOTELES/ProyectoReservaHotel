<?php
    /**
    * Archivo que contiene la información pertinente a las consultas realizadas a la base de datos para generar correctamente las salidas del sistema
    * @package   includes
    * @author    Grupo 3 SW2
    * @copyright Todos los derechos reservados. 2022.
    * @since     Versión 1.0
    * @version   1.0
    */

    /**
    * Clase que extiende de Database y se encarga de almacenar las funciones referrentes a la consulta en la base de datos
    */
    class Consult extends Database {
        private $user;

        /**
        * Constructor de la clase que asigna un valor al atributo $user, siempre y cuando el valor que llega por parámetro no es nulo
        * @param $user Usuario que actualmente se encuentra logueado en el sistema
        */
        public function __construct($user=null){
            parent::__construct();
            $this->user=$user;
        }

        /**
        * Obtiene una consulta por medio de una lista, dependiendo de los valores pasados por parámetro
        * @param $entity Entidad a la cual se le va a realizar la lista
        * @param $aux Variable auxiliar que puede llegar nula
        * @param $aux2 Variable auxiliar usada para algunas consultas, y puede llegar como un valor nulo
        */
        public function getList($entity, $aux=null,string $aux2=null){
            switch ($entity) {
                case 'roomType':
                    $this->roomTypeList($aux);
                    break;
                case 'roomQuantity':
                    $this->roomQuantityList($aux);
                    break;

                case 'enterprise':
                    $this->enterpriseList();
                    break;

                case 'country':
                    $this->countryList();
                    break;

                case 'profession':
                    $this->professionList();
                    break;

                case 'city':
                    $this->cityList($aux);
                break;

                case 'tariff':
                    $this->tariffList($aux,$aux2);
                    break;
                    
                case 'role':
                    $this->getRoleList();
                    break;
            }
        }
            
        /**
        * Se encarga de la construcción de una tabla para las salidas del sistema; dicha tabla va a depender de los valores que se pasen por parámetro
        * @param $entity Entidad a la cual se le va a construir la tabla
        * @param $aux Valor auxiliar que se puede necesitar en ciertas funciones. Puede ser un valor nulo
        */
        public function getTable($entity, $aux=null){
            switch ($entity) {
                case 'room':
                    $this->roomTable($aux);
                break;

                case 'enterprise':
                    $this->enterpriseTable();
                break;

                case 'rol':
                    $this->userComboRol();
                break;

                case 'type_document':
                    $this->typeDocument();
                break;

                case 'customers':
                    $this->customerTable();
                    break;
                    
                case 'users':
                    $this->userTable();
                    break;

                case 'reservation':
                    $this->reservationTable();
                    break;
                
                case 'bill':
                    $this->billTable();
                    break;
            }
        }

    
        /**
        * Construye una lista de ciudades de acuerdo al pais que llega por parámetro
        * @param $country entidad que es pasada por parámetro
        */
        function cityList($country){
            $query = $this->connect()->prepare('SELECT id_lugar,nombre_lugar 
                FROM lugares 
                WHERE tipo_lugar="C" AND id_ubicacion=:country ORDER BY nombre_lugar');
            $query->execute(['country'=>$country]);

            foreach ($query as $current) {
                echo '<option value="'.$current['id_lugar'].'">'.$current['nombre_lugar'].'</option>';
            }
        }

        /**
        * Obtiene una lista de productos 
        */
        public function getProductList(){
             $query = $this->connect()->prepare('SELECT id_producto,nombre_producto, valor_producto
                FROM productos');
            $query->execute();

            foreach ($query as $current) {
                echo '<option value="'.$current['id_producto'].'">'.$current['nombre_producto'].' ('.$current['valor_producto'].') '.'</option>';
            }
        }

        /**
        * Obtiene una lista de servicios
        */
        public function getServiceList(){
             $query = $this->connect()->prepare('SELECT id_servicio,nombre_servicio, valor_servicio
                FROM servicios');
            $query->execute();

            foreach ($query as $current) {
                echo '<option value="'.$current['id_servicio'].'">'.$current['nombre_servicio'].' ('.$current['valor_servicio'].') '.'</option>';
            }
        }

        /**
        * Obtiene una lista de paises
        */
        public function countryList(){
            $query = $this->connect()->prepare('SELECT id_lugar,nombre_lugar 
                FROM lugares 
                WHERE tipo_lugar="P"');
            $query->execute();

            foreach ($query as $current) {
                echo '<option value="'.$current['id_lugar'].'">'.$current['nombre_lugar'].'</option>';
            }
        }
        
        /**
        * Obtiene una lista de profesiones
        */
        public function professionList(){
            $query = $this->connect()->prepare('SELECT id_profesion,nombre_profesion FROM profesiones');
            $query->execute();

            foreach ($query as $current) {
                echo '<option value="'.$current['id_profesion'].'">'.$current['nombre_profesion'].'</option>';
            }
        }

        /**
        * Obtiene una lista de empresas
        */
        public function enterpriseList(){
            $query = $this->connect()->prepare('SELECT id_empresa,nombre_empresa, nit_empresa FROM empresas ORDER BY nit_empresa');
            $query->execute();

            foreach ($query as $current) {
                echo '<option value="'.$current['id_empresa'].'">'.$current['nit_empresa'].' - '.$current['nombre_empresa'].'</option>';
            }
        }

        /**
        * Construye una lista de habitaciones de acuerdo a los parámetros asignados
        * @param $type Tipo de habitación
        * @param $startDate Fecha de ingreso de huésped (es)
        * @param $finishDate Fecha de salida de huésped (es)
        */
        public function roomTypeList($type,$startDate,$finishDate){
            $query = $this->connect()->prepare('SELECT id_habitacion,numero_habitacion 
                FROM habitaciones h 
                INNER JOIN tipos_habitacion th ON h.id_tipo_habitacion=th.id_tipo_habitacion
                WHERE th.id_tipo_habitacion=:type
                AND id_habitacion NOT IN (
                SELECT id_habitacion
                FROM registros_habitacion rh 
                INNER JOIN reservas r ON rh.id_reserva=r.id_reserva 
                WHERE (date_format(r.fecha_ingreso,"%X-%m-%d")='.$startDate.'
                OR (date_format(r.fecha_ingreso,"%X-%m-%d")>'.$startDate.' AND date_format(r.fecha_ingreso,"%X-%m-%d")<'.$finishDate.')
                OR (date_format(r.fecha_salida,"%X-%m-%d")>'.$startDate.' AND date_format(r.fecha_salida,"%X-%m-%d")<'.$finishDate.')
                OR (date_format(r.fecha_ingreso,"%X-%m-%d")<'.$startDate.' AND date_format(r.fecha_salida,"%X-%m-%d")>'.$finishDate.')
                ) AND (r.estado_reserva="AC" OR r.estado_reserva="RE"))');


            $query->execute([':type'=>$type]);
            
            foreach ($query as $current) {
                echo '<option value="'.$current['id_habitacion'].'">'.$current['numero_habitacion'].'</option>';
            }
            return false;
        }

        /**
        * Construye una lista con la cantidad de habitaciones de acuerdo a los parámetros asignados
        * @param $quantity Cantidad de huespedes para ser consultadas
        * @param $startDate Fecha de ingreso de huésped (es)
        * @param $finishDate Fecha de salida de huésped (es)
        */
        public function roomQuantityList($quantity,$startDate,$finishDate){
            try {
                $query = $this->connect()->prepare('SELECT DISTINCT th.id_tipo_habitacion,th.nombre_tipo_habitacion
                FROM tipos_habitacion th 
                INNER JOIN tarifas t ON t.id_tipo_habitacion=th.id_tipo_habitacion
                INNER JOIN habitaciones h ON h.id_tipo_habitacion=th.id_tipo_habitacion
                WHERE t.cantidad_huespedes=:quantity
                AND h.numero_habitacion NOT IN (
                SELECT numero_habitacion
                FROM habitaciones h
                INNER JOIN registros_habitacion rh ON rh.id_habitacion=h.id_habitacion 
                INNER JOIN reservas r ON rh.id_reserva=r.id_reserva 
                WHERE (date_format(r.fecha_ingreso,"%X-%m-%d")='.$startDate.'
                OR (date_format(r.fecha_ingreso,"%X-%m-%d")>'.$startDate.' AND date_format(r.fecha_ingreso,"%X-%m-%d")<'.$finishDate.')
                OR (date_format(r.fecha_salida,"%X-%m-%d")>'.$startDate.' AND date_format(r.fecha_salida,"%X-%m-%d")<'.$finishDate.')
                OR (date_format(r.fecha_ingreso,"%X-%m-%d")<'.$startDate.' AND date_format(r.fecha_salida,"%X-%m-%d")>'.$finishDate.')
                ) AND (r.estado_reserva="AC" OR r.estado_reserva="RE"))
                ORDER BY th.id_tipo_habitacion');
                
            } catch (\Throwable $th) {
                echo '<option value="0">'.$th.'</option>';
            }


            $query->execute([':quantity'=>$quantity]);
            foreach ($query as $current) {
                echo '<option value="'.$current['id_tipo_habitacion'].'">'.$current['nombre_tipo_habitacion'].'</option>';
            }
            
/*
            echo '<option value="1">JOLIOT</option>';
            echo '<option value="2">HAWKING</option>';
            echo '<option value="3">LISPECTOR</option>';
            echo '<option value="4">MAKKAH</option>';
            */
            return false;
        }

        /**
        * Construye una lista con tarifas de habitación, de acuerdo a los parámetros asignados
        * @param $quantity Cantidad de huespedes a ser consultados
        * @param $roomType Tipo de habitación
        */
        public function tariffList($quantity,$roomType){
            $query = $this->connect()->prepare('SELECT id_tarifa,valor_ocupacion FROM tarifas WHERE cantidad_huespedes=:quantity AND id_tipo_habitacion=:roomType ORDER BY valor_ocupacion');
            $query->execute([':quantity'=>$quantity,':roomType'=>$roomType]);

            foreach ($query as $current) {
                echo '<option value="'.$current['id_tarifa'].'">'.$this->setFormatPrice($current['valor_ocupacion']).'</option>';
            }
            //echo "<option value='1'>50000</option>";
            return false;
        }
        
        /**
        * Obtiene la lista de los cargos que van a desempeñar los usuarios del hotel
        */
        public function getRoleList(){
            $query = $this->connect()->prepare('SELECT nombre_cargo FROM cargos WHERE id_cargo !=5 ORDER BY id_cargo');
            $query->execute();

            foreach ($query as $current) {
                echo '<option value="'.$current['nombre_cargo'].'">'.$current['nombre_cargo'].'</option>';
            }
        }
        
        /**
        * Se encarga de dar formato a un precio determinado
        * @param $price precio al que se le asignará un formato
        */
        public function setFormatPrice($price){
            $length=strlen($price);
            $blocks=round($length/3);
            $rest=($length%3)==0?3:$length%3;
            $newValue="";
            
            for($i=0;$i<$blocks-1;$i++){
                $newValue=$newValue.'.'.substr($price,$length-3);
                $price=substr($price,0,$length-3);
            }
            $newValue=substr($price,0,$rest).$newValue;
            
            return $newValue;
        }

        /**
        * Construye una tabla con las reservas que en el momento se encuentran activas
        */
        function reservationTable(){
            $query = $this->connect()->prepare('SELECT r.id_reserva,
                date_format(r.fecha_ingreso,"%X-%m-%d") fecha_ingreso, 
                TIMESTAMPDIFF(DAY, date_format(r.fecha_ingreso,"%X-%m-%d"),date_format(r.fecha_salida,"%X-%m-%d")) dias, 
                r.id_titular, CONCAT_WS(" ",t.nombres_persona,t.apellidos_persona) nombre_t,t.telefono_persona, 
                r.id_empresa, e.nombre_empresa, e.telefono_empresa,
                rc.id_huesped, GROUP_CONCAT(CONCAT_WS(" ",c.nombres_persona,c.apellidos_persona)) nombres_c,GROUP_CONCAT(c.id_persona) ids_c,
                (COUNT(rc.id_registro_huesped)=SUM(COALESCE(c.tipo_sangre_rh,1,0))) aux
                FROM reservas r 
                LEFT JOIN personas t ON r.id_titular=t.id_persona 
                LEFT JOIN empresas e ON r.id_empresa=e.id_empresa 
                LEFT JOIN registros_habitacion rh ON rh.id_reserva=r.id_reserva
                LEFT JOIN registros_huesped rc ON rc.id_registro_habitacion=rh.id_registro_habitacion
                LEFT JOIN personas c ON rc.id_huesped=c.id_persona
                WHERE r.estado_reserva="AC"
                GROUP BY r.id_reserva');
            $query->execute();

            foreach ($query as $current){
                echo '<tr>'.PHP_EOL;
                echo '<td>'.$current['id_reserva'].'</td>'.PHP_EOL;
                echo '<td><button onclick="window.location.href='."'../reservas/editar?id=".$current['id_reserva']."'".'" class="btn btn-table btn-edit-hover '.($current['aux']==1?"btn-success":"btn-complete").'"><span>'.($current['aux']==1?"Listo":"Completar").'</span></button></td>'.PHP_EOL;
                echo '<td><label class="switch switch-table"><input type="checkbox" onchange="setCheckOn('.$current['id_reserva'].',this);"'.($current['fecha_ingreso']==date("Y-m-d")&&$current['aux']==1?'':'disabled').'><span class="slider '.($current['fecha_ingreso']==date("Y-m-d")&&$current['aux']==1?'slider-red':'slider-gray').' round green"></span></label></td>';
                echo '<td><a href="'.($current['id_titular']==""?'../empresas/detalles?id='.$current['id_empresa']:'../clientes/detalles?id='.$current['id_titular']).'">'.($current['id_titular']==""?$current['nombre_empresa']:$current['nombre_t']).'</a></td>';
                echo '<td>'.($current['id_titular']==""?$current['telefono_empresa']:$current['telefono_persona']).'</td>'.PHP_EOL;
                echo '<td>'.($current['fecha_ingreso']>=date("Y-m-d")?$current['fecha_ingreso']:"Vencido").'</td>'.PHP_EOL;
                echo '<td>'.$current['dias'].'</td>'.PHP_EOL;
                 echo '<td>';
                
                $names=explode(",",$current['nombres_c']);
                $ids=explode(",",$current['ids_c']);
                
                for ($i=0;$i<count($names);$i++) {
                    echo '<a href=../clientes/detalles?id='.$ids[$i].'>'.$names[$i].'</a>';
                    if(count($names)-1!=$i)
                        echo ',';
                }

                echo '</td>';
                echo '<td><a href="detalles?id='.$current['id_reserva'].'" class="button-more-info">Ver</a></td>'.PHP_EOL;
                echo '</tr>'.PHP_EOL;
            }
        }

       /**
        * Construye una tabla con los datos referentes a huéspedes que pertenecen a una empresa determinada
        * @param $idEmpresa Código de la empresa a consultar
        */
        function enterpriseCustomTable($idEnterprise){
            $query = $this->connect()->prepare(
                'SELECT CONCAT(nombres_persona, " ", apellidos_persona) AS nombres, numero_documento, DATE_FORMAT(fecha_ingreso, "%d/%m/%Y") AS fecha_ingreso, DATE_FORMAT(fecha_salida, "%d/%m/%Y") AS fecha_salida
                FROM personas p 
                INNER JOIN registros_huesped rc ON rc.id_huesped=p.id_persona
                INNER JOIN registros_habitacion rh ON rc.id_registro_habitacion=rh.id_registro_habitacion
                INNER JOIN reservas r ON rh.id_reserva = r.id_reserva 
                LEFT JOIN facturas f ON f.id_reserva = r.id_reserva 
                WHERE r.id_empresa = :idEnterprise'
            );
            $query->execute(['idEnterprise'=>$idEnterprise]);
            
            foreach ($query as $current){
                echo '<tr>'.PHP_EOL;
                echo '<td>'.$current['nombres'].'</td>'.PHP_EOL;
                echo '<td>'.$current['numero_documento'].'</td>'.PHP_EOL;
                echo '<td>'.$current['fecha_ingreso'].'</td>'.PHP_EOL;
                echo '<td>'.$current['fecha_salida'].'</td>'.PHP_EOL;
            }                              
        }
        
        /**
        * Construye una tabla con los clientes almacenados en la base de datos
        */
        function customerTable(){
            $query = $this->connect()->prepare('SELECT id_persona, CONCAT_WS(" ", nombres_persona, apellidos_persona) AS nombre, tipo_documento, numero_documento, nombre_profesion, telefono_persona, correo_persona 
                FROM personas p 
                LEFT JOIN profesiones pr ON p.id_profesion=pr.id_profesion 
                WHERE tipo_persona = "C"
                ORDER BY nombre');
            $query->execute();

            foreach ($query as $current){
                echo '<tr>'.PHP_EOL;
                echo '<td class="num">'.$current['numero_documento'].'</td>'.PHP_EOL;
                echo '<td style = "text-align: left; padding: 10px;"><a href="../clientes/detalles?id='.$current['id_persona'].'">'.$current['nombre'].'</a></td>'.PHP_EOL;
                echo '<td>'.$current['telefono_persona'].'</td>'.PHP_EOL;
                echo '</tr>'.PHP_EOL;
            }
        }
        
        /**
        * Construye una tabla con los usuarios almacenados en la base de datos
        */
        function userTable(){
            $query = $this->connect()->prepare('SELECT id_persona, CONCAT_WS(" ", nombres_persona, apellidos_persona) AS nombre, telefono_persona, correo_persona, nombre_cargo 
                FROM personas p INNER JOIN cargos c ON p.id_cargo = c.id_cargo
                WHERE tipo_persona = "U"
                AND p.id_cargo != 5');
            $query->execute();

            foreach ($query as $current){
                echo '<tr>'.PHP_EOL;
                echo '<td style = "text-align: left; padding: 10px;"><a href="../usuarios/detalles?id='.$current['id_persona'].'">'.$current['nombre'].'</a></td>'.PHP_EOL;
                echo '<td class="num">'.$current['telefono_persona'].'</td>'.PHP_EOL;
                echo '<td>'.$current['correo_persona'].'</td>'.PHP_EOL;
                echo '<td>'.$current['nombre_cargo'].'</td>'.PHP_EOL;
                echo '</tr>'.PHP_EOL;
            }
        }

        /**
        * Construye una tabla con las empresas almacenadas en la base de datos
        */
        function enterpriseTable(){
            $query = $this->connect()->prepare('SELECT id_empresa,nit_empresa, nombre_empresa, telefono_empresa, correo_empresa, retefuente, ica 
                FROM empresas');
            $query->execute();
            
            foreach ($query as $current){
                echo '<tr>'.PHP_EOL;
                echo '<td>'.$current['nit_empresa'].'</td>'.PHP_EOL;
                echo '<td style = "text-align: left; padding: 10px;"><a href="../empresas/detalles?id='.$current['id_empresa'].'">'.$current['nombre_empresa'].'</a></td>'.PHP_EOL;
                echo '<td>'.$current['telefono_empresa'].'</td>'.PHP_EOL;
                echo '<td>'.($current['retefuente']==1?'Si':'No').'</td>'.PHP_EOL;
                echo '<td>'.($current['ica']==1?'Si':'No').'</td>'.PHP_EOL;
                echo '</tr>'.PHP_EOL;
            }
        }
        
        /**
        * Construye una tabla con las facturas almacenadas en la base de datos
        */
        function billTable(){
            $query = $this->connect()->prepare('SELECT id_factura, serie_factura, r.id_reserva, CASE WHEN r.id_titular IS NOT NULL THEN CONCAT_WS(" ",pt.nombres_persona, pt.apellidos_persona) ELSE e.nombre_empresa END AS titular, CONCAT_WS(" ",pr.nombres_persona, pr.apellidos_persona) AS responsable, total_factura, DATE_FORMAT(fecha_factura, "%d/%m/%Y") AS fecha_factura, CASE WHEN f.tipo_factura="N" THEN 0 ELSE 1 END AS tipo
                FROM facturas f INNER JOIN reservas r ON f.id_reserva=r.id_reserva
                LEFT JOIN personas pr ON f.id_responsable = pr.id_persona
                LEFT JOIN personas pt ON r.id_titular=pt.id_persona
                LEFT JOIN empresas e ON r.id_empresa=e.id_empresa
                WHERE tipo_factura = "N"
                ORDER by f.fecha_factura, f.serie_factura');
            $query->execute();
            
            foreach ($query as $current){
                echo '<tr>'.PHP_EOL;
                echo '<td>'.$current['serie_factura'].'</td>'.PHP_EOL;
                echo '<td>'.$current['titular'].'</td>'.PHP_EOL;
                echo '<td>'.'$ '.number_format($current['total_factura'], 0, '.', '.').'</td>'.PHP_EOL;
                echo '<td>'.$current['fecha_factura'].'</td>'.PHP_EOL;
                echo '<td>'.$current['responsable'].'</td>'.PHP_EOL;
                echo '<td><a href = "../facturas/registrar?id='.$current['id_reserva'].'&serie='.$current['serie_factura'].'"class="button-more-info" class="col-10">Ver Detalles</a></td>';
                echo '<td><a target = "_blank" href = "../reportes/facturas?id='.$current['id_reserva'].'&typeBill='.$current['tipo'].'&serie='.$current['serie_factura'].'" class="col-10"><img src="/res/img/pdf-icon.png" style="cursor:pointer;" width="60"/></a></td>';
                echo '</tr>'.PHP_EOL;
            }
        }
            
        /**
        * Construye una tabla con las habitaciones que se encuentran con reserva activa en una fecha determinada
        * @param $date Fecha que asigna un rango de consulta de las habitaciones
        */
        function roomTable($date){
            $query= $this->connect()->prepare('SELECT h.id_habitacion, th.nombre_tipo_habitacion,h.numero_habitacion,h.fuera_de_servicio, CASE WHEN rg.estado_reserva="RE" THEN rg.nombres_clientes ELSE NULL END nombres_clientes,CASE WHEN rg.estado_reserva="RE" THEN rg.ids_clientes ELSE NULL END ids_clientes, CASE WHEN rg.estado_reserva="RE" THEN DATE_FORMAT(rg.fecha_ingreso, "%d/%m/%Y %H:%i") ELSE NULL END fecha_ingreso, CASE WHEN rg.estado_reserva="RE" THEN rg.conteo ELSE NULL END conteo, rg.estado_reserva, rg.id_reserva, rg.total,full_cu
                FROM habitaciones h 
                LEFT JOIN (
                SELECT r.id_reserva, rs.id_habitacion,r.estado_reserva, GROUP_CONCAT(CONCAT_WS(";",r.id_reserva,CONCAT_WS(" ",c.nombres_persona,c.apellidos_persona))) nombres_clientes, GROUP_CONCAT(c.id_persona) ids_clientes, r.fecha_ingreso,CONCAT_WS(" de ",TIMESTAMPDIFF(DAY,date_format(r.fecha_ingreso,"%X-%m-%d"),"'.$date.'"),TIMESTAMPDIFF(DAY,date_format(r.fecha_ingreso,"%X-%m-%d"), r.fecha_salida)) conteo,
                SUM(t.valor_ocupacion) total, (COUNT(rh.id_registro_huesped)=SUM(rh.estado_huesped="CU")) full_cu
                FROM reservas r 
                INNER JOIN registros_habitacion rs ON rs.id_reserva=r.id_reserva 
                INNER JOIN registros_huesped rh ON rh.id_registro_habitacion=rs.id_registro_habitacion 
                INNER JOIN personas c ON rh.id_huesped=c.id_persona
                INNER JOIN tarifas t ON rs.id_tarifa=t.id_tarifa  
                WHERE date_format(r.fecha_ingreso,"%X-%m-%d")<="'.$date.'" 
                AND date_format(r.fecha_salida,"%X-%m-%d") >="'.$date.'" 
                AND (r.estado_reserva="RE" OR r.estado_reserva="AC") 
                GROUP BY id_habitacion) rg ON rg.id_habitacion=h.id_habitacion 
                LEFT JOIN tipos_habitacion th ON h.id_tipo_habitacion=th.id_tipo_habitacion');
            $query->execute();

            foreach ($query as $current) {
                echo '<tr>'.PHP_EOL;
                echo '<td><p class="vertical-word">'.$current['nombre_tipo_habitacion'].'</p></td>'.PHP_EOL;
                echo '<td id="room-'.$current['numero_habitacion'].'" class="room-cell">'.$current['numero_habitacion'].'<br>'.PHP_EOL;
                echo '<p class="room-state">'.$this->roomState($current['fuera_de_servicio'],$current['estado_reserva'],$date).'</p>'.PHP_EOL;
                echo '</td>'.PHP_EOL;
                echo '<td>';
                
                $names=explode(",",$current['nombres_clientes']);
                $ids=explode(",",$current['ids_clientes']);
                
                for ($i=0;$i<count($names);$i++) {
                    $aux=explode(";", $names[$i]);

                    if($current['id_reserva']==$aux[0]){
                        if(count($aux)==2)
                            echo '<a href=../clientes/detalles?id='.$ids[$i].'>'.$aux[1].'</a> ';
                    }
                }

                echo '</td>';
                echo '<td>'.$current['fecha_ingreso'].'</td>';
                echo '<td>'.$current['conteo'].'</td>';
                echo '<td>'.(isset($current['nombres_clientes'])?$current['total']:"").'</td>';
                echo (isset($current['nombres_clientes'])?'<td><label class="switch switch-table"><input type="checkbox" onchange="setCheckUp('.$current['id_reserva'].','.$current['id_habitacion'].',this);" '.($this->user->getRole()!=4?'':'disabled').' '.($current['full_cu']==1?'checked':'').'><span class="slider slider-gray round green"></span></label></td>':"<td></td>");
                echo (isset($current['nombres_clientes'])?'<td><label class="switch switch-table"><input type="checkbox" onchange="setCheckOut('.$current['id_reserva'].','.$current['id_habitacion'].',this);" '.($this->user->getRole()!=4?'':'disabled').'><span class="slider slider-gray round yellow"></span></label></td>':"<td></td>");

                if($this->user->getRole()!=4)
                    echo '<td><a href="detalles?id='.$current['id_habitacion'].'&res='.(isset($current['nombres_clientes'])?$current['id_reserva']:"").'" class="col-10 button-more-info">Más información</a></td>';
                echo '</tr>'.PHP_EOL;
            }
        }

        /**
        * Realiza una consulta referente a los cargos de los usuarios del sistema
        */
        function userComboRol(){
            $query = $this->connect()->prepare('SELECT nombre_cargo FROM cargos');
            $query->execute();
            
            foreach($query as $current){
                echo '<option value = "'.$current['nombre_cargo'].'">'.$current['nombre_cargo'].'</option>'.PHP_EOL;
            }
        }
        
        /**
        * Realiza una consulta referente a los tipos de documento almacenados en la base de datos
        */
        function typeDocument(){
            $query = $this->connect()->prepare('SELECT nombre_tipo FROM tipos_documento');
            $query->execute();
            
            foreach($query as $current){
                echo '<option value = "'.$current['nombre_tipo'].'">'.$current['nombre_tipo'].'</option>'.PHP_EOL;
            }
        }

        /**
        * Realiza una consulta de las profesiones almacenadas en la base de datos y agrega a un combobox los valores que no coinciden con lo recibido por parámetro
        * @param $currentProfession Profesión que se quiere comparar con los valores almacenados en la base de datos
        */
        function getRemainingProfession($currentProfession){
            $query = $this->connect()->prepare('SELECT id_profesion, nombre_profesion FROM profesiones');
            $query->execute();

            foreach ($query as $current) {
                if($current['nombre_profesion']!=$currentProfession)
                    echo '<option value="'.$current['id_profesion'].'">'.$current['nombre_profesion'].'</option>'; 
            }
        }
        
        /**
        * Realiza una consulta de los lugares de expedicion del documento almacenados en la base de datos y agrega a un combobox los valores que no coinciden con lo recibido por parámetro
        * @param $currentExp Lugar de expedición que se quiere comparar con los valores almacenados en la base de datos
        */
        function getRemainingExp($currentExp){
            $query = $this->connect()->prepare('SELECT id_lugar, nombre_lugar FROM lugares WHERE tipo_lugar="C" ORDER BY 2');
            $query->execute();

            foreach ($query as $current) {
                if($current['nombre_lugar']!=$currentExp)
                echo '<option value="'.$current['id_lugar'].'">'.$current['nombre_lugar'].'</option>';
            }
        }
        
        /**
        * Realiza una consulta de los lugares de nacimiento del documento almacenados en la base de datos y agrega a un combobox los valores que no coinciden con lo recibido por parámetro
        * @param $currentNac Lugar de nacimiento que se quiere comparar con los valores almacenados en la base de datos
        */
        function getRemainingNac($currentNac){
            $query = $this->connect()->prepare('SELECT id_lugar, nombre_lugar FROM lugares WHERE tipo_lugar="P" ORDER BY 2');
            $query->execute();

            foreach ($query as $current) {
                if($current['nombre_lugar']!=$currentNac)
                echo '<option value="'.$current['id_lugar'].'">'.$current['nombre_lugar'].'</option>';
            }
        }
        
        /**
        * Cambia el estado de selección de un elemento de acuerdo con el valor que se recibe por parámetro
        * @param $state Estado de selección que se quiere obtener
        * @return Estado de selección asignada
        */
        function selectCheck($state){
            switch ($state){
                case 0:
                    return '';
                case 1:
                    return 'checked';
            }
        }
            
        /**
        * Obtiene el valor del tipo de habitación, de acuerdo a lo recibido por parámetro
        * @param $type Letra que se recibe haciendo referencia al tipo de habitación
        * @return Tipo de habitación expresada en palabras
        */
        function roomType($type){
            switch ($type) {
                case 'J':
                return 'JOLIOT';
                case 'H':
                return 'HAWKING';
                case 'L':
                return 'LISPECTOR';
                case 'M':
                return 'MAKKAH';
            }
        }

        /**
        * Obtiene el estado de una habitación, de acuerdo con los parámetros que llegan
        * @param $stateRoom Estado de la habitación
        * @param $stateBook Estado de la reserva
        * @param $date Fecha que es comparada con la fecha actual del sistema
        * @return estado de la habitación
        */
        function roomState($stateRoom, $stateBook,$date){
            if($stateRoom==0)
                if($stateBook=="RE")
                    return 'Ocupada';
                else if($stateBook=="AC"){
                    if(date("Y-m-d")==$date)
                        return 'Con reserva';
                    else
                        return 'Disponible';
                }else 
                    return 'Disponible';
            else
                return 'Fuera de servicio';
        }

        /**
        * Obtiene los datos personales de un huésped, teniendo en cuenta el id que se recibe por parámetro
        * @param $id Código del huésped a consultar
        */
        public function getPerson($id){
            $consult='SELECT id_persona,id_lugar_nacimiento,id_lugar_expedicion,id_profesion,
            nombres_persona,apellidos_persona,tipo_documento,numero_documento,
            genero_persona,fecha_nacimiento,tipo_sangre_rh,telefono_persona,correo_persona  
            FROM personas p  
            WHERE tipo_persona = "C" AND (numero_documento='.$id.' OR id_persona='.$id.')';
            
            $query = $this->connect()->prepare($consult);
            $query->execute();

            foreach ($query as $current){
                echo $current['id_persona'].';';
                echo $current['id_lugar_nacimiento'].';';
                echo $current['id_lugar_expedicion'].';';
                echo $current['id_profesion'].';';
                echo $current['nombres_persona'].';';
                echo $current['apellidos_persona'].';';
                echo $current['tipo_documento'].';';
                echo $current['numero_documento'].';';
                echo $current['genero_persona'].';';
                echo $current['fecha_nacimiento'].';';
                echo $current['tipo_sangre_rh'].';';
                echo $current['telefono_persona'].';';
                echo $current['correo_persona'];
            }
        }

         public function getEnterprise($id){
            $consult='SELECT id_empresa,nit_empresa,nombre_empresa, telefono_empresa
            FROM empresas e  
            WHERE (nit_empresa='.$id.' OR id_empresa='.$id.')';
            
            $query = $this->connect()->prepare($consult);
            $query->execute();

            foreach ($query as $current){
                echo $current['id_empresa'].';';
                echo $current['nit_empresa'].';';
                echo $current['nombre_empresa'].';';
                echo $current['telefono_empresa'];
            }
        }

        /**
        * Obtiene los datos referentes a una reserva, de acuerdo con el parámetro que se recibe
        * @param $id Código de la reserva a consultar
        */
        public function getBooking($id){
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
                echo $current['fecha_ingreso'].';';
                echo $current['fecha_salida'].';';
                echo $current['cantidad_habitaciones'].';';
                echo $current['id_titular'].';';
                echo $current['id_empresa'];
            }
        }

        /**
        * Obtiene los clientes de una habitacion
        */
        function getBookingClients($idBooking,$idRoom){
             $query = $this->connect()->prepare('SELECT id_persona,  CONCAT_WS(" ",p.nombres_persona,p.apellidos_persona) nombres,
                rc.id_registro_huesped,rc.estado_huesped
                FROM personas p
                INNER JOIN registros_huesped rc ON rc.id_huesped=p.id_persona
                INNER JOIN registros_habitacion rh ON rc.id_registro_habitacion=rh.id_registro_habitacion
                WHERE rh.id_reserva=:idBooking
                AND rh.id_habitacion=:idRoom');

            $query->execute([':idBooking'=>$idBooking,':idRoom'=>$idRoom]);

            foreach ($query as $current) {
                echo $current['id_persona'].';';
                echo $current['nombres'].';';
                echo $current['id_registro_huesped'].';';
                echo $current['estado_huesped'].'?';
            }
        }

        function getBookingAmount($idBooking){
            $query = $this->connect()->prepare('SELECT SUM(t.valor_ocupacion)=r.abono_reserva pago
                FROM tarifas t
                INNER JOIN registros_habitacion rh ON rh.id_tarifa=t.id_tarifa
                INNER JOIN reservas r ON rh.id_reserva=r.id_reserva
                WHERE rh.id_reserva=:idBooking');

            $query->execute([':idBooking'=>$idBooking]);

            foreach ($query as $current) {
                echo $current['pago'];
            }
            
        }

        /**
        * Obtiene los datos de una habitación con reserva, teniendo en cuenta el id que se recibe por parámetro
        * @param $id Código de la reserva a consultar
        */
        public function getBookingRooms($id){
            $query = $this->connect()->prepare('SELECT t.cantidad_huespedes, t.id_tipo_habitacion,rh.id_habitacion, rc.id_huesped, p.numero_documento,t.id_tarifa, GROUP_CONCAT(rc.id_huesped) ids_huespedes,GROUP_CONCAT(p.numero_documento) docs_huespedes,
                t.valor_ocupacion
                FROM registros_habitacion rh
                INNER JOIN tarifas t ON rh.id_tarifa=t.id_tarifa
                INNER JOIN registros_huesped rc ON rc.id_registro_habitacion=rh.id_registro_habitacion
                INNER JOIN personas p ON rc.id_huesped=p.id_persona
                WHERE rh.id_reserva=:id
                GROUP BY id_habitacion');

            $query->execute([':id'=>$id]);

            foreach ($query as $current) {
                echo $current['cantidad_huespedes'].';';
                echo $current['id_tipo_habitacion'].';';
                echo $current['id_habitacion'].';';
                echo $current['id_tarifa'].';';
                echo $current['ids_huespedes'].';';
                echo $current['docs_huespedes'].';';
                echo $current['valor_ocupacion'].'?';
            }
        }

        public function getRegRoom($id){
            $query = $this->connect()->prepare('SELECT t.cantidad_huespedes, t.id_tipo_habitacion,
                rh.id_habitacion,rh.id_tarifa,h.numero_habitacion,t.valor_ocupacion
                FROM registros_habitacion rh
                INNER JOIN tarifas t ON rh.id_tarifa=t.id_tarifa
                INNER JOIN habitaciones h ON rh.id_habitacion=h.id_habitacion
                WHERE rh.id_registro_habitacion=:id');
        
            $query->execute([':id'=>$id]);

            foreach ($query as $current) {
                echo $current['cantidad_huespedes'].';';
                echo $current['id_tipo_habitacion'].';';
                echo $current['id_habitacion'].';';
                echo $current['id_tarifa'].';';
                echo $current['numero_habitacion'].';';
                echo $current['valor_ocupacion'];
            }
        }

        /**
        * Obtiene los datos tanto de habitación como de huésped(es) asignado a dicha habitación
        * @param $id Código de la reserva a consultar
        */
        public function getBookingTable($id){
            $query = $this->connect()->prepare('SELECT numero_habitacion,p.id_persona, CONCAT_WS(" ",p.nombres_persona,p.apellidos_persona) nombre
                FROM registros_habitacion rh
                INNER JOIN habitaciones h ON rh.id_habitacion=h.id_habitacion
                INNER JOIN registros_huesped rc ON rc.id_registro_habitacion=rh.id_registro_habitacion
                INNER JOIN personas p ON rc.id_huesped=p.id_persona
                WHERE rh.id_reserva=:id');

            $query->execute([':id'=>$id]);

            foreach ($query as $current) {
                echo '<tr><td>'.$current['numero_habitacion'].'</td>';
               echo '<td><a href="../../clientes/detalles?id='.$current['id_persona'].'">'.$current['nombre'].'</a></td>';
            }
        }

        /**
        * Obtiene los datos de una habitación, teniendo en cuenta el id que se recibe por parámetro
        * @param $id Código de habitación a consultar
        * @param $res Código de reserva a consultar
        */
        public function getRoomTable($id,$res){
            $query = $this->connect()->prepare('SELECT p.id_persona, CONCAT_WS(" ",p.nombres_persona,p.apellidos_persona) nombre,
                p.numero_documento,p.telefono_persona
                FROM registros_habitacion rh
                INNER JOIN habitaciones h ON rh.id_habitacion=h.id_habitacion
                INNER JOIN registros_huesped rc ON rc.id_registro_habitacion=rh.id_registro_habitacion
                INNER JOIN personas p ON rc.id_huesped=p.id_persona
                WHERE rh.id_reserva=:res
                AND rh.id_habitacion=:id');

            $query->execute([':id'=>$id,':res'=>$res]);

            foreach ($query as $current) {
                echo '<tr><td><a href=../clientes/detalles?id='.$current['id_persona'].'>'.$current['nombre'].'</a></td>';
                echo '<td>'.$current['numero_documento'].'</td>';
                echo '<td>'.$current['telefono_persona'].'</td>';
                echo '<td class="switch-input"><label class="switch switch-table"><input type="checkbox"><span class="slider slider-gray round green"></span></label></td></tr>';
            }
        }
            
        /**
        * Obtiene los datos personales del titular de una reserva, teniendo en cuenta el id que se recibe por parámetro
        * @param $id Código de titular a consultar
        */
        public function getTitularPerson($id, $state, $idRes){
            $lastRes = "";
            if($state==0){
                $lastRes = ' AND fecha_ingreso = (SELECT MAX(fecha_ingreso) 
                                 FROM reservas r INNER JOIN personas p ON r.id_titular=p.id_persona
                                WHERE numero_documento=:idPerson2)';
            }else{
                $lastRes = ' AND fecha_ingreso = (SELECT fecha_ingreso
                                 FROM reservas r
                                WHERE r.id_reserva='.$idRes.')';
            }
            
            $query = $this->connect()->prepare('SELECT nombres_persona, apellidos_persona, numero_documento, telefono_persona, DATE_FORMAT(fecha_ingreso, "%d/%m/%Y") AS fecha_ingreso, DATE_FORMAT(fecha_salida, "%d/%m/%Y") AS fecha_salida, nombre_empresa, GROUP_CONCAT(DISTINCT(numero_habitacion) SEPARATOR ",") AS habitaciones, r.id_reserva
            FROM reservas r INNER JOIN personas p ON r.id_titular=p.id_persona
            LEFT JOIN registros_habitacion rh ON r.id_reserva=rh.id_reserva
            LEFT JOIN habitaciones h ON h.id_habitacion=rh.id_habitacion
            LEFT JOIN empresas e ON r.id_empresa=r.id_reserva
            WHERE numero_documento=:idPerson'.$lastRes);
            ($state==0)?$query->execute([':idPerson'=>$id, ':idPerson2'=>$id]):$query->execute([':idPerson'=>$id]);

            foreach ($query as $current){
                echo $current['nombres_persona'].';';
                echo $current['apellidos_persona'].';';
                echo $current['numero_documento'].';';
                echo $current['telefono_persona'].';';
                echo $current['fecha_ingreso'].';';
                echo $current['fecha_salida'].';';
                echo $current['nombre_empresa'].';';
                echo $current['habitaciones'].';';
                echo $current['id_reserva'].';';
            }
            
             $query = $this->connect()->prepare('SELECT COUNT(id_registro_habitacion) AS cantidad, valor_ocupacion AS valorUnitario, GROUP_CONCAT(DISTINCT(numero_habitacion) SEPARATOR ",") AS habitaciones, (valor_ocupacion*COUNT(id_registro_habitacion)* CASE WHEN DATEDIFF(fecha_salida, fecha_ingreso) = 0 THEN 1 ELSE DATEDIFF(fecha_salida, fecha_ingreso) END) AS valor_total
                FROM reservas r INNER JOIN personas p ON p.id_persona=r.id_titular
                LEFT JOIN registros_habitacion rh ON r.id_reserva=rh.id_reserva
                LEFT JOIN tarifas tf ON tf.id_tarifa=rh.id_tarifa
                LEFT JOIN habitaciones h ON h.id_habitacion=rh.id_habitacion 
                WHERE numero_documento=:idPerson'.$lastRes.
                ' GROUP BY valorUnitario');
           ($state==0)?$query->execute([':idPerson'=>$id, ':idPerson2'=>$id]):$query->execute([':idPerson'=>$id]);
            
            foreach ($query as $current){  
                echo "HOSPEDAJE HABITACIÓN ".$current['habitaciones'].';';
                echo $current['cantidad'].';';
                echo number_format($current['valorUnitario'], 0, '.', '.').';';
                echo number_format($current['valor_total'], 0, '.', '.').';';
            }
            
            $query = $this->connect()->prepare('SELECT SUM(cantidad_producto*valor_producto) minibar
            FROM reservas r INNER JOIN personas p ON p.id_persona=r.id_titular
            INNER JOIN registros_habitacion rh ON r.id_reserva=rh.id_reserva
            INNER JOIN control_diario cd ON rh.id_registro_habitacion=cd.id_registro_habitacion
            INNER JOIN peticiones pt ON cd.id_control=pt.id_control
            INNER JOIN productos pd ON pd.id_producto=pt.id_producto
            WHERE numero_documento=:idPerson'.$lastRes);
            ($state==0)?$query->execute([':idPerson'=>$id, ':idPerson2'=>$id]):$query->execute([':idPerson'=>$id]);
            
            foreach ($query as $current){
                if($current['minibar']!=Null){
                    echo "MINIBAR".';';
                    echo "-".';';
                    echo "-".';';
                    echo number_format($current['minibar'], 0, '.', '.').';';
                }
            }
            
            $query = $this->connect()->prepare('SELECT SUM(cantidad_servicio*valor_servicio) AS valor_lavanderia
            FROM reservas r INNER JOIN personas p ON p.id_persona=r.id_titular
            INNER JOIN registros_habitacion rh ON r.id_reserva=rh.id_reserva
            INNER JOIN control_diario cd ON rh.id_registro_habitacion=cd.id_registro_habitacion
            INNER JOIN peticiones pt ON cd.id_control=pt.id_control
            INNER JOIN servicios s ON s.id_servicio=pt.id_servicio
            WHERE numero_documento=:idPerson
            AND tipo_servicio = "L"'.$lastRes);
            ($state==0)?$query->execute([':idPerson'=>$id, ':idPerson2'=>$id]):$query->execute([':idPerson'=>$id]);
            
            foreach ($query as $current){
                if($current['valor_lavanderia']!=Null){
                    echo "SERVICIO DE LAVANDERÍA".';';
                    echo "-".';';
                    echo "-".';';
                    echo number_format($current['valor_lavanderia'], 0, '.', '.').';';
                }
            }
            
            $query = $this->connect()->prepare('SELECT NVL(abono_reserva, 0)+ NVL(SUM(abono_peticion),0) AS abono
                FROM reservas r INNER JOIN personas p ON r.id_titular=p.id_persona
                LEFT JOIN registros_habitacion rh ON rh.id_reserva=r.id_reserva
                LEFT JOIN control_diario c ON c.id_registro_habitacion=rh.id_registro_habitacion
                LEFT JOIN peticiones pt ON pt.id_control=c.id_control
                WHERE p.numero_documento=:idPerson'.$lastRes);
            ($state==0)?$query->execute([':idPerson'=>$id, ':idPerson2'=>$id]):$query->execute([':idPerson'=>$id]);
            
            foreach ($query as $current){
                echo $current['abono'];
            }
        }
        
         /**
        * Obtiene los datos personales del titular de una reserva, teniendo en cuenta el id que se recibe por parámetro
        * @param $id Código de titular a consultar
        */
        public function getTitularEnterprise($id, $state, $idRes){
            $lastRes = "";
            if($state==0){
                $lastRes = ' AND fecha_ingreso = (SELECT MAX(fecha_ingreso) 
                                 FROM reservas r INNER JOIN empresas e ON r.id_empresa=e.id_empresa
                                WHERE e.nit_empresa=:idE2)';
            }else{
                $lastRes = ' AND fecha_ingreso = (SELECT fecha_ingreso
                                FROM reservas r
                                WHERE r.id_reserva='.$idRes.')';
            }
            
            $query = $this->connect()->prepare('SELECT nombre_empresa, telefono_empresa, nit_empresa, DATE_FORMAT(fecha_ingreso, "%d/%m/%Y") AS fecha_ingreso, DATE_FORMAT(fecha_salida, "%d/%m/%Y") AS fecha_salida, GROUP_CONCAT(DISTINCT(numero_habitacion) SEPARATOR ",") AS habitaciones, r.id_reserva
            FROM reservas r INNER JOIN empresas e ON r.id_empresa=e.id_empresa
            LEFT JOIN registros_habitacion rh ON r.id_reserva=rh.id_reserva
            LEFT JOIN habitaciones h ON h.id_habitacion=rh.id_habitacion
            WHERE e.nit_empresa =:idE'.$lastRes);
            ($state==0)?$query->execute([':idE'=>$id, ':idE2'=>$id]):$query->execute([':idE'=>$id]);

            foreach ($query as $current){
                echo $current['nombre_empresa'].';';
                echo $current['telefono_empresa'].';';
                echo $current['nit_empresa'].';';
                echo $current['fecha_ingreso'].';';
                echo $current['fecha_salida'].';';
                echo $current['habitaciones'].';';
                echo $current['id_reserva'].';';
            }
            
             $query = $this->connect()->prepare('SELECT COUNT(id_registro_habitacion) AS cantidad, valor_ocupacion AS valorUnitario, GROUP_CONCAT(DISTINCT(numero_habitacion) SEPARATOR ",") AS habitaciones, (valor_ocupacion*COUNT(id_registro_habitacion)* CASE WHEN DATEDIFF(fecha_salida, fecha_ingreso) = 0 THEN 1 ELSE DATEDIFF(fecha_salida, fecha_ingreso) END) AS valor_total
                FROM reservas r INNER JOIN empresas e ON e.id_empresa=r.id_empresa
                LEFT JOIN registros_habitacion rh ON r.id_reserva=rh.id_reserva
                LEFT JOIN tarifas tf ON tf.id_tarifa=rh.id_tarifa
                LEFT JOIN habitaciones h ON h.id_habitacion=rh.id_habitacion 
                WHERE e.nit_empresa=:idE'.$lastRes.'
                 GROUP BY valorUnitario');
            ($state==0)?$query->execute([':idE'=>$id, ':idE2'=>$id]):$query->execute([':idE'=>$id]);
            
            foreach ($query as $current){  
                echo "HOSPEDAJE HABITACIÓN ".$current['habitaciones'].';';
                echo $current['cantidad'].';';
                echo number_format($current['valorUnitario'], 0, '.', '.').';';
                echo number_format($current['valor_total'], 0, '.', '.').';';
            }
            
            $query = $this->connect()->prepare('SELECT SUM(cantidad_producto*valor_producto) minibar
            FROM reservas r INNER JOIN empresas e ON e.id_empresa=r.id_empresa
            INNER JOIN registros_habitacion rh ON r.id_reserva=rh.id_reserva
            INNER JOIN control_diario cd ON rh.id_registro_habitacion=cd.id_registro_habitacion
            INNER JOIN peticiones pt ON cd.id_control=pt.id_control
            INNER JOIN productos pd ON pd.id_producto=pt.id_producto
            WHERE e.nit_empresa=:idE'.$lastRes);
            ($state==0)?$query->execute([':idE'=>$id, ':idE2'=>$id]):$query->execute([':idE'=>$id]);
            
            foreach ($query as $current){
                if($current['minibar']!=Null){
                    echo "MINIBAR".';';
                    echo "-".';';
                    echo "-".';';
                    echo number_format($current['minibar'], 0, '.', '.').';';
                }
            }
            
            $query = $this->connect()->prepare('SELECT SUM(cantidad_servicio*valor_servicio) AS valor_lavanderia
            FROM reservas r INNER JOIN empresas e ON e.id_empresa=r.id_empresa
            INNER JOIN registros_habitacion rh ON r.id_reserva=rh.id_reserva
            INNER JOIN control_diario cd ON rh.id_registro_habitacion=cd.id_registro_habitacion
            INNER JOIN peticiones pt ON cd.id_control=pt.id_control
            INNER JOIN servicios s ON s.id_servicio=pt.id_servicio
            WHERE e.nit_empresa=:idE
            AND tipo_servicio = "L"'.$lastRes);
            ($state==0)?$query->execute([':idE'=>$id, ':idE2'=>$id]):$query->execute([':idE'=>$id]);
            
            foreach ($query as $current){
                if($current['valor_lavanderia']!=Null){
                    echo "SERVICIO DE LAVANDERÍA".';';
                    echo "-".';';
                    echo "-".';';
                    echo number_format($current['valor_lavanderia'], 0, '.', '.').';';
                }
            }
            
            $query = $this->connect()->prepare('SELECT NVL(abono_reserva, 0)+ NVL(SUM(abono_peticion),0) AS abono
                FROM reservas r INNER JOIN empresas e ON r.id_empresa=e.id_empresa
                LEFT JOIN registros_habitacion rh ON rh.id_reserva=r.id_reserva
                LEFT JOIN control_diario c ON c.id_registro_habitacion=rh.id_registro_habitacion
                LEFT JOIN peticiones pt ON pt.id_control=c.id_control
                WHERE e.nit_empresa=:idE'.$lastRes);
            ($state==0)?$query->execute([':idE'=>$id, ':idE2'=>$id]):$query->execute([':idE'=>$id]);
            
            foreach ($query as $current){
                echo $current['abono'];
            }
        }
        
        
         function getTypeTitular($idRes){
             $query = $this->connect()->prepare('SELECT (CASE WHEN r.id_empresa IS NULL THEN 0 ELSE 1 END) AS tipo_titular
                FROM reservas r LEFT JOIN personas p ON r.id_titular=p.id_persona
                LEFT JOIN empresas e ON r.id_empresa=e.id_empresa
                WHERE r.id_reserva=:idRes;');
            $query->execute([':idRes'=>$idRes]);
            
             $typeTitular;
            
            foreach ($query as $current){
                $typeTitular = $current['tipo_titular'];
            }
            return $typeTitular;
         }
        
        function getIdTitular($idRes){
             $query = $this->connect()->prepare('SELECT (CASE WHEN r.id_empresa IS NULL THEN p.numero_documento ELSE e.nit_empresa END) AS tipo_titular
                FROM reservas r LEFT JOIN personas p ON r.id_titular=p.id_persona
                LEFT JOIN empresas e ON r.id_empresa=e.id_empresa
                WHERE r.id_reserva=:idRes;');
            $query->execute([':idRes'=>$idRes]);
            
             $idTitular;
            
            foreach ($query as $current){
                $idTitular = $current['tipo_titular'];
            }
            return $idTitular;
         }
        
        /**
        * Obtiene la siguiente serie que se va a generar del orden de servicio
        * @return Serie generada
        */
        function getNextSerieOrder(){

            $query = $this->connect()->prepare('SELECT MAX(CAST(serie_factura AS INT)) AS last FROM facturas WHERE tipo_factura="O"');
            $query->execute();
            $serie;
            $code = "";
            
            foreach ($query as $current){
                $serie = $current['last'];
            }
            
            if($serie>=0&&$serie<=8){
                $serie = $serie+1;
                $code = "00".$serie;
            }else if($serie>=9&&$serie<=98){
                $serie = $serie+1;
                $code = "0".$serie;
            }else if($serie>=98 && $serie<=998){
                $serie = $serie+1;
                $code = $serie;
            }else{
                $code = "000";
            }
            
            return $code;
        }
        
        /**
        * Obtiene la última orden de servicio que se encuentra almacenada en la base de datos
        */
        function getLastSerieOrder(){
            $query = $this->connect()->prepare('SELECT MAX(serie_factura) AS last FROM facturas WHERE tipo_factura="O"');
            $query->execute();
            $serie;
            $code = "";
            
            foreach ($query as $current){
                $serie = $current['last'];
            }
            
            return $serie;
        }
        
        
        /**
        * Obtiene la siguiente serie que se va a generar de una factura
        */
        function getNextSerieBill(){
            
            $letter=65;
            $query = $this->connect()->prepare('SELECT MAX(ASCII(LEFT(serie_factura,1))) AS max FROM facturas WHERE tipo_factura="N"');
            $query->execute();
            
            foreach ($query as $current){
                $letter = $current['max'];
            }
            
            if($letter==""){
                $letter = 65;
            }
            
            $num=0;
            $query = $this->connect()->prepare('SELECT MAX(CAST(SUBSTRING(serie_factura,2) AS INT)) AS lastNum FROM facturas WHERE ASCII(LEFT(serie_factura,1))=:letter');
            $query->execute([':letter'=>$letter]);
            
            foreach ($query as $current){
                $num = $current['lastNum'];
            }
            
            $code = "";
            if($num>=0 && $num<=8){
                $num = $num+1;
                $code = chr($letter)."00".$num;
            }else if($num>=9 && $num<=98){
                $num = $num+1;
                $code = chr($letter)."0".$num;
            }else if($num>=98 && $num<=998){
                $num = $num+1;
                $code = chr($letter).$num;
            }else{
                
                if($num=999){
                    $letter = $letter+1;
                    $code = chr($letter)."000";
                }else{
                    $code = "A000";
                    
                }
            }
            return $code; 
        }

        function getNextSerieProv(){
            
            $letter=65;
            $query = $this->connect()->prepare('SELECT MAX(ASCII(LEFT(serie_factura_prov,1))) AS max FROM factura_prov');
            $query->execute();
            
            foreach ($query as $current){
                $letter = $current['max'];
            }
            
            if($letter==""){
                $letter = 65;
            }
            
            $num=0;
            $query = $this->connect()->prepare('SELECT MAX(CAST(SUBSTRING(serie_factura_prov,2) AS INT)) AS lastNum FROM factura_prov WHERE ASCII(LEFT(serie_factura_prov,1))=:letter');
            $query->execute([':letter'=>$letter]);
            
            foreach ($query as $current){
                $num = $current['lastNum'];
            }
            
            $code = "";
            if($num>=0 && $num<=8){
                $num = $num+1;
                $code = chr($letter)."00".$num;
            }else if($num>=9 && $num<=98){
                $num = $num+1;
                $code = chr($letter)."0".$num;
            }else if($num>=98 && $num<=998){
                $num = $num+1;
                $code = chr($letter).$num;
            }else{
                
                if($num=999){
                    $letter = $letter+1;
                    $code = chr($letter)."001";
                }else{
                    $code = "A000";
                    
                }
            }
            return $code; 
        }
        
        /**
        * Obtiene la última factura que se encuentra almacenada en la base de datos
        */
        function getLastSerieBill(){
            $query = $this->connect()->prepare('SELECT MAX(serie_factura) AS last FROM facturas WHERE tipo_factura="N"');
            $query->execute();
            $serie;
            $code = "";
            
            foreach ($query as $current){
                $serie = $current['last'];
            }
            return $serie;
        }
      
        /**
        * Función que recibe el nombre de un rol y devuelve su id
        */
        function getIdRole($nameRole){
            $query = $this->connect()->prepare('SELECT id_cargo FROM cargos WHERE UPPER(nombre_cargo) LIKE UPPER("%'.$nameRole.'%")');
            $query->execute();
            $idRol = 0;
            echo $nameRole;
            
            foreach ($query as $current){
                $idRol = $current['id_cargo'];
            }
            return $idRol;
        }

        /**
        * Función que recibe un registro y muestra por pantalla una tabla con productos
        */
        function getProducts($reg){
            $query = $this->connect()->prepare('SELECT nombre_producto, cantidad_producto, hora_peticion
                FROM peticiones p
                INNER JOIN productos pr ON p.id_producto=pr.id_producto 
                INNER JOIN control_diario cd ON p.id_control=cd.id_control
                WHERE fecha_control="'.date('Y-m-d').'"
                AND cd.id_registro_habitacion=:reg
                AND p.id_servicio IS NULL');
            $query->execute([':reg'=>$reg]);
            
            if($query->rowCount())
                echo "<tr><th>Producto</th><th>Cantidad</th><th>Hora</th></tr>";
            foreach ($query as $current){
                echo '<tr><td>'.$current['nombre_producto'].'</td>';
                echo '<td>'.$current['cantidad_producto'].'</td>';
                echo '<td>'.$current['hora_peticion'].'</td></tr>';
            }
        }

        /**
        * Función que recibe un registro y muestra los servicios en una tabla
        */
        function getServices($reg){
             $query = $this->connect()->prepare('SELECT nombre_servicio, cantidad_servicio, hora_peticion
                FROM peticiones p
                INNER JOIN servicios s ON p.id_servicio=s.id_servicio
                INNER JOIN control_diario cd ON p.id_control=cd.id_control
                WHERE fecha_control="'.date('Y-m-d').'"
                AND cd.id_registro_habitacion=:reg
                AND p.id_producto IS NULL');
            $query->execute([':reg'=>$reg]);
            
            if($query->rowCount())
                echo "<tr><th>Producto</th><th>Cantidad</th><th>Hora</th></tr>";

            foreach ($query as $current){
                echo '<tr><td>'.$current['nombre_servicio'].'</td>';
                echo '<td>'.$current['cantidad_servicio'].'</td>';
                echo '<td>'.$current['hora_peticion'].'</td></tr>';
            }
        }
    }
?>
