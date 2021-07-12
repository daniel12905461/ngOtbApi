<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parcel;
use Illuminate\Http\Request;

class ParcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $parcels = Parcel::all();
        return response()->json(['ok' => true, 'data' => $parcels], 200);

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $parcels = new Parcel();
        $parcels->latitude = $request->latitude;
        $parcels->length = $request->length;
        $parcels->enabled = false;
        $parcels->save();
        return response()->json(['ok' => true, 'message' => ' se creo exitosamente'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Parcel $parcel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        try {
            $data = Parcel::FindOrFail($id);
            return response()->json(['ok' => true, 'data' => $data], 201);
        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'message' => 'Parcel not found', 'error' => $e], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Parcel $parcel
     * @return \Illuminate\Http\Response
     */
    public function edit(Parcel $parcel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Parcel $parcel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try {
            $parcels = Parcel::FindOrFail($id);
            $parcels->latitude = $request->latitude;
            $parcels->length = $request->length;
            $parcels->save();
            return response()->json(['ok' => true, 'message' => ' se actualizo exitosamanete'], 200);

        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'message' => 'Prcel not found!', 'error' => $e], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Parcel $parcel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $parcel = Parcel::FindOrFail($id);
        if ($parcel) {
            $parcel->delete();
        } else {
            return response()->json(['ok' => false, 'message' => 'Error does not exist parcel'], 409);
        }
        return response()->json(['ok' => true, 'message' => ' se elimino exitosamente'], 200);
    }

    public function enabled($id)
    {
        try {
            $parcel = Parcel::findOrFail($id);

            if ($parcel->enabled == true) {
                $parcel->enabled = false;
                $parcel->save();
                return response()->json(['ok' => true, 'message' => 'Parcel inactivo'], 201);
            } else {
                $parcel->enabled = true;
                $parcel->save();
                return response()->json(['ok' => true, 'message' => 'Parcel activo'], 201);
            }
        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'message' => 'Parcel not found!', 'error' => $e], 404);
        }
    }
}
