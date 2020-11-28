<?php
require_once "conexion.php";
require_once "respuestas.php";
require_once "usuarios.php";


class usuarios extends conexion {

    private $table = "usuarios";
    private $id = "";
    private $nombre = "";
    private $apellido = "";
    private $observaciones = "";
    


            // creamos una variable pagina que nos mostrara de a poco los usuarios 
            public function listaUsuarios($pagina = 1){// le puse un 1 para que no sea requerido

            $inicio     = 0;//porque registro debe comenzar en cero
            $cantidad   = 100;// nos muestra de 100 en 100

            if ($pagina >1) {

                $inicio = ($cantidad*($pagina -1)) + 1 ;//
                $cantidad = $cantidad * $pagina;
                # code...
            }

            $query ="SELECT id, nombre, apellido, observaciones FROM " . $this->table . "  limit $inicio,           $cantidad";
            //print_r($query); probamos

            $datos = parent::obtenerDatos($query);// obtenemos los registros
            return ($datos);

        }
            // creamos otro meod para obtener los registros pero por id

            public function obtenerUsuarios($id){

                $query =" SELECT * FROM " . $this->table . " WHERE id = '$id' ";
                return parent::obtenerDatos($query);


            }

    public function post($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        

                if(!isset($datos['Nombre']) || !isset($datos['apellido']) || !isset($datos['observaciones'])){
                    return $_respuestas->error_400();
                }else{
                    $this->nombre = $datos['nombre'];
                    $this->apellido = $datos['apellido'];
                    $this->observaciones = $datos['observaciones'];
                    
                    $resp = $this->insertarUsuarios();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "id" => $resp
                        );
                        return $respuesta;
                    }else{
                        return $_respuestas->error_500();
                    }
                }

            
          
}
    


    private function insertarUsuarios(){
        $query = "INSERT INTO " . $this->table . " (nombre,apellido,observaciones)
        values
        ('" . $this->nombre . "','" . $this->apellido . "','" . $this->observaciones ."')"; 
        $resp = parent::nonQueryId($query);
        if($resp){
             return $resp;
        }else{
            return 0;
        }
    }
    


    public function put($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

       
                if(!isset($datos['id'])){
                    return $_respuestas->error_400();
                }else{
                    $this->id = $datos['id'];
                    if(isset($datos['nombre'])) { $this->nombre = $datos['nombre']; }
                    if(isset($datos['apellido'])) { $this->apellido = $datos['apellido']; }
                    if(isset($datos['observaciones'])) { $this->observaciones = $datos['observaciones']; }
                    
        
                    $resp = $this->modificarUsuarios();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "id" => $this->id
                        );
                        return $respuesta;
                    }else{
                        return $_respuestas->error_500();
                    }
                }

            }
        


    


    private function modificarUsuarios(){
        $query = "UPDATE " . $this->table . " SET nombre ='" . $this->nombre . "',apellido = '" . $this->apellido . "', observaciones = '" . $this->observaciones . "' WHERE id = '" . $this->id . "'"; 
        $resp = parent::nonQuery($query);
        if($resp >= 1){
             return $resp;
        }else{
            return 0;
        }
    }


    public function delete($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        

                if(!isset($datos['id'])){
                    return $_respuestas->error_400();
                }else{
                    $this->id = $datos['id'];
                    $resp = $this->eliminarUsuario();
                    if($resp){
                        $respuesta = $_respuestas->response;
                        $respuesta["result"] = array(
                            "id" => $this->id
                        );
                        return $respuesta;
                    }else{
                        return $_respuestas->error_500();
                    }
                }

            }
        



     
    


    private function eliminarUsuario(){
        $query = "DELETE FROM " . $this->table . " WHERE id= '" . $this->id . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1 ){
            return $resp;
        }else{
            return 0;
        }
    }



}





?>
