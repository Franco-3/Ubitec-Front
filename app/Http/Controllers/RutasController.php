<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\User_ruta;
use App\Models\Ruta;
use Illuminate\Support\Facades\Session;
use App\Models\Polyline;
use Illuminate\Support\Facades\File;

class RutasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        session_start();
        ob_start();
        
        $idUsuario = Auth::id();
        session(['idUser' => $idUsuario]);

        //buscar la ruta mas actual para mostrar en el inicio
        if(!Session::has('idRuta'))
        {

            $idRuta = $this->findMaxIdRuta($idUsuario);
            session(['idRuta' => $idRuta]);
        }
        else $idRuta = session('idRuta');

        if(is_null($idRuta))
        {
            $idRuta = $this->store();
            session(['idRuta' => $idRuta]); //configrar para crear una nueva ruta en caso de que no exista ninguna
        }


        $direcciones = $this->searchDirections(session('idRuta'));
        $kmTotal = $this->searchKmTotal($idRuta);
        $responseData = [];
        //para revisar el siguiente codigo -ToDo: hay que corregir errores
        $puntosPolylinea = $this->getPolylines(session('idRuta')); //obtener la ruta y las polylineas
        $imagenRuta = false;
        if(!empty($puntosPolylinea->polyline))
        {
            $responseData = $this->giveFormat($puntosPolylinea); //darle el formato para enviar al front

            $ruta = Ruta::find(session('idRuta'));
            $rutaPath = $ruta->path;

            if( $rutaPath == 'img/imagen_default.jpg')
            {
                //si hay una polylinea 
                $imagenRuta = true;
            }

        }


        return view('backend.rutas.index', compact('idUsuario', 'direcciones', 'responseData', 'kmTotal', 'imagenRuta'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $newRuta = $this->store();
        session(['idRuta' => $newRuta]);

        return back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        // generar nueva ruta
        $ruta = new Ruta();
        $ruta->estado = 'P';
        $ruta->kmTotal = null;
        $ruta->path = 'img/imagen_default.jpg';
        $ruta->save();

        //enlazar la ruta y el usuario en la tabla usuarios_ruta
        $userRuta = new User_ruta();
        $userRuta->idRuta = $ruta->getKey();
        $userRuta->idUsuario = session('idUser');
        $userRuta->idVehiculo = null;
        $userRuta->save();
        return $ruta->getKey();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //$categoria = Categoria::findOrFail($id);
        return view('backend.rutas.sh.ow');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //$categoria = Categoria::findOrFail($id);
        //$users = User::pluck('name', 'id');
        //return view('backend.categorias.edit', compact('noticia', 'users'));
        return view('backend.rutas.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {

        return redirect()->route('rutas.index');
    }

    public function agregarCaptura(Request $request)
    {

        $idRuta = session('idRuta');

        $carpeta = storage_path("public/images_ruta");

        // Verifica si la carpeta ya existe
        if (!File::exists($carpeta)) {
            // Si no existe, crea la carpeta
            File::makeDirectory($carpeta, 0755, true, true);
        }

        $image = $request->file('capturedImage');
        $nombreArchivo = 'ruta'.$idRuta.'.png';
        // Guarda la imagen en una ubicación deseada en tu servidor
        $image->storeAs('public/images_ruta', $nombreArchivo); // Esto es solo un ejemplo, ajusta la ubicación según tus necesidades

        $ruta = Ruta::find($idRuta);

        $rutaPath = 'storage/images_ruta/ruta'.$idRuta.'.png';
        $ruta->path = $rutaPath;
        $ruta->save();

        return response()->json(['message' => 'Imagen guardada exitosamente']);
    }

    private function findMaxIdRuta(string $id){

        $idUsuario = $id; // id del usuario

        $mayorIdRuta = DB::table('user_ruta')
                        ->join('rutas', 'user_ruta.idRuta', '=', 'rutas.idRuta')
                        ->where('user_ruta.idUsuario', $idUsuario)
                        ->max('user_ruta.idRuta');

        return $mayorIdRuta;

    }

    private function getPolylines(string $idRuta)
    {
        $ruta = Ruta::find($idRuta);
        return $ruta;
    }

    private function giveFormat($ruta)
    {
        $citiesString = Polyline::decode($ruta->cities_polyline);
        $cities = Polyline::pair($citiesString);

        $polylineString = Polyline::decode($ruta->polyline);
        $polyline = Polyline::pair($polylineString);
        foreach($cities as $waypoint)
        {
            $coordinates[] = [
                'lat' => $waypoint[0],
                'lng' => $waypoint[1]
            ];

        }


        $responseData = [
            'status' => 'OK',
            'data' => [
                'cities' => [],
                'coordinates' => $coordinates
            ],
            'polyline' => $polyline
        ];

        return $responseData;
    }

    private function searchDirections(string $idRuta)
    {
        $direccionesUsuario = DB::table('rutas')
                            ->join('direcciones', 'rutas.idRuta', '=', 'direcciones.idRuta')
                            ->where('rutas.idRuta', $idRuta)
                            ->select('idDireccion','direccion', 'latitud', 'longitud', 'tipo', 'direcciones.estado', 'direcciones.descripcion', 'direcciones.imagen')
                            ->orderBy('orden', 'asc')
                            ->get();


        //buscar las direcciones de inicio y final
        $inicio = null;
        $final = null;

        foreach ($direccionesUsuario as $direccion) {
            if ($direccion->tipo === 'inicio') {
                $inicio = $direccion;
            } elseif ($direccion->tipo === 'final') {
                $final = $direccion;
            }
        }
        //guardar en session el inicio y final
        session(['inicio' => $inicio]);
        session(['final' => $final]);


        // Filtrar las direcciones para eliminar "inicio" y "final"
        $direccionesUsuario = $direccionesUsuario->filter(function ($direccion) {
            return $direccion->tipo !== 'inicio' && $direccion->tipo !== 'final';
        });

        return $direccionesUsuario;
    }

    private function searchKmTotal(string $idRuta)
    {
        $ruta = Ruta::find($idRuta);
        if($ruta)
        {
            $kmTotal = $ruta->kmTotal;
        }
        else{
            $kmTotal = null;
        }

        return $kmTotal;
    }




}
