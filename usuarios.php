<?php
require_once 'respuestas.php';
require_once 'usuarios.php';
require_once 'usuariosUtiles.php';

$_respuestas = new respuestas;
$_usuarios = new usuarios;


if($_SERVER['REQUEST_METHOD'] == "GET"){

   if (isset($_GET["page"])) {
            
            $pagina = $_GET["page"];
            $_usuarios->listaUsuarios($pagina);
            $_listaUsuarios = $_usuarios->listaUsuarios($pagina);//
            header("Content-Type: application/json");// le decimos que es una aplicacion json
            echo json_encode($_listaUsuarios);# que la devolucion nos convierta en un Json
            http_response_code(200);// respuesta de codigo error


        }else if(isset($_GET['id'])){ // confirmamos si existe una variable en el GET que se llame id
                $usuariosId = $_GET['id'];
                $datosUsuarios = $_usuarios->obtenerUsuarios($usuariosId);//llamamos al metodo
                header("Content-Type: application/json");// idem...es una aplicacion json
                echo json_encode($datosUsuarios);// imprimimos en formato json
                http_response_code(200);// respuesta de codigo


}
    
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos los datos al manejador
    $datosArray = $_usuarios->post($postBody);
    //delvovemos una respuesta 
     header('Content-Type: application/json');
     if(isset($datosArray["result"]["error_id"])){
         $responseCode = $datosArray["result"]["error_id"];
         http_response_code($responseCode);
     }else{
         http_response_code(200);
     }
     echo json_encode($datosArray);




    
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
      //recibimos los datos enviados
      $postBody = file_get_contents("php://input");
      //enviamos datos al manejador
      $datosArray = $_usuarios->put($postBody);
        //delvovemos una respuesta 
     header('Content-Type: application/json');
     if(isset($datosArray["result"]["error_id"])){
         $responseCode = $datosArray["result"]["error_id"];
         http_response_code($responseCode);
     }else{
         http_response_code(200);
     }
     echo json_encode($datosArray);





}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){

        
        $headers = getallheaders();
        if(isset($headers["id"])){
            //recibimos los datos enviados por el header
            
                $send = [
                
                "id" =>$headers["id"]
            ];
            $postBody = json_encode($send);
            
        }else{
            //recibimos los datos enviados
            $postBody = file_get_contents("php://input");
        }
        
        //enviamos datos al manejador
        $datosArray = $_usuarios->delete($postBody);
        //delvovemos una respuesta 
        header('Content-Type: application/json');
        if(isset($datosArray["result"]["error_id"])){
            $responseCode = $datosArray["result"]["error_id"];
            http_response_code($responseCode);
        }else{
            http_response_code(200);
        }
        echo json_encode($datosArray);
       

}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}





?>