<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use stdClass;
use App\Models\Direcciones;
use App\Models\Ruta;
use Error;

class TSPcontroller extends Controller
{

    public function postDirections()
    {
        if (session::has('inicio') && session::has('final')) {
                // Parámetros de la solicitud
            $origin = session('inicio')->direccion;
            $destination = session('final')->direccion;

            // Obtener las direcciones usando la función searchDirections
            $waypointsData = $this->searchDirections(session('idRuta'), true);

            // Obtener el array de direcciones desde la respuesta de la función searchDirections
            $waypoints = $waypointsData->map(function ($direccion) {
                return $direccion->direccion;
            })->toArray();

            $api_key = 'AIzaSyDGc0UBAR_Y30fX31EvaU65KATMx0c0ItI'; // Reemplaza con tu propia clave de API de Google Maps
            // Construir la URL de la solicitud
            $url = 'https://maps.googleapis.com/maps/api/directions/json?';
            $url .= 'origin=' . urlencode($origin);
            $url .= '&destination=' . urlencode($destination);
            $url .= '&waypoints=optimize:true|' . urlencode(implode('|', $waypoints));
            $url .= '&key=' . urlencode($api_key);

            // Realizar la solicitud HTTP
            $response = Http::get($url);
            
            // Decodificar la respuesta JSON
            $data = $response->json();

            // Procesar la respuesta
            if ($data['status'] == 'OK') {
                $coords = $data['routes'][0]['overview_polyline']['points'];
                $temp = Polyline::decode($coords);
                $polyline = Polyline::pair($temp); // Suponiendo que `decodePolylineToArray` es una función definida en otro archivo.


                // Obtener las ciudades en orden
                $legs = $data['routes'][0]['legs'];
                $cities = [];
                foreach ($legs as $leg) {
                    $cities[] = $leg['start_address'];
                }
                $cities[] = end($legs)['end_address'];

                // Obtener las coordenadas de las ciudades
                $coordinates = [];
                foreach ($legs as $leg) {
                    $coordinates[] = [
                        'lat' => $leg['start_location']['lat'],
                        'lng' => $leg['start_location']['lng']
                    ];
                }
                $coordinates[] = [
                    'lat' => end($legs)['end_location']['lat'],
                    'lng' => end($legs)['end_location']['lng']
                ];


                $responseData = [
                    'status' => 'OK',
                    'data' => [
                        'cities' => $cities,
                        'coordinates' => $coordinates
                    ],
                    'polyline' => $polyline
                ];

                //devolver las direcciones que se muetran en la tabla

                $points =[];
                $waypointsIndexes = $data['routes']['0']['waypoint_order'];//conseguir en indice de puntos de la rta

                $waypointsOriginals = array_values($waypointsData->toArray()); //los waypts originales llevados a array

                foreach ($waypointsOriginals as $indice => $point) {
                    $index_waypoint = $waypointsIndexes[$indice];//conseguir el indice de el punto acutal
                    $points[$index_waypoint] = $point; // asignar los datos al array en la posicion indicada en la rta

                    $this->updateOrden($point->idDireccion, $index_waypoint);//actualizar la bd
                }

                $direcciones = [];
                foreach ($cities as $city) {
                    $objeto = new stdClass(); // Creamos un objeto vacío
                    $objeto->direccion = $city; // Agregamos la propiedad "direccion"
                    $direcciones[] = $objeto; // Agregamos el objeto al nuevo array
                }

                // Retornar las ciudades y sus coordenadas
                return redirect()->route('rutas.index');

            } else {
                // echo('Error al obtener las direcciones: ' . $data['status']);
                $error  = $data['status'];
                return redirect()->route('rutas.index')->with('error', $error);
            }

        }else return redirect()->route('rutas.index'); //agregar la respuesta que el error sucedede porque no estan definidos el inicio y el final


    }

