<?php

namespace App\Http\Controllers\Api;

use App\Models\Lectura;
use App\Models\Payment;
use Illuminate\Http\Request;

class LecturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $lecturas = Lectura::with('parcel.member')->with('mes')->get();
        return response()->json(['ok' => true, 'data' => $lecturas], 200);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lectura  $lectura
     * @return \Illuminate\Http\Response
     */
    public function show(Lectura $lectura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lectura  $lectura
     * @return \Illuminate\Http\Response
     */
    public function edit(Lectura $lectura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lectura  $lectura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lectura $lectura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lectura  $lectura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lectura $lectura)
    {
        //
    }
}
