<?php

namespace App\Http\Controllers\Api;

use App\Models\CuentaIngreso;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CuentaIngresosController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $cuentaIngresos = CuentaIngreso::paginate(25);

        $data = $cuentaIngresos->transform(function ($cuentaIngreso) {
            return $this->transform($cuentaIngreso);
        });

        return $this->successResponse(
            'Cuenta Ingresos were successfully retrieved.',
            $data,
            [
                'links' => [
                    'first' => $cuentaIngresos->url(1),
                    'last' => $cuentaIngresos->url($cuentaIngresos->lastPage()),
                    'prev' => $cuentaIngresos->previousPageUrl(),
                    'next' => $cuentaIngresos->nextPageUrl(),
                ],
                'meta' =>
                    [
                        'current_page' => $cuentaIngresos->currentPage(),
                        'from' => $cuentaIngresos->firstItem(),
                        'last_page' => $cuentaIngresos->lastPage(),
                        'path' => $cuentaIngresos->resolveCurrentPath(),
                        'per_page' => $cuentaIngresos->perPage(),
                        'to' => $cuentaIngresos->lastItem(),
                        'total' => $cuentaIngresos->total(),
                    ],
            ]
        );
    }

    /**
     * Transform the giving cuenta ingreso to public friendly array
     *
     * @param App\Models\CuentaIngreso $cuentaIngreso
     *
     * @return array
     */
    protected function transform(CuentaIngreso $cuentaIngreso)
    {
        return [
            'id' => $cuentaIngreso->id,
            'nombre' => $cuentaIngreso->nombre,
            'costo' => $cuentaIngreso->costo,
            'activo' => $cuentaIngreso->activo,
        ];
    }

    /**
     * Store a new cuenta ingreso in the storage.
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

            $cuentaIngreso = CuentaIngreso::create($data);

            return $this->successResponse(
                'Cuenta Ingreso was successfully added.',
                $this->transform($cuentaIngreso)
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
     * Display the specified cuenta ingreso.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $cuentaIngreso = CuentaIngreso::findOrFail($id);

        return $this->successResponse(
            'Cuenta Ingreso was successfully retrieved.',
            $this->transform($cuentaIngreso)
        );
    }

    /**
     * Update the specified cuenta ingreso in the storage.
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

            $cuentaIngreso = CuentaIngreso::findOrFail($id);
            $cuentaIngreso->update($data);

            return $this->successResponse(
                'Cuenta Ingreso was successfully updated.',
                $this->transform($cuentaIngreso)
            );
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Remove the specified cuenta ingreso from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $cuentaIngreso = CuentaIngreso::findOrFail($id);
            $cuentaIngreso->delete();

            return $this->successResponse(
                'Cuenta Ingreso was successfully deleted.',
                $this->transform($cuentaIngreso)
            );
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }


}
