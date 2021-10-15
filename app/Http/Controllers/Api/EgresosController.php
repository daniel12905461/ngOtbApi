<?php

namespace App\Http\Controllers\Api;

use App\Models\Egreso;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EgresosController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $egresos = Egreso::with('tipomoneda', 'cuentaegreso')->paginate(25);

        $data = $egresos->transform(function ($egreso) {
            return $this->transform($egreso);
        });

        return $this->successResponse(
            'Egresos were successfully retrieved.',
            $data,
            [
                'links' => [
                    'first' => $egresos->url(1),
                    'last' => $egresos->url($egresos->lastPage()),
                    'prev' => $egresos->previousPageUrl(),
                    'next' => $egresos->nextPageUrl(),
                ],
                'meta' =>
                    [
                        'current_page' => $egresos->currentPage(),
                        'from' => $egresos->firstItem(),
                        'last_page' => $egresos->lastPage(),
                        'path' => $egresos->resolveCurrentPath(),
                        'per_page' => $egresos->perPage(),
                        'to' => $egresos->lastItem(),
                        'total' => $egresos->total(),
                    ],
            ]
        );
    }

    /**
     * Transform the giving egreso to public friendly array
     *
     * @param App\Models\Egreso $egreso
     *
     * @return array
     */
    protected function transform(Egreso $egreso)
    {
        return [
            'id' => $egreso->id,
            'fecha' => $egreso->fecha,
            'mes' => $egreso->mes,
            'concepto' => $egreso->concepto,
            'monto_importe' => $egreso->monto_importe,
            'descripcion' => $egreso->descripcion,
            'tipo_moneda_id' => optional($egreso->tipoMoneda)->created_at,
            'cuenta_egresos_id' => optional($egreso->cuentaEgreso)->created_at,
        ];
    }

    /**
     * Store a new egreso in the storage.
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

            $egreso = Egreso::create($data);

            return $this->successResponse(
                'Egreso was successfully added.',
                $this->transform($egreso)
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
        ];


        $data = $request->validate($rules);


        return $data;
    }

    /**
     * Display the specified egreso.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $egreso = Egreso::with('tipomoneda', 'cuentaegreso')->findOrFail($id);

        return $this->successResponse(
            'Egreso was successfully retrieved.',
            $this->transform($egreso)
        );
    }

    /**
     * Update the specified egreso in the storage.
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

            $egreso = Egreso::findOrFail($id);
            $egreso->update($data);

            return $this->successResponse(
                'Egreso was successfully updated.',
                $this->transform($egreso)
            );
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Remove the specified egreso from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $egreso = Egreso::findOrFail($id);
            $egreso->delete();

            return $this->successResponse(
                'Egreso was successfully deleted.',
                $this->transform($egreso)
            );
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }


}
