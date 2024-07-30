<?php
		$CantidadMostrar=10;
		//Conexion  al servidor mysql
		$conetar = new mysqli("localhost", "root", "", "inmoviliaria");
		if ($conetar->connect_errno) {
	    	echo "Fallo al conectar a MySQL: (" . $conetar->connect_errno . ") " . $conetar->connect_error;
		}else{
			// Validado  la variable GET
		    $compag         =(int)(!isset($_GET['pag'])) ? 1 : $_GET['pag']; 
			$TotalReg       =$conetar->query("SELECT * FROM casas");
			//Se divide la cantidad de registro de la BD con la cantidad a mostrar 
			$TotalRegistro  =ceil($TotalReg->num_rows/$CantidadMostrar);
			//La cantidad de resgistro se dividio a: </b>".$TotalRegistro." para mostrar 5 en 5<br>";
			//Consulta SQL
			$consultavistas ="SELECT * FROM casas ORDER BY id ASC
							LIMIT ".(($compag-1)*$CantidadMostrar)." , ".$CantidadMostrar;
		    // echo $consultavistas;
			$consulta=$conetar->query($consultavistas);
		         
			echo '<table class="table table-responsive" border="3">';			
				while ($lista=$consulta->fetch_row()) {
					echo '<td width="20%">
							<img src="img/home.jpg" width="250" height="200">
						</td>';
					echo '<th width="15%">
						id<br>
						Dirección<br>
						Ciudad<br>
						Telefono<br>
						Código Postal<br>
						Tipo<br>
						Precio<br>
					';
					echo '</th>';
					echo '<td>
						'.$lista[0].'<br>
						'.$lista[1].'<br>
						'.$lista[2].'<br>
						'.$lista[3].'<br>
						'.$lista[4].'<br>
						'.$lista[5].'<br>
						'.$lista[6].'<br>
						</td>';
					echo '<tr>';
						
				}
			echo "</table>";
	     	/*Sector de Paginacion */
	    	//Operacion matematica para boton siguiente y atras 
			$IncrimentNum =(($compag +1)<=$TotalRegistro)?($compag +1):1;
			$DecrementNum =(($compag -1))<1?1:($compag -1);
			
			echo '<table><tr>Al usar páginación, deberá pulsar nuevemente el botón <b>&nbspMostrar Todo</b>&nbsp o &nbsp 
				  <a href=index.php>CLICK AQUI </a>&nbsppara volver al Inicio</table>';	  
			echo '<table><tr><ins><b>■ PAGINACIÓN ■ </b></ins></tr></table>';
			//echo "<a href=index.php>"."INICIO </a>";


			echo "<a href=\"?pag=".$DecrementNum."\">◀</a>";
			
			//Se resta y suma el numero de pag actual con la cantidad de numeros a mostrar
			$Desde=$compag-(ceil($CantidadMostrar/2)-1);
			$Hasta=$compag+(ceil($CantidadMostrar/2)-1);
				     
			//Se valida
			$Desde=($Desde<1)?1: $Desde;
			$Hasta=($Hasta<$CantidadMostrar)?$CantidadMostrar:$Hasta;
			//Se muestra los numeros de paginas
			for($i=$Desde; $i<=$Hasta;$i++){
				//Se valida la paginacion total de registros
				if($i<=$TotalRegistro){
					//Validamos la pag activo
				    if($i==$compag){
				    	echo "<<<a href=\"?pag=".$i."\">".$i."</a>>>";
				    }else {
				    	echo "█&nbsp"."<a href=\"?pag=".$i."\">".$i."&nbsp</a>";
				     }     		
				} //if TotalRegistro
			} //for
			echo "<a href=\"?pag=".$IncrimentNum."\">▶</a>";
			
		} //else conexión
?>