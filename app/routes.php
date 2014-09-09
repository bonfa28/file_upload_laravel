<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get("upload", function(){
	return View::make("upload");
});
Route::post("upload", function(){
	$file = Input::file("photo");
	$dataUpload = array(
		"username" => Input::get("username"),
		"email" => Input::get("email"),
		"password" => Input::get("password"),
		"photo" => $file//campo foto para validar
	);

		$rules = array(
		  'username' =>'required|min:2|max:100',
		  'email' => 'required|email|min:6|max:100|unique:users',
		  'password' => 'required|confirmed|min:6|max:100',
		  'photo' => 'required'
		);

		$messages = array(
		  'required' => 'El campo: attribute es obligatorio.',
		  'min' => 'El campo :attribute no puede tener menos de :min carácteres.',
		  'email' => 'El campo :attribute debe ser un email valido.',
		  'max' => 'El campo :attribute nopuede tener mas de :min carácteres.',
		  'unique' => 'El email ingresado ya está registrado en el blog',
		  'confirmed' => 'Los password no coiciden'
		);
		$validation = Validator::make(Input::all(), $rules, $messages);
		//si la validacion falla redirigimos al formulario de registro con los errores
		//y con los campos que nos habia llenado el usuario
		if($validation->fails())
		{
			return Redirect::to('upload')->withErrors($validation)->withInput();
		}else{
			$user = new User(array(
				"username" => Input::get("username"),
				"email" => Input::get("email"),
				"password" => Hash::make(Input::get("password")),
				"photo" => Input::file("photo")->getClientOriginalName()//nombre original de la foto
			));
			if($user->save()){
				//guardamos la imagen en public/imgs con el nombre original
				$file->move("imgs", $file->getClientOriginalName());
				//redirigimos con un mensaje flash
				return Redirect::to("upload")->with(array('confirm' =>'Te has registrado correctamente.'));
			}

		}
});