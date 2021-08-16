<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MonthlyPayment;
use App\Models\Payment;
use App\Models\Parcel;
use Illuminate\Http\Request;

class MonthlyPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $monthlyPayment = MonthlyPayment::all();
        return response()->json(['ok' => true, 'data' => $monthlyPayment], 200);
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
        $monthlyPayment = new MonthlyPayment();
        $monthlyPayment->month = $request->month;
        $monthlyPayment->year = $request->year;
        $monthlyPayment->price_id = $request->price_id;
        $monthlyPayment->enabled = true;
        $monthlyPayment->save();

        $parcels = Parcel::all();

        foreach ($parcels as $parcel) {
            $payment = new Payment();
            $payment->previous_reading = 10;
            // $payment->current_reading = $request->month;
            // $payment->cubic_meters = $request->month;
            $payment->pagado = false;
            // $payment->total_price = $request->month;
            $payment->parcel_id = $parcel->id;
            $payment->monthly_payment_id = $monthlyPayment->id;
            $payment->enabled = true;
            $payment->save();
        }

        return response()->json(['ok' => true, 'message' => 'Se creo exitosamente'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MonthlyPayment  $monthlyPayment
     * @return \Illuminate\Http\Response
     */
    public function show(MonthlyPayment $monthlyPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MonthlyPayment  $monthlyPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(MonthlyPayment $monthlyPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MonthlyPayment  $monthlyPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MonthlyPayment $monthlyPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MonthlyPayment  $monthlyPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(MonthlyPayment $monthlyPayment)
    {
        //
    }
}
