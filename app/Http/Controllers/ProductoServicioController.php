<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\ProductoServicio;
use App\Models\Proveedor;

class ProductoServicioController extends Controller
{
    public function show($id = null) {
        try {
            if ($id)
                return response()->json(ProductoServicio::find($id), 200);
            else
                return response()->json(ProductoServicio::all(), 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al obtener productos y servicios',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function create(Request $request) {
        try {
            $productoServicio = new ProductoServicio();
            $proveedor = Proveedor::find($request->nit_proveedor);
            if (!$proveedor)
                return response()->json([
                    'message' => 'No existe el proveedor con el nit ' . $request->nit_proveedor
                ], 404);
            $productoServicio->nit_proveedor = $request->nit_proveedor;
            $productoServicio->codigo = $request->codigo;
            $productoServicio->nombre = $request->nombre;
            $productoServicio->precio = $request->precio;
            $productoServicio->cantidad_minima = $request->cantidad_minima;
            $productoServicio->save();
            return response()->json([
                'message' => 'Producto o servicio creado correctamente',
                'productoServicio' => $productoServicio
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error al crear producto o servicio',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
