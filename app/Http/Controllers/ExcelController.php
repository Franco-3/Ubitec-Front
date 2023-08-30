<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Http;


class ExcelController extends Controller
{
    public function cargarExcel(Request $request)
    {
        if ($request->hasFile('archivo_excel')) {
            $archivo = $request->file('archivo_excel');
            $spreadsheet = IOFactory::load($archivo->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();

            $direcciones = [];

            foreach ($worksheet->getRowIterator() as $fila) {
                $celdas = $fila->getCellIterator();
                $direccion = [];

                foreach ($celdas as $celda) {
                    $direccion[] = $celda->getValue();
                }

                // Saltear fila con encabezados
                if ($direccion[0] !== "Calle") {
                    $direcciones[] = implode(' ', $direccion);
                }
            }
            $this->geocodeData($direcciones);

            return $direcciones;
        }

        return "No se ha proporcionado ningún archivo Excel.";
    }


    public function geocodeData(array $addresses)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=";

        foreach($addresses as $address)
        {
            $url .= urlencode($address);
        }

        $url .= "&key=AIzaSyDGc0UBAR_Y30fX31EvaU65KATMx0c0ItI";
        $response = Http::get($url);
        $data = $response->json();
        dd($data);
    }


    public function generarExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Agregar encabezados
        $sheet->setCellValue('A1', 'Calle');
        $sheet->setCellValue('B1', 'Numero');
        $sheet->setCellValue('C1', 'Ciudad');
        $sheet->setCellValue('D1', 'Provincia');
        $sheet->setCellValue('E1', 'Pais');

        // Agregar datos de ejemplo
        $direcciones = [
            ['Mitre', '320', 'San Nicolas de los Arroyos', 'Buenos Aires', 'Argentina'],
            ['Belgrano', '500', 'Buenos Aires', 'Buenos Aires', 'Argentina'],
            // Agrega más filas de direcciones aquí...
        ];

        $row = 2;
        foreach ($direcciones as $direccion) {
            list($calle, $numero, $ciudad, $provincia, $pais) = $direccion;
            $sheet->setCellValue('A' . $row, $calle);
            $sheet->setCellValue('B' . $row, $numero);
            $sheet->setCellValue('C' . $row, $ciudad);
            $sheet->setCellValue('D' . $row, $provincia);
            $sheet->setCellValue('E' . $row, $pais);
            $row++;
        }

        // Crear el archivo Excel
        $writer = new Xlsx($spreadsheet);
        $archivoPath = storage_path('app/direcciones.xlsx');
        $writer->save($archivoPath);

        return response()->download($archivoPath, 'direcciones.xlsx');
    }


}
