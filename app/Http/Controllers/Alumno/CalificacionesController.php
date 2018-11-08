<?php

namespace App\Http\Controllers\Alumno;

use Validator;
use App\Alumnos;
use App\Materias;
use App\Calificaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Concerns\isDirty;

class CalificacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $alumnos = User::get(['nombre', 'ap_paterno']);
        // //$calificaciones = Calificaciones::all();

        // return response()->json(['data' => $alumnos], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // $reglas = [
        //     'id_t_materia' => 'required|number',
        //     'id_t_usuario' => 'required|number',
        //     'calificacion' => 'required|number|between:0,10.00',
        //     'fecha_registro' => 'date_format:"Y-m-d"|required'
        // ];
       $validator = Validator::make($request->all(),[
            'id_t_materia' => 'required|numeric',
            'id_t_usuario' => 'required|numeric',
            'calificacion' => 'required|numeric|between:0,10.00',
            'fecha_registro' => 'required|date_format:"Y-m-d"'
        ]);

        if($validator->fails()){
            $result = [
                'success' => 'error',
                'msg' => 'Error en validacion de campos',
                'error' => $validator->errors()
            ];
            return response()->json($result, 409);
        }

        $campos = $request->all();

        $materia = Materias::find($campos["id_t_materia"]);
        $alumno = Alumnos::find($campos["id_t_usuario"]);

        if(empty($materia) || empty($alumno)){
            $result = [
                'success' => 'error',
                'msg' => 'El alumno o materia que quiere registrar no existe'
            ];
            return response()->json($result, 409);            
        }
        try{
            $alumno = Calificaciones::create($campos);
            $result = [
                'success' => 'ok',
                'msg' => 'calificacion registrada'
            ];
            return response()->json($result, 200);            
        }catch (\Exception $e){
            $result = [
                'success' => 'error',
                'msg' => 'Error al guardar la calificacion',
                'error' => $e->getMessage()
            ];
            return response()->json($result, 409);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
/*        $cal = Calificaciones::has('alumnocalificacion')->where('id_t_usuarios', $id)->get();*/
        // $alumno = User::with('calificacion_alumno')->where('id_t_usuarios',$id)->get(['nombre', 'ap_paterno', 'calificacion', 'fecha_registro']);
        $calificacion_alumno = DB::table('t_calificaciones as C')
                            ->select('A.id_t_usuario', 'A.nombre', 'A.ap_paterno as apellido', 'M.nombre as materia', 'C.calificacion', DB::raw('DATE_FORMAT(C.fecha_registro, "%d-%m-%Y") as fecha_registro'))
                            ->join('t_alumnos as A', 'C.id_t_usuario', '=','A.id_t_usuario')
                            ->join('t_materias as M', 'C.id_t_materia', '=', 'M.id_t_materia')
                            ->where('C.id_t_usuario', $id)
                            ->get();
        $promedio_alumno = DB::table('t_calificaciones as C')->select(DB::raw('FORMAT(AVG(C.calificacion),2) as promedio'))->where('C.id_t_usuario', $id)->get();
        return response()->json([$calificacion_alumno, $promedio_alumno], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

       $validator = Validator::make($request->all(),[
            'calificacion' => 'required|numeric|between:0,10.00',
        ]);

        if($validator->fails()){
            $result = [
                'success' => 'error',
                'msg' => 'Error en validacion de campos',
                'error' => $validator->errors()
            ];
            return response()->json($result, 409);
        }               
        //
        try{
            $calificacion = Calificaciones::find($id);
            //Validamos que si exista la calificacion
            if(empty($calificacion)){
                $result = [
                    'success' => 'error',
                    'msg' => 'El id de la calificacion no existe.'
                ];               
                return response()->json($result, 200);
            }

            $calificacion->calificacion = $request->calificacion;

            $calificacion->save();

            $result = [
                'success' => 'ok',
                'msg' => 'calificacion actualizada',
            ];
            return response()->json($result, 200);
        } catch(\Exception $e){
            $result = [
                'success' => 'error',
                'msg' => 'Error al actualizar la calificacion',
                'errores' => $e->getMessage()
            ];
            return response()->json($result, 409);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $calificacion = Calificaciones::find($id);
        //Validamos que si exista la calificacion
        if(empty($calificacion)){
            $result = [
                'success' => 'error',
                'msg' => 'El id de la calificacion a eliminar no existe.'
            ];               
            return response()->json($result, 200);
        }
        try{
            $calificacion->delete();
            $result = [
                'success' => 'ok',
                'msg' => 'calificacion eliminada',
            ];
            return response()->json($result, 200);            
        } catch(\Exception $e){
            $result = [
                'success' => 'error',
                'msg' => 'Error al eliminar la calificacion',
                'errores' => $e->getMessage()
            ];
            return response()->json($result, 409);            
        }
        
    }
}
