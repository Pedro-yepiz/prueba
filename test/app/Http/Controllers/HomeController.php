<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;
use Illuminate\Support\Facades\DB;
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
        if (!$request->ajax()) return redirect('/');   

        $empleados = Empleado::where('eliminado',0)->get();

        return['empleados' => $empleados];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); 

        try{
            DB::beginTransaction();

            if ($request->id == 0) {
                $empleado = new Empleado();
                $empleado->codigo = $request->codigo;
                $empleado->nombre = $request->nombre;
                $empleado->apellido_paterno = $request->apellidop;
                $empleado->apellido_materno = $request->apellidom;
                $empleado->correo = $request->correo;
                $empleado->tipo_contrato = $request->tipo;
                $empleado->activo = 1;
                $empleado->eliminado = 0;
                $empleado->save();
            } else {
                $empleado = Empleado::find($request->id);
                $empleado->codigo = $request->codigo;
                $empleado->nombre = $request->nombre;
                $empleado->apellido_paterno = $request->apellidop;
                $empleado->apellido_materno = $request->apellidom;
                $empleado->correo = $request->correo;
                $empleado->tipo_contrato = $request->tipo;
                $empleado->save();
            }

        DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');   

        $empleado = Empleado::find($request->id);
        $empleado->activo = 0;
        $empleado->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');   

        $empleado = Empleado::find($request->id);
        $empleado->activo = 1;
        $empleado->save();
    }

    public function elimina(Request $request)
    {
        if (!$request->ajax()) return redirect('/');   

        $empleado = Empleado::find($request->id);
        $empleado->eliminado = 1;
        $empleado->save();
    }
}
