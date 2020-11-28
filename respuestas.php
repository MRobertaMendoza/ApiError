
<?php


		/**Devolvemos las respuestas por un array , dentro de los status ok, pueden haer errores.
		creamos un atributo privado que sera igual a un array
		 * 
		 */
		class respuestas
		{
			
			private $response =[
				'status ' => "ok",
				'result' => array()

			];


			// creamos la 1era funcion publica o metodo, por metodo no permitido
			// le decimos que el atributo del array status me lo cambie de ok a error, porque el usuario cometio el error o el sistema que esta consumiendo la API, 
			public function error_405(){
					$this->response['status'] = "error";
					$this->response['result'] = array(
						"error_id"=>"405",
						"error_msg"=>"Metodo no permitido"

					);
					return $this->$response;
			}


			// error 200, (aunque no existe), pero puede haber un error en que la API reciba la solicitud pero este mal la solicitud, el parametro de $valor es opcional, si no funciona sigue la api funcionando

			public function error_200($valor = "Datos incorrectos"){

				$this->response['status'] = "error";
				$this->response['result'] = array(

                 "error_id"	=>"200",
                 "error_msg"=> $valor
				);

				return $this->$response;


			}
				//datos enviados incompletos
			public function error_400(){
				$this->response['status'] = "error";
				$this->response['result'] = array(

					"error_id" 	=> "400",
					"error_msg" => "Datos enviados incompletos o formato incorrecto"

				);
				return $this->response;


			}


		}


?>