    public function osrmOrder()
    {
        if (session::has('inicio') && session::has('final')) {

            // Obtener las direcciones usando la función searchDirections
            $waypointsData = $this->searchDirections(session('idRuta'), false);

            // Obtener el array de direcciones desde la respuesta de la función searchDirections
            $waypoints = $waypointsData->map(function ($direccion) {
                return ['direccion' => $direccion->direccion, 'latitude' => $direccion->latitud, 'longitude' => $direccion->longitud, 'id' => $direccion->idDireccion];
            })->toArray();


            if(sizeof($waypoints) > 25)
            {
                $direcciones = [];
                $response = $this->connectOSRM($waypoints);
                $coordinates = [];
                $polyline = $this->decodePolylineToArray($response[1]);
                foreach($response[0] as $waypoint)
                {
                    $coordinates[] = [
                        'lat' => $waypoint['latitude'],
                        'lng' => $waypoint['longitude']
                    ];

                }

            }
            elseif(sizeof($waypoints) <= 25 )
            {
                $direcciones = [];
                $response = $this->connectOSRM($waypoints);
                $coordinates = [];
                $poly = Polyline::decode($response[1]);
                $polyline = Polyline::pair($poly);



                foreach($response[0] as $waypoint)
                {
                    $coordinates[] = [
                        'lat' => $waypoint['latitude'],
                        'lng' => $waypoint['longitude']
                    ];

                }

                //guardar el recorrido
                $citiesPolyline = Polyline::encode($coordinates);
                $this->updatePolylines(session('idRuta'), $response[1], $citiesPolyline);

            }
            return redirect()->route('rutas.index');
        }else return redirect()->route('rutas.index'); //agregar la respuesta que el error sucedede porque no estan definidos el inicio y el final


    }

    private function connectOSRM(array $waypoints)
    {

        $osrm_api_url = 'http://127.0.0.1:5000/trip/v1/driving/';

        $lenght = count($waypoints) - 1;

        //cambiar las posiciones, porque el final esta en el 1 y debe estar en el ultimo
        $var1 = $waypoints[1];

        $waypoints[1] = $waypoints[$lenght];
        $waypoints[$lenght] = $var1;

        // Crear una cadena con las coordenadas de las ubicaciones para la URL
        $coordinates = '';
        foreach ($waypoints as $waypoint) {
            $coordinates .= $waypoint['longitude'] . ',' . $waypoint['latitude'] . ';';
        }
        $coordinates = rtrim($coordinates, ';'); // Eliminar el punto y coma final



        // Agregar las coordenadas a la URL
        $osrm_api_url .= $coordinates;

        // Agregar parámetros adicionales a la URL
        $osrm_api_url .= '?roundtrip=false&source=first&destination=last&steps=false&geometries=polyline&overview=full&annotations=false'; //?roundtrip=false&source=first&destination=last&steps=false&geometries=geojson&overview=false&annotations=false

        // Configurar la solicitud curl
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $osrm_api_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Realizar la solicitud a la API de OSRM
        $response = curl_exec($curl);
        curl_close($curl);
        // Decodificar la respuesta JSON
        $response_data = json_decode($response, true);



        $orderedCoordinates = [];
        if(isset($response_data['waypoints']))
        {
            foreach ($response_data['waypoints'] as $index => $waypointResponse) {
                $position = $waypointResponse['waypoint_index'];
                $orderedCoordinates[$position] = $waypoints[$index];

                $this->updateOrden($waypoints[$index]['id'], $position);
            }
        }
        ksort($orderedCoordinates);

        $polyline = $response_data['trips'][0]['geometry'];

        return [$orderedCoordinates, $polyline];



    }

    private function updatePolylines(string $id, string $polyline, string $citiesPolyline)
    {
        $ruta = Ruta::findOrFail($id);

        $ruta->update(['polyline' => $polyline, 'cities_polyline' => $citiesPolyline]);
    }

    private function updateOrden(int $id, int $orden)
    {
        $direccion = Direcciones::findOrFail($id);

        $direccion->update(['orden' => $orden]);
    }

    private function searchDirections(string $idRuta, bool $filter)
    {
        $direccionesUsuario = DB::table('rutas')
                            ->join('direcciones', 'rutas.idRuta', '=', 'direcciones.idRuta')
                            ->where('rutas.idRuta', $idRuta)
                            ->select('idDireccion','direccion', 'latitud', 'longitud', 'tipo')
                            ->get();


        // Filtrar las direcciones para eliminar "inicio" y "final"
        if($filter)
        {
            $direccionesUsuario = $direccionesUsuario->filter(function ($direccion) {
                return $direccion->tipo !== 'inicio' && $direccion->tipo !== 'final';
            });
        }

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

