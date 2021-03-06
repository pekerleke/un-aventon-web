<?php
	function render($vars = [])
	{
    function verificar_login($mail,$password,$result)
    {
      //parche
      $conexion=mysqli_connect("localhost","root","","base") or
    		die("Problemas con la conexión a la base de datos");

      $rec=mysqli_query($conexion,"SELECT * FROM Usuario WHERE email='$mail' AND clave='$password'")
      or
      die("Problemas en la base de datos:".mysqli_error($conexion));

      $count = 0;
      while($row = mysqli_fetch_array($rec))
      {
        $count++;
        $result = $row;
      }
      if($count == 1)
      {
        return $result;
      }
      else
      {
        return 0;
      }
    }


    function comprobar_string($string){
       if (strlen($string)<3 || strlen($string)>30){
          return false;
       }

       //compruebo que los caracteres sean los permitidos
       $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_@.";
       for ($i=0; $i<strlen($string); $i++){
          if (strpos($permitidos, substr($string,$i,1))===false){
             return false;
          }
       }
       return true;
    }


    $result = 67;
    if(isset($_POST['login'])){
      if( (comprobar_string($_POST['mail'])) & (comprobar_string($_POST['password'])) ){

            $result = verificar_login($_POST['mail'],$_POST['password'],$result);
            if($result != 0){
                $_SESSION['userId'] = $result['idUser'];
                $_SESSION['mail'] = $result['email'];
                $_SESSION['nombre'] = $result['nombre'];
                $_SESSION['apellido'] = $result['apellido'];

                header("Location: /");

            } //fin verificar usuario existe
      }// fin verificar string
      ?>
      <div class="alert alert-danger" role="alert">
 		 Email o contraseña son incorrectos.
	</div>
	<?php
    }// fin verificar login


		?>
	<!-- parche = cierro container superior -->
	</div>

	<div class="container h-100">
  	<div class="row h-100 justify-content-center align-items-center">
			<div class="card bg-white" style="max-width: 600px; height: 400px; margin-top: 20px; margin-bottom: 20px">
  			<div class="card-header"><h2 class="text-center">Iniciar Sesión</h2></div>
  			<div class="card-body">
    			<form action="/login" method="post">
				  <div class="form-group">
				    <label for="exampleInputEmail1">Dirección de Email</label>
				    <input type="email" name="mail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ingresa un email">
				    <small id="emailHelp" class="form-text text-muted">Tu información nunca será compartida con terceros.</small>
				  </div>
				  <div class="form-group">
				    <label for="exampleInputPassword1">Contraseña</label>
				    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Ingresa una contraseña">
				  </div>
				  <div class="form-check">
				  	<div class="row">
				  		<div class="col-lg-6">
				    		<input type="checkbox" class="form-check-input" id="exampleCheck1">
				    		<label class="form-check-label" for="exampleCheck1">Recuerdame</label>
							</div>
							<div class="col-lg-6 justify-content-right">
								<p class="text-right"><a href="/users/password/new">¿Olvidaste tu contraseña?</a></p>
							</div>
				  	</div>
				  </div>
				  <div class="container-fluid" style="margin-top:.5rem; padding: 0">
						<input type="submit" name="login" value="Inicia sesión!" class="btn btn-success form-control form-control-lg">
				  </div>
				</form>
 			 </div>
		</div>
	</div>
</div>

<!-- fin parche = abro container -->
<div class="container">

		<?php
	}
