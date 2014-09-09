<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="UTF-8">
	<!--cargamos los css-->
	{{HTML::style('css/foundation.min.css')}}
	{{HTML::style('css/normalize.css')}}
	<title>Titulo</title>
</head>
<body>
	<div class="row">
		<h1 class="subheader">Subir imágenes con laravel 4</h1>
		<!-- si el formulario contiene errores de validación-->
		@if($errores->has())
		 <div class="alert-box alert">
		   <!-- recorremos los errores en un loop y los mostramos-->
		   @foreach($errores->all('<p>:message</p>') as $message)
			  {{$message}}
		   @endforeach	
		 </div>
		@endif

		@if(Session::has('confirm'))
		 <div class="alert-box succes round">
		 	{{Session::get('confirm')}}	
		 </div>	
		@endif
		<div class="form">
		  {{Form::open(array('url'=>'upload', files=>true))}}
		  {{Form::label('photo', 'Foto')}}

		  <!-- asi se crea un campo file en laravel -->
		  {{From::file('photo')}}
		  {{Form::label('email', Email)}}
		  {{Form::email('email', input::old('email'))}}
		  {{Form::label('username', Username)}}
		  {{Form::text('username', input::old('username'))}}
		  {{Form::label('password', Password)}}
		  {{Form::password('password')}}
		  {{Form::password('password_confirmation')}}

		  <br/>
		  {{Form::submit('Registrarme', array("class"=>"button expand round"))}}
		  {{Form::close()}}	
		</div>

	</div>

</body>
</html>