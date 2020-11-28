
<?php

	/**
	 *creamos la clase conexion con sus atributos privados
	 */
	class conexion {
		
		private $server; 
		private $user;
		private $password;
		private $database;
		private $port;
		private $conexion;

		

		// instanciamos la funcion conexion  y este llama al metodo constructor

		function __construct(){

			$listadatos 	=  $this->datosConexion();
			foreach ($listadatos as $key => $value) {
			
			 	# recorremos la variable cada fila se almacena en $value
			 	#le digo al sistema que nos iguale los atributos de la clase a los valores
			 	$this->server 	= $value['server'];
			 	$this->user 	= $value['user'];
			 	$this->password = $value['password'];
			 	$this->database = $value['database'];
			 	$this->port 	= $value['port'];

			}


			// creamos la conexion

			$this->conexion = new mysqli($this->server, $this->user,$this->password,
										  $this->database,$this->port);

			// imprimimos un error
			
			if ($this->conexion->connect_errno) {
				
				echo "Algo va mal con la conexion";
				die();# funcion die, para que no siga ejecutandose
			}


		}



		// obtenemos los datos del archivo y lo convertimos
		//creamos un metodo privado,que obtiene los datos del archivo conexion y los convierte a una array no recibe ningun parametro,pero se crea una variable $direccion.

		private function datosConexion(){

				$direccion	= 	dirname(__FILE__);					// direccion de este archivo mandamos
				$jsondata 	=	file_get_contents($direccion. "/". "config");//esta funcion guarda 														todo el contenido del archivo y lo envia
				return json_decode($jsondata, true);							//retornamos un json y lo 												convertimos a un array asociativocon true




		}

		// creamos un metodo privado que convierte a utf8

		private function ConvertirUTF8($array){
												  // parametro por referencia &
			array_walk_recursive($array, function(&$item,$key){// recibe dos parametros un array y un  															trigger
					

					if (!mb_detect_encoding($item, 'utf-8',true))
					 {
						# si no detecta ningun caracter raro entones el item lo va a convertir a UTF y true

					 		$item = utf8_encode($item);

					 	}

					});
			return $array;
		}

		// funcion para obtener datos, recibe un query($sqlstr), que seria como un select *from

			public function obtenerDatos($sqlstr){

			
				$results 		= $this->conexion->query($sqlstr);
				
				$resultArray 	= array(); // creamos un  array vacio
				foreach ($results as $key) {
					# recorre el array $results y le sacamos el $value porque se debe agregar toda la linea 
									 // es una fila esta variable
					$resultArray[] = $key;//y cree una nueva fila, es una abreviacion del array push

				}
				return ($resultArray);// reornamos convirtiendo a utf8





			}


			public function nonQuery($sqlstr){

				$results = $this->conexion->query($sqlstr);
				return $this->conexion->affected_rows;

			}
				// metodo que usamos insert
			public function nonQueryId($sqlstr){

				$results 	= $this->conexion->query($sqlstr);
				$filas 		= $this->conexion->affected_rows;
				if ($filas >= 1) {
					# filas afectadas por eso es igual a 1

					return $this->conexion->insert_id;
				}else{



					return 0;
				}

			}
	}




?>