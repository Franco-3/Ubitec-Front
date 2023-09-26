<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\User_ruta;
use App\Models\Ruta;
use Illuminate\Support\Facades\Session;

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
            $newRuta = $this->store();
            session(['idRuta' => $newRuta]); //configrar para crear una nueva ruta en caso de que no exista ninguna
        }



        $direcciones = $this->searchDirections(session('idRuta'));

        $responseData = [];
        //para revisar el siguiente codigo -ToDo: hay que corregir errores
        $ruta = $this->getPolylines(session('idRuta')); //obtener la ruta y las polylineas
        if(!empty($ruta->polyline))
        {
            $responseData = $this->giveFormat($ruta); //darle el formato para enviar al front
        }


        return view('backend.rutas.index', compact('idUsuario', 'direcciones', 'responseData'));
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
        $ruta = Ruta::findOrFail($idRuta);
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
                            ->select('idDireccion','direccion', 'latitud', 'longitud', 'tipo')
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



}


class Polyline
{
    /**
     * Default precision level of 1e-5.
     *
     * Overwrite this property in extended class to adjust precision of numbers.
     * !!!CAUTION!!!
     * 1) Adjusting this value will not guarantee that third party
     *    libraries will understand the change.
     * 2) Float point arithmetic IS NOT real number arithmetic. PHP's internal
     *    float precision may contribute to undesired rounding.
     *
     * @var int $precision
     */
    protected static $precision = 5;

    /**
     * Apply Google Polyline algorithm to list of points.
     *
     * @param array $points List of points to encode. Can be a list of tuples,
     *                      or a flat, one-dimensional array.
     *
     * @return string encoded string
     */
    final public static function encode( $points )
    {
        $points = self::flatten($points);
        $encodedString = '';
        $index = 0;
        $previous = array(0,0);
        foreach ( $points as $number ) {
            $number = (float)($number);
            $number = (int)round($number * pow(10, static::$precision));
            $diff = $number - $previous[$index % 2];
            $previous[$index % 2] = $number;
            $number = $diff;
            $index++;
            $number = ($number < 0) ? ~($number << 1) : ($number << 1);
            $chunk = '';
            while ( $number >= 0x20 ) {
                $chunk .= chr((0x20 | ($number & 0x1f)) + 63);
                $number >>= 5;
            }
            $chunk .= chr($number + 63);
            $encodedString .= $chunk;
        }
        return $encodedString;
    }

    /**
     * Reverse Google Polyline algorithm on encoded string.
     *
     * @param string $string Encoded string to extract points from.
     *
     * @return array points
     */
    final public static function decode( $string )
    {
        $points = array();
        $index = $i = 0;
        $previous = array(0,0);
        while ($i < strlen($string)) {
            $shift = $result = 0x00;
            do {
                $bit = ord(substr($string, $i++)) - 63;
                $result |= ($bit & 0x1f) << $shift;
                $shift += 5;
            } while ($bit >= 0x20);

            $diff = ($result & 1) ? ~($result >> 1) : ($result >> 1);
            $number = $previous[$index % 2] + $diff;
            $previous[$index % 2] = $number;
            $index++;
            $points[] = $number * 1 / pow(10, static::$precision);
        }
        return $points;
    }

    /**
     * Reduce multi-dimensional to single list
     *
     * @param array $array Subject array to flatten.
     *
     * @return array flattened
     */
    final public static function flatten( $array )
    {
        $flatten = array();
        array_walk_recursive(
            $array, // @codeCoverageIgnore
            function ($current) use (&$flatten) {
                $flatten[] = $current;
            }
        );
        return $flatten;
    }

    /**
     * Concat list into pairs of points
     *
     * @param array $list One-dimensional array to segment into list of tuples.
     *
     * @return array pairs
     */
    final public static function pair( $list )
    {
        return is_array($list) ? array_chunk($list, 2) : array();
    }
}
