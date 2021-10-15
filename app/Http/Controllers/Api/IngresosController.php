<?php

namespace App\Http\Controllers\Api;

use App\Models\Ingreso;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IngresosController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $ingresos = Ingreso::with('tipomoneda', 'cuentaegreso', 'parcel', 'menber')->paginate(25);

        $data = $ingresos->transform(function ($ingreso) {
            return $this->transform($ingreso);
        });

        return $this->successResponse(
            'Ingresos were successfully retrieved.',
            $data,
            [
                'links' => [
                    'first' => $ingresos->url(1),
                    'last' => $ingresos->url($ingresos->lastPage()),
                    'prev' => $ingresos->previousPageUrl(),
                    'next' => $ingresos->nextPageUrl(),
                ],
                'meta' =>
                    [
                        'current_page' => $ingresos->currentPage(),
                        'from' => $ingresos->firstItem(),
                        'last_page' => $ingresos->lastPage(),
                        'path' => $ingresos->resolveCurrentPath(),
                        'per_page' => $ingresos->perPage(),
                        'to' => $ingresos->lastItem(),
                        'total' => $ingresos->total(),
                    ],
            ]
        );
    }

    /**
     * Transform the giving ingreso to public friendly array
     *
     * @param App\Models\Ingreso $ingreso
     *
     * @return array
     */
    protected function transform(Ingreso $ingreso)
    {
        return [
            'id' => $ingreso->id,
            'fecha' => $ingreso->fecha,
            'mes' => $ingreso->mes,
            'concepto' => $ingreso->concepto,
            'monto_importe' => $ingreso->monto_importe,
            'descripcion' => $ingreso->descripcion,
            'tipo_moneda_id' => optional($ingreso->tipoMoneda)->created_at,
            'cuenta_egresos_id' => optional($ingreso->cuentaEgreso)->created_at,
            'parcels_id' => optional($ingreso->parcel)->latitude,
            'menbers_id' => optional($ingreso->menber)->id,
        ];
    }

    /**
     * Store a new ingreso in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = $this->getValidator($request);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->all());
            }

            $data = $this->getData($request);

            $ingreso = Ingreso::create($data);

            return $this->successResponse(
                'Ingreso was successfully added.',
                $this->transform($ingreso)
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
            'fecha' => 'string|min:1|nullable',
            'mes' => 'string|min:1|nullable',
            'concepto' => 'string|min:1|nullable',
            'monto_importe' => 'string|min:1|nullable',
            'descripcion' => 'string|min:1|nullable',
            'tipo_moneda_id' => 'nullable',
            'cuenta_egresos_id' => 'nullable',
            'parcels_id' => 'nullable',
            'menbers_id' => 'nullable',
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
            'fecha' => 'string|min:1|nullable',
            'mes' => 'string|min:1|nullable',
            'concepto' => 'string|min:1|nullable',
            'monto_importe' => 'string|min:1|nullable',
            'descripcion' => 'string|min:1|nullable',
            'tipo_moneda_id' => 'nullable',
            'cuenta_egresos_id' => 'nullable',
            'parcels_id' => 'nullable',
            'menbers_id' => 'nullable',
        ];


        $data = $request->validate($rules);


        return $data;
    }

    /**
     * Display the specified ingreso.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $ingreso = Ingreso::with('tipomoneda', 'cuentaegreso', 'parcel', 'menber')->findOrFail($id);

        return $this->successResponse(
            'Ingreso was successfully retrieved.',
            $this->transform($ingreso)
        );
    }

    /**
     * Update the specified ingreso in the storage.
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

            $ingreso = Ingreso::findOrFail($id);
            $ingreso->update($data);

            return $this->successResponse(
                'Ingreso was successfully updated.',
                $this->transform($ingreso)
            );
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Remove the specified ingreso from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $ingreso = Ingreso::findOrFail($id);
            $ingreso->delete();

            return $this->successResponse(
                'Ingreso was successfully deleted.',
                $this->transform($ingreso)
            );
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }


}
