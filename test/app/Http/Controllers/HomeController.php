<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function empleado(Request $request)
    {
        $empleados = Empleado::where('activo',1)->get();

        return['empleados' => $empleados];
    }

    public function store(Request $request)
    {
        $empleado = new Empleado();
        $empleado->codigo = $request->codigo;
        $empleado->nombre = $request->nombre;
        $empleado->apellido_paterno = $request->apellidop;
        $empleado->apellido_materno = $request->apellidom;
        $empleado->correo = $request->correo;
        $empleado->tipo_contrato = $request->tipo;
        $empleado->activo = 1;
        $empleado->save();
    }
}
