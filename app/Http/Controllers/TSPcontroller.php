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
use App\Models\Polyline;
use App\Models\User_ruta;
use Ramsey\Uuid\Type\Decimal;

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
            // dd($data);
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

                //devolver las direcciones que se muetran en la tabla

                $points =[];
                $waypointsIndexes = $data['routes']['0']['waypoint_order'];//conseguir en indice de puntos de la rta

                $waypointsOriginals = array_values($waypointsData->toArray()); //los waypts originales llevados a array

                foreach ($waypointsOriginals as $indice => $point) {
                    $index_waypoint = $waypointsIndexes[$indice];//conseguir el indice de el punto acutal
                    $points[$index_waypoint] = $point; // asignar los datos al array en la posicion indicada en la rta
                    $this->updateOrden($point->idDireccion, $index_waypoint);//actualizar la bd
                }

                $legs = $data['routes'][0]['legs'];
                $distance = 0;
                foreach($legs as $punto)
                {
                    $distance += $punto['distance']['value'] / 1000;
                }
                $this->updateKmTotal(session('idRuta'), $distance);

                $citiesPolyline = Polyline::encode($coordinates);
                $this->updatePolylines(session('idRuta'), $coords, $citiesPolyline);

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
            $waypoints = $this->searchDirections(session('idRuta'), false);

            if(sizeof($waypoints) > 25)
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
            elseif(sizeof($waypoints) <= 25 )
            {
                $direcciones = [];
                $response = $this->connectOSRM($waypoints); //esto devuelve un array [coordenadas de los puntos ordenadas, polylinea, kmTotal]
                $coordinates = [];
                $poly = Polyline::decode($response[1]);
                $polyline = Polyline::pair($poly);



                foreach($response[0] as $waypoint)
                {
                    $coordinates[] = [
                        'lat' => $waypoint->latitud,
                        'lng' => $waypoint->longitud
                    ];

                }

                //guardar el recorrido
                $citiesPolyline = Polyline::encode($coordinates);
                $this->updatePolylines(session('idRuta'), $response[1], $citiesPolyline);
                $this->updateKmTotal(session('idRuta'), $response[2]);

            }
            return redirect()->route('rutas.index');
        }else return redirect()->route('rutas.index'); //agregar la respuesta que el error sucedede porque no estan definidos el inicio y el final


    }

    private function connectOSRM(array $waypoints)
    {

        $osrm_api_url = 'http://127.0.0.1:5000/trip/v1/driving/';


        // Crear una cadena con las coordenadas de las ubicaciones para la URL
        $coordinates = '';
        foreach ($waypoints as $waypoint) {
            $coordinates .= $waypoint->longitud . ',' . $waypoint->latitud . ';';
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

                $this->updateOrden($waypoints[$index]->idDireccion, $position);
            }
        }
        ksort($orderedCoordinates);

        $polyline = $response_data['trips'][0]['geometry'];

        $kmTotal =  $response_data['trips'][0]['distance'] / 1000;

        return [$orderedCoordinates, $polyline, $kmTotal];



    }

    public function dividirDirecciones()
    {
        if (session::has('dataExcel')) {
            $addresses = session('dataExcel');
            $coordinates = [];

            $empresa = Auth()->user()->empresa;
            $vehiculosUsuario = DB::table('users')
            ->join('vehiculos', 'users.id', '=', 'vehiculos.idUsuario')
            ->select('*')
            ->where('users.empresa', '=', $empresa)
            ->get();

            foreach($addresses as $address)
            {
                $coordinates[] = [
                    'latitude' => $address['lat'],
                    'longitude' => $address['lng']
                ];

            }

            $distanceMatrix = $this->generateDistanceMatrix($coordinates);
            $numVehicles = count($vehiculosUsuario);
            $responseOrtools = $this->connectPython($distanceMatrix, $numVehicles);


            foreach($responseOrtools as &$responseArray) {
                foreach($responseArray as &$elementoIndice) {
                    $indice = $elementoIndice;
                    if (isset($addresses[$indice])) {
                        $elementoIndice = $addresses[$indice];
                    } else {
                        // Manejar el caso donde el índice no existe en $addresses, si es necesario.
                        // Puedes asignar un valor predeterminado o dejarlo como está.
                    }
                }
            }
            //responseOrTools ahora tiene la respuesta de la division de los vehiculos con sus respectivas direcciones, hay que enviarle al usuario para que acepte si quiere ese orden
            foreach($responseOrtools as $indice => $direccionesArray)
            {

                $idUser = $vehiculosUsuario[$indice]->idUsuario; //$responseOrTools tiene la misma cantidad de elementos(vehiculos) que de usuarios existan
                $this->newRuta($idUser, $direccionesArray);
            }

        }

        return back();
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

    private function updateKmTotal(int $id, float $kmTotal)
    {
        $ruta = Ruta::findOrFail($id);

        $ruta->update(['kmTotal' => $kmTotal]);
    }
    private function searchDirections(string $idRuta, bool $filter)
    {

        // Filtrar las direcciones para eliminar "inicio" y "final"
        if($filter)
        {
            $direccionesUsuario = DB::table('rutas')
            ->join('direcciones', 'rutas.idRuta', '=', 'direcciones.idRuta')
            ->where('rutas.idRuta', $idRuta)
            ->select('idDireccion','direccion', 'latitud', 'longitud', 'tipo')
            ->get();

            $direccionesUsuario = $direccionesUsuario->filter(function ($direccion) {
                return $direccion->tipo !== 'inicio' && $direccion->tipo !== 'final';
            });
        }else
        {
            $direccionesUsuario = DB::select("SELECT idDireccion, direccion, latitud, longitud, tipo FROM rutas
            JOIN direcciones on rutas.idRuta = direcciones.idRuta
            WHERE rutas.idRuta = $idRuta
            ORDER BY CASE
                WHEN tipo = 'inicio' THEN 1
                WHEN tipo = 'normal' THEN 2
                WHEN tipo = 'final' THEN 3
                ELSE 4
            END;");
        }

        return $direccionesUsuario;

    }

    public function generateDistanceMatrix(array $coords)
    {
        $osrm_api_url = 'http://127.0.0.1:5000/table/v1/driving/';


        // Crear una cadena con las coordenadas de las ubicaciones para la URL
        $coordinates = '';
        foreach ($coords as $waypoint) {
            $coordinates .= $waypoint['longitude'] . ',' . $waypoint['latitude'] . ';';
        }
        $coordinates = rtrim($coordinates, ';'); // Eliminar el punto y coma final



        // Agregar las coordenadas a la URL
        $osrm_api_url .= $coordinates;

        // Agregar parámetros adicionales a la URL
        $osrm_api_url .= '?annotations=distance'; //?roundtrip=false&source=first&destination=last&steps=false&geometries=geojson&overview=false&annotations=false

        // Configurar la solicitud curl
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $osrm_api_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Realizar la solicitud a la API de OSRM
        $response = curl_exec($curl);
        curl_close($curl);
        // Decodificar la respuesta JSON
        $response_data = json_decode($response, true);

        $distanceMatrix = $response_data['distances'];

        return $distanceMatrix;

    }

    private function connectPython($matrix, $numVehicles)
    {
        $response = Http::post('127.0.0.1:8002', [
            'matrix' => $matrix,
            'numVehicles' => $numVehicles,
        ]);

        // Puedes acceder al contenido de la respuesta de la siguiente manera:
        $responseData = $response->json(); // Si se espera una respuesta JSON

        return $responseData;
    }

    private function newRuta(int $id, array $direcciones)
    {
        // generar nueva ruta
        $ruta = new Ruta();
        $ruta->estado = 'P';
        $ruta->kmTotal = null;
        $ruta->save();

        $idRuta = $ruta->getKey();
        //enlazar la ruta y el usuario en la tabla usuarios_ruta
        $userRuta = new User_ruta();
        $userRuta->idRuta = $idRuta;
        $userRuta->idUsuario = $id;
        $userRuta->idVehiculo = null;
        $userRuta->save();


        $lenght = count($direcciones);
        for ($i=0; $i < $lenght - 1; $i++) {
            $direccion = $direcciones[$i]['address'];
            $latitude = $direcciones[$i]['lat'];
            $longitude = $direcciones[$i]['lng'];
            if($i == 0)
            {
                $this->storeDirecciones($idRuta, $direccion, $latitude, $longitude, 'inicio');
                $this->storeDirecciones($idRuta, $direccion, $latitude, $longitude, 'final');
                
            }
            else
            {
                $this->storeDirecciones($idRuta, $direccion, $latitude, $longitude, 'normal');
            }
        }
    }

    private function storeDirecciones(int $idRuta, string $address, $latitud, $longitud, $tipo)
    {
        $direccion = new Direcciones();
        $direccion->idRuta = $idRuta;
        $direccion->direccion = $address;//nombre en ingles para evitar errores con la instancia del modelo
        $direccion->latitud = $latitud;
        $direccion->longitud = $longitud;
        $direccion->tipo = $tipo;
        $direccion->orden = null;
        $direccion->save();
    }

}


