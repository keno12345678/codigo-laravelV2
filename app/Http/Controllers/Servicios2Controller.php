<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Servicio;
use App\Http\Requests\CreateServicioRequest;

class Servicios2Controller extends Controller
{
    public function __construct()
    {
        // Aplicar middleware 'auth' solo a los métodos 'edit' y 'destroy'
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $servicios = Servicio::oldest('id')->paginate(3);
        return view('servicios', compact('servicios'));
    }

    public function create()
    {
        return view('create', [
            'servicio' => new Servicio
        ]);
    }

    public function store(CreateServicioRequest $request)
    {
        $servicio = new Servicio($request->validated());
        $servicio->image = $request->file('image')->store('images');
        $servicio->save();

        return redirect()->route('servicios')->with('estado', 'El servicio fue creado correctamente');
    }

    public function show(Servicio $servicio)
    {
        return view('show', [
            'servicio' => $servicio
        ]);
    }

    public function edit(Servicio $servicio)
    {
        return view('editar', [
            'servicio' => $servicio
        ]);
    }

    public function update(Servicio $servicio, CreateServicioRequest $request)
    {
        if($request->hasFile('image')){
            Storage::delete($servicio->image);
            $servicio->fill($request->validated());
            $servicio->image = $request->file('image')->store('images');
            $servicio->save();
            }else{
                $servicio->update(array_filter($request->validated()));
        }

        return redirect()->route('servicios.show', $servicio)->with('estado', 'El servicio fue actualizado correctamente');
    }

    public function destroy(Servicio $servicio)
    {
        Storage::delete($servicio->image);
        $servicio->delete();

        return redirect()->route('servicios')->with('estado', 'El servicio fue eliminado correctamente');
    }
}

