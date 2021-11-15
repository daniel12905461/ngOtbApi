<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Api\Controller;

use App\Models\Lectura;
use App\Models\Mes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Models\Parcel;

class MesController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $mesObjects = Mes::paginate(25);

        $data = $mesObjects->transform(function ($mes) {
            return $this->transform($mes);
        });

        return $this->successResponse(
            'Mes were successfully retrieved.',
            $data,
            [
                'links' => [
                    'first' => $mesObjects->url(1),
                    'last' => $mesObjects->url($mesObjects->lastPage()),
                    'prev' => $mesObjects->previousPageUrl(),
                    'next' => $mesObjects->nextPageUrl(),
                ],
                'meta' =>
                    [
                        'current_page' => $mesObjects->currentPage(),
                        'from' => $mesObjects->firstItem(),
                        'last_page' => $mesObjects->lastPage(),
                        'path' => $mesObjects->resolveCurrentPath(),
                        'per_page' => $mesObjects->perPage(),
                        'to' => $mesObjects->lastItem(),
                        'total' => $mesObjects->total(),
                    ],
            ]
        );
    }

    /**
     * Store a new mes in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // try {
            // $validator = $this->getValidator($request);

            // if ($validator->fails()) {
            //     return $this->errorResponse($validator->errors()->all());
            // }

            // $data = $this->getData($request);

            // $mes = Mes::create($data);
            $mes = new Mes();
            $mes->name =  $request->input('name');
            $mes->year =  $request->input('year');
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

            return $this->successResponse(
                'Mes was successfully added.',
                $this->transform($mes)
            );
        // } catch (Exception $exception) {
        //     return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        // }
    }

    /**
     * Display the specified mes.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $mes = Mes::findOrFail($id);

        return $this->successResponse(
            'Mes was successfully retrieved.',
            $this->transform($mes)
        );
    }

    /**
     * Update the specified mes in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        try {
            $validator = $this->getValidator($request);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all());
            }

            $data = $this->getData($request);

            $mes = Mes::findOrFail($id);
            $mes->update($data);

            return $this->successResponse(
                'Mes was successfully updated.',
                $this->transform($mes)
            );
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Remove the specified mes from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $mes = Mes::findOrFail($id);
            $mes->delete();

            return $this->successResponse(
                'Mes was successfully deleted.',
                $this->transform($mes)
            );
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Gets a new validator instance with the defined rules.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Support\Facades\Validator
     */
    protected function getValidator(Request $request)
    {
        $rules = [
            'nombre' => 'string|min:1|nullable',
            'gestion' => 'string|min:1|nullable',
        ];

        return Validator::make($request->all(), $rules);
    }


    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'nombre' => 'string|min:1|nullable',
            'gestion' => 'string|min:1|nullable',
        ];


        $data = $request->validate($rules);


        return $data;
    }

    /**
     * Transform the giving mes to public friendly array
     *
     * @param App\Models\Mes $mes
     *
     * @return array
     */
    protected function transform(Mes $mes)
    {
        return [
            'id' => $mes->id,
            'nombre' => $mes->nombre,
            'gestion' => $mes->gestion,
        ];
    }

    public function mesesIngresosParcel($parcel_id){
        $meses = Mes::with(['ingresos' => function ($q) use ($parcel_id) {
            $q->where('pagado', 0)->where('parcel_id', $parcel_id);
        }])->get();
        return response()->json(['ok' => true, 'data' => $meses], 200);
    }

    public function getAllWithLectura(){

        $meses = Mes::with('lecturas')->get();

        return response()->json(['ok' => true, 'data' => $meses], 200);
    }

}
