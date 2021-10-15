<?php

namespace App\Http\Controllers\Api;

use App\Models\CuentaEgreso;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CuentaEgresosController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $cuentaEgresos = CuentaEgreso::paginate(25);

        $data = $cuentaEgresos->transform(function ($cuentaEgreso) {
            return $this->transform($cuentaEgreso);
        });

        return $this->successResponse(
            'Cuenta Egresos were successfully retrieved.',
            $data,
            [
                'links' => [
                    'first' => $cuentaEgresos->url(1),
                    'last' => $cuentaEgresos->url($cuentaEgresos->lastPage()),
                    'prev' => $cuentaEgresos->previousPageUrl(),
                    'next' => $cuentaEgresos->nextPageUrl(),
                ],
                'meta' =>
                    [
                        'current_page' => $cuentaEgresos->currentPage(),
                        'from' => $cuentaEgresos->firstItem(),
                        'last_page' => $cuentaEgresos->lastPage(),
                        'path' => $cuentaEgresos->resolveCurrentPath(),
                        'per_page' => $cuentaEgresos->perPage(),
                        'to' => $cuentaEgresos->lastItem(),
                        'total' => $cuentaEgresos->total(),
                    ],
            ]
        );
    }

    /**
     * Transform the giving cuenta egreso to public friendly array
     *
     * @param App\Models\CuentaEgreso $cuentaEgreso
     *
     * @return array
     */
    protected function transform(CuentaEgreso $cuentaEgreso)
    {
        return [
            'id' => $cuentaEgreso->id,
            'nombre' => $cuentaEgreso->nombre,
            'costo' => $cuentaEgreso->costo,
            'activo' => $cuentaEgreso->activo,
        ];
    }

    /**
     * Store a new cuenta egreso in the storage.
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

            $cuentaEgreso = CuentaEgreso::create($data);

            return $this->successResponse(
                'Cuenta Egreso was successfully added.',
                $this->transform($cuentaEgreso)
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
            'costo' => 'string|min:1|nullable',
            'activo' => 'string|min:1|nullable',
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
            'costo' => 'string|min:1|nullable',
            'activo' => 'string|min:1|nullable',
        ];


        $data = $request->validate($rules);


        return $data;
    }

    /**
     * Display the specified cuenta egreso.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $cuentaEgreso = CuentaEgreso::findOrFail($id);

        return $this->successResponse(
            'Cuenta Egreso was successfully retrieved.',
            $this->transform($cuentaEgreso)
        );
    }

    /**
     * Update the specified cuenta egreso in the storage.
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

            $cuentaEgreso = CuentaEgreso::findOrFail($id);
            $cuentaEgreso->update($data);

            return $this->successResponse(
                'Cuenta Egreso was successfully updated.',
                $this->transform($cuentaEgreso)
            );
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Remove the specified cuenta egreso from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $cuentaEgreso = CuentaEgreso::findOrFail($id);
            $cuentaEgreso->delete();

            return $this->successResponse(
                'Cuenta Egreso was successfully deleted.',
                $this->transform($cuentaEgreso)
            );
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }


}
