<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TSPcontroller extends Controller
{

    public function postDirections(Request $request)
    {
        // Parámetros de la solicitud
        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $waypoints = $request->input('waypoints');
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

        $coords = $data['routes'][0]['overview_polyline']['points'];
        $polyline = $this->decodePolylineToArray($coords); // Suponiendo que `decodePolylineToArray` es una función definida en otro archivo.

        // Procesar la respuesta
        if ($data['status'] == 'OK') {
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

            // Retornar las ciudades y sus coordenadas
            return view('backend.google', compact('responseData'));

        } else {
            $error = 'Error al obtener las direcciones: ' . $data['status'];
            return view('error', compact('error'));
        }
    }



    private function decodePolylineToArray($encoded)
    {
    $length = strlen($encoded);
    $index = 0;
    $points = array();
    $lat = 0;
    $lng = 0;

    while ($index < $length)
    {
        // Temporary variable to hold each ASCII byte.
        $b = 0;

        // The encoded polyline consists of a latitude value followed by a
        // longitude value.  They should always come in pairs.  Read the
        // latitude value first.
        $shift = 0;
        $result = 0;
        do
        {
        // The `ord(substr($encoded, $index++))` statement returns the ASCII
        //  code for the character at $index.  Subtract 63 to get the original
        // value. (63 was added to ensure proper ASCII characters are displayed
        // in the encoded polyline string, which is `human` readable)
        $b = ord(substr($encoded, $index++)) - 63;

        // AND the bits of the byte with 0x1f to get the original 5-bit `chunk.
        // Then left shift the bits by the required amount, which increases
        // by 5 bits each time.
        // OR the value into $results, which sums up the individual 5-bit chunks
        // into the original value.  Since the 5-bit chunks were reversed in
        // order during encoding, reading them in this way ensures proper
        // summation.
        $result |= ($b & 0x1f) << $shift;
        $shift += 5;
        }
        // Continue while the read byte is >= 0x20 since the last `chunk`
        // was not OR'd with 0x20 during the conversion process. (Signals the end)
        while ($b >= 0x20);

        // Check if negative, and convert. (All negative values have the last bit
        // set)
        $dlat = (($result & 1) ? ~($result >> 1) : ($result >> 1));

        // Compute actual latitude since value is offset from previous value.
        $lat += $dlat;

        // The next values will correspond to the longitude for this point.
        $shift = 0;
        $result = 0;
        do
        {
        $b = ord(substr($encoded, $index++)) - 63;
        $result |= ($b & 0x1f) << $shift;
        $shift += 5;
        }
        while ($b >= 0x20);

        $dlng = (($result & 1) ? ~($result >> 1) : ($result >> 1));
        $lng += $dlng;

        // The actual latitude and longitude values were multiplied by
        // 1e5 before encoding so that they could be converted to a 32-bit
        // integer representation. (With a decimal accuracy of 5 places)
        // Convert back to original values.
        $points[] = array($lat * 1e-5, $lng * 1e-5);
    }

    return $points;
    }
}
