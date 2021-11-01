<?php

namespace App\Http\Controllers\Api;

use App\Models\mes;
use App\Models\Parcel;
use App\Models\Lectura;
use Illuminate\Http\Request;

class MesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $meses = mes::all();
        return response()->json(['ok' => true, 'data' => $meses], 200);
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
        //
        $mes = new mes();
        $mes->name = $request->name;
        $mes->year = $request->year;
        $mes->enabled = true;
        $mes->save();

        $parcels = Parcel::all();

        foreach ($parcels as $parcel) {
            $lectura = new Lectura();
            $lectura->lecturaAnterior = 10;
            // $payment->cubosExeso = $request->month;
            // $payment->cubos = $request->month;
            // $payment->fecha = false;
            // $payment->total = $request->month;
            $lectura->parcel_id = $parcel->id;
            $lectura->mes_id = $mes->id;
            $lectura->lecturado = false;
            $lectura->save();
        }

        return response()->json(['ok' => true, 'message' => 'Se creo exitosamente'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\mes  $mes
     * @return \Illuminate\Http\Response
     */
    public function show(mes $mes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\mes  $mes
     * @return \Illuminate\Http\Response
     */
    public function edit(mes $mes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\mes  $mes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, mes $mes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\mes  $mes
     * @return \Illuminate\Http\Response
     */
    public function destroy(mes $mes)
    {
        //
    }
}
