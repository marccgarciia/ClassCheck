<?php

namespace App\Http\Controllers;

use App\Mail\EnviarCorreo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Alumno;
use App\Models\Profesor;


class AuthController extends Controller
{
    public function verLogin()
    {
        return view('login');
    }

    public function verPassword()
    {
        return view('password');
    }

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



    public function admin()
    {
        return view('admin');
    }

    public function alumno()
    {
        return view('alumno');
    }

    public function profesor()
    {
        return view('profesor');
    }



    //LOGOUT
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




    # OPTIMIZAR CÓDIGO LUEGO
    # SE PUEDE METER LA FUNCION DE CAMBIAR PASS EN 1
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

    public function mail(Request $request)
    {
        $correo = $request->input('correo');
        $password = Str::random(mt_rand(8, 12));
        $sub = "Reestablecimiento de contraseña";

        $alumno = Alumno::where('email', $correo)->first();
        if ($alumno) {
            $alumno->password = bcrypt($password);
            $alumno->save();

            $datos = array('msg' => "Bienvenido Alumno, su contraseña reestablecida es: {$password}  ¡Puedes cambiarla al iniciar sesión para más seguridad!");
            $enviar = new EnviarCorreo($datos);
            $enviar->sub = $sub;
            $from = "contactoclasscheck@gmail.com";
            Mail::to($correo)->send($enviar->from($from));

            return redirect("/")->with('status', 'Correo enviado correctamente');
        }

        $profesor = Profesor::where('email', $correo)->first();
        if ($profesor) {
            $profesor->password = bcrypt($password);
            $profesor->save();

            $datos = array('msg' => "Bienvenido Profesor, su contraseña reestablecida es: {$password} ¡Puedes cambiarla al iniciar sesión para más seguridad!");
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
