<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Ingreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class IngresosController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $ingresos = Ingreso::with('tipomoneda','cuentaegreso','parcel','member','lectura','mes')->paginate(25);

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
     * Display the specified ingreso.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $ingreso = Ingreso::with('tipomoneda','cuentaegreso','parcel','member','lectura','mes')->findOrFail($id);

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
            'fecha' => 'nullable|date_format:j/n/Y g:i A',
            'mes' => 'nullable|string|min:0|max:255',
            'concepto' => 'nullable|string|min:0|max:255',
            'monto_importe' => 'nullable|numeric|min:-9|max:9',
            'descripcion' => 'nullable|string|min:0|max:255',
            'pagado' => 'nullable|boolean',
            'tipo_moneda_id' => 'nullable',
            'cuenta_egresos_id' => 'nullable',
            'parcel_id' => 'nullable',
            'member_id' => 'nullable',
            'lectura_id' => 'nullable',
            'mes_id' => 'nullable',
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
                'fecha' => 'nullable|date_format:j/n/Y g:i A',
            'mes' => 'nullable|string|min:0|max:255',
            'concepto' => 'nullable|string|min:0|max:255',
            'monto_importe' => 'nullable|numeric|min:-9|max:9',
            'descripcion' => 'nullable|string|min:0|max:255',
            'pagado' => 'nullable|boolean',
            'tipo_moneda_id' => 'nullable',
            'cuenta_egresos_id' => 'nullable',
            'parcel_id' => 'nullable',
            'member_id' => 'nullable',
            'lectura_id' => 'nullable',
            'mes_id' => 'nullable',
        ];


        $data = $request->validate($rules);


        $data['pagado'] = $request->has('pagado');


        return $data;
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
            'pagado' => ($ingreso->pagado) ? 'Yes' : 'No',
            'tipo_moneda_id' => optional($ingreso->tipoMoneda)->nombre,
            'cuenta_egresos_id' => optional($ingreso->cuentaEgreso)->created_at,
            'parcel_id' => optional($ingreso->parcel)->latitude,
            'member_id' => optional($ingreso->member)->name,
            'lectura_id' => optional($ingreso->lectura)->lecturaActual,
            'mes_id' => optional($ingreso->mes)->nombre,
        ];
    }


}
