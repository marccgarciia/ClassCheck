<?php

namespace App\Http\Controllers;

// Importamos la clase 'Enviar Correo' desde el archivo 'EnviarCorreo.php' en  el directorio `app/Mail
use App\Mail\EnviarCorreo;
use Illuminate\Http\Request;
// Importamos la clase para manejar la autenticación de usuarios
use Illuminate\Support\Facades\Auth;
// Importamos la clase Hash para manejar el hashing de contraseñas
use Illuminate\Support\Facades\Hash;
// Importamos la clase Mail para poder enviar correos electronicos
use Illuminate\Support\Facades\Mail;
// Importamos la clase STR para poder generar strings aleatorios
use Illuminate\Support\Str;
// Importamos los modelos Alumno y Profesor del directorio App/Models
use App\Models\Alumno;
use App\Models\Profesor;


class AuthController extends Controller
{
    // Definimos esta función para devolver la vista del login
    public function verLogin()
    {
        return view('login');
    }
    // Esta funcion devuelve la vista Password
    public function verPassword()
    {
        return view('password');
    }

    // Esta función maneja el intento de inicio de sesión del usuario. La función valida los datos de 
    // entrada del usuario, luego intenta iniciar sesión para cada tipo de usuario(alumno, profe o admin)
    // y redirige al usuario al panel correspondiente si las credenciales son correctas. Si las credenciales
    // son incorrectas, el usuario es redirigido a la vista login con un msg de error.
    public function login_post(Request $request)
    {
        // Validar el input
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intento de login
        $credentials = $request->only('email', 'password');
        // dd($credentials);
        if (Auth::guard('alumno')->attempt(array_merge($credentials, ['estado' => true]))) {
            return redirect()->route('alumno.panel');

        } elseif (Auth::guard('profesor')->attempt(array_merge($credentials, ['estado' => true]))) {
            return redirect()->route('profesor.panel');

        } elseif (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.panel');

        } else {
            return redirect()->route('verLogin')->withErrors([
                'email' => 'Email o Contraseña incorrectas.',
            ]);
        }
    }


    // Devuelve la vista admin
    public function admin()
    {
        return view('admin');
    }
    // Devuelve la vista alumno
    public function alumno()
    {
        return view('alumno');
    }
    // Devuelve la vista profesor
    public function profesor()
    {
        return view('profesor');
    }



    // PRINCIPIO DE LOGOUTS
    // Estas funciones manejan los logouts con todos los tipos de roles
    // Las funciones cierran las sesiones de los usuarios, la invalida,
    // regenera el token CSRF y los devuelve a la vista Login.
    public function logout_admin(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();
        return redirect()->route('verLogin');
    }

    public function logout_alumno(Request $request)
    {
        Auth::guard('alumno')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();
        return redirect()->route('verLogin');
    }

    public function logout_profesor(Request $request)
    {
        Auth::guard('profesor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();
        return redirect()->route('verLogin');
    }

    // FIN LOGOUT




    // Esta función cambia la contraseña de los alumnos. La nueva contraseña se obtiene de la
    // entrada del formulario "newpass" y se hashea con la función `hash:make()` antes 
    // de ser guardada en la base de datos. Luego se cierra sesión y devuelve el login.
    public function passalumno(Request $request)
    {
        $request->validate([
            'newpass' => 'required',
        ]);

        $user = Auth::guard('alumno')->user();
        $user->password = Hash::make($request->input('newpass'));
        $user->save();

        // Cerramos la sesión ya que no queremos que el usuario pueda ir hacia atrás en el panel lmao
        Auth::guard('alumno')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();
        return redirect()->route('verLogin');
    }

    // Esta función cambia la contraseña de los profesores. La nueva contraseña se obtiene de la
    // entrada del formulario "newpass" y se hashea con la función `hash:make()` antes 
    // de ser guardada en la base de datos. Luego se cierra sesión y devuelve el login.
    public function passprofe(Request $request)
    {
        $request->validate([
            'newpass' => 'required',
        ]);

        $user = Auth::guard('profesor')->user();
        $user->password = Hash::make($request->input('newpass'));
        $user->save();

        // Cerramos la sesión ya que no queremos que el usuario pueda ir hacia atrás en el panel lmao
        Auth::guard('profesor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();
        return redirect()->route('verLogin');
    }
    /*La función mail(Request $request) maneja la lógica para restablecer la contraseña de un usuario que ha olvidado 
    su contraseña. Se obtiene la dirección de correo electrónico del usuario de la entrada de formulario "correo". 
    Luego se busca en las tablas de alumnos y profesores si existe un usuario con el correo electrónico proporcionado. 
    Si se encuentra un usuario, se genera una nueva contraseña aleatoria utilizando la función Str::random() y se hashea 
    con bcrypt() antes de guardarla en la base de datos. Luego se envía un correo electrónico al usuario utilizando la clase 
    EnviarCorreo y la función Mail::to(). Si el correo electrónico no pertenece a ningún usuario registrado, se redirige al usuario a
     la página anterior con un mensaje de error. Si se envía el correo electrónico correctamente, se redirige al usuario a la página de 
     inicio con un mensaje de éxito.
    */
    public function mail(Request $request)
    {
        $correo = $request->input('correo');
        $password = Str::random(mt_rand(8, 12));
        $sub = "Reestablecimiento de contraseña";

        $alumno = Alumno::where('email', $correo)->first();
        if ($alumno) {
            $alumno->password = bcrypt($password);
            $nombre = $alumno->nombre;
            $alumno->save();

            $datos = array('bnv' => "Bienvenido {$nombre}",'msg' => "Su contraseña reestablecida es: {$password}.");
            $enviar = new EnviarCorreo($datos);
            $enviar->sub = $sub;
            $from = "contactoclasscheck@gmail.com";
            Mail::to($correo)->send($enviar->from($from));

            return redirect("/")->with('status', 'Correo enviado correctamente');
        }

        $profesor = Profesor::where('email', $correo)->first();
        if ($profesor) {
            $profesor->password = bcrypt($password);
            $nombre = $profesor->nombre;
            $profesor->save();

            $datos = array('bnv' => "Bienvenido {$nombre}",'msg' => "Su contraseña reestablecida es: {$password}.");
            $enviar = new EnviarCorreo($datos);
            $enviar->sub = $sub;
            $from = "contactoclasscheck@gmail.com";
            Mail::to($correo)->send($enviar->from($from));

            return redirect("/")->with('status', 'Correo enviado correctamente');
        }

        // Si el correo no pertenece a ningún alumno o profesor, redirigimos con un error
        return redirect()->back()->withErrors([
            'correo' => 'El correo ingresado no pertenece a ningún usuario.',
        ]);
    }
}
