<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Direcciones;
use App\Models\Paquete;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\isNull;

class DireccionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //MOSTRAR DIRECCIONES
        $direcciones = Direcciones::where('estado','1')->get();
        $direcciones2 = Direcciones::where('estado','0')->get();
        return view('backend.direcciones.index', compact('direcciones', 'direcciones2'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //CREAR DIRECCION
        return view('backend.direcciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate(
            [
                'direccion' => 'required',
                'latitud' => 'required',
                'longitud' => 'required',
                'tipo' => 'required',
            ]
        );
        $direccion = new Direcciones();
        $direccion->idRuta = session('idRuta');
        $direccion->direccion = $request->input('direccion');
        $direccion->latitud = $request->input('latitud');
        $direccion->longitud = $request->input('longitud');
        $direccion->tipo = $request->input('tipo');
        $direccion->orden = null;
        $direccion->descripcion = '';
        $direccion->imagen = null;
        $direccion->update($validatedData);
        $direccion->save();



        if($request->input('tipo') === 'inicio' && is_null(session('final')))
        {
            $request->merge(['tipo' => 'final']);
            $this->store($request);
        }
        // $request->session()->flash('status', 'Se guardó correctamente la categoria ' . $categoria->name);
        //return $direccion;
        
        return true;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //EDITAR DIRECCIONES
        $direccion = Direcciones::findOrFail($id);
        return view('backend.direcciones.edit', compact('direccion'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //ACTUALIZAR DIRECCIONES
        $direccion = Direcciones::findOrFail($id);

        $request->validate([
            'direccion' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
        ]);

        $direccion->update([
            'direccion' => $request->input('direccion'),
            'latitud' => $request->input('latitud'),
            'longitud' => $request->input('longitud'),
            'tipo' => $request->input('tipo'),
            'orden' => $request->input('orden')
        ]);

        return redirect()->route('direcciones.index')->with('success', 'Dirección actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Direcciones $direccion)
    {
        // Aquí puedes realizar cualquier lógica que necesites antes de eliminar la dirección
        $direccion->delete();

        return back()->with('success', 'Dirección eliminada correctamente.');
    }


    public function storePackages(Request $request)
    {
        $direccion = $this->store($request);
        $paquete = new Paquete();
        $paquete->idVehiculo = $request->input('idVehiculo');
        $paquete->idDireccion = $request->input('idDireccion');
        $paquete->descripcion = $request->input('descripcion');
        $paquete->pesoUnitario = $request->input('peso_unitario');

        $paquete->save();
    }

    public function actualizarEstado(Request $request, $id)
    {
        $direccion = Direcciones::find($id);
        // Verifica si el valor 'estado' está presente en la solicitud
        if ($request->has('estado')) {
            $direccion->estado = !$direccion->estado;
        }
    
        $direccion->save();
    }

    public function agregarImagenDireccion(Request $request)
    {
        $id = $request->input('id');
        $descripcion = $request->input('descripcion');
        $imagen = $request->file('imagen');
        $rutaImagen = '';

        $this->verificarCarpeta();

        // Verificar que se haya proporcionado una imagen
        if ($imagen) {
            $ruta = $imagen->store('images_direccion', 'public');
            $rutaImagen = storage_path("app/public/".$ruta); // Almacenar la imagen en una carpeta específica
        }

        if ($descripcion == null) {
            $descripcion = '';
        }
        $direccion = Direcciones::find($id);

        $direccion->update([
            'descripcion' => $descripcion,
            'imagen' => $rutaImagen
        ]);


        return redirect()->back();
    }


    public function descargarImagen(Request $request)
    {
        $id = $request->input('id');
        $direccion = Direcciones::find($id);

        if($direccion)
        {
            $archivoPath = $direccion->imagen;
            if($archivoPath != '') return response()->download($archivoPath);
        }else
        {
            $archivoPath = 'No se encontro la imagen';
        }

        return $archivoPath;
    }
    

    private function verificarCarpeta()
    {
        $carpeta = storage_path("app/public/images_direccion");

        // Verifica si la carpeta ya existe
        if (!File::exists($carpeta)) {
            // Si no existe, crea la carpeta
            File::makeDirectory($carpeta, 0755, true, true);
        }
    }


}
