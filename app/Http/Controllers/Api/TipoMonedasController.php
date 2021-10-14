<?php

namespace App\Http\Controllers\Api;

use App\Models\TipoMoneda;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoMonedasController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $tipoMonedas = TipoMoneda::paginate(25);

        $data = $tipoMonedas->transform(function ($tipoMoneda) {
            return $this->transform($tipoMoneda);
        });

        return $this->successResponse(
            'Tipo Monedas were successfully retrieved.',
            $data,
            [
                'links' => [
                    'first' => $tipoMonedas->url(1),
                    'last' => $tipoMonedas->url($tipoMonedas->lastPage()),
                    'prev' => $tipoMonedas->previousPageUrl(),
                    'next' => $tipoMonedas->nextPageUrl(),
                ],
                'meta' =>
                    [
                        'current_page' => $tipoMonedas->currentPage(),
                        'from' => $tipoMonedas->firstItem(),
                        'last_page' => $tipoMonedas->lastPage(),
                        'path' => $tipoMonedas->resolveCurrentPath(),
                        'per_page' => $tipoMonedas->perPage(),
                        'to' => $tipoMonedas->lastItem(),
                        'total' => $tipoMonedas->total(),
                    ],
            ]
        );
    }

    /**
     * Transform the giving tipo moneda to public friendly array
     *
     * @param App\Models\TipoMoneda $tipoMoneda
     *
     * @return array
     */
    protected function transform(TipoMoneda $tipoMoneda)
    {
        return [
            'id' => $tipoMoneda->id,
            'nombre' => $tipoMoneda->nombre,
            'activo' => ($tipoMoneda->activo) ? 'Yes' : 'No',
        ];
    }

    /**
     * Store a new tipo moneda in the storage.
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

            $tipoMoneda = TipoMoneda::create($data);

            return $this->successResponse(
                'Tipo Moneda was successfully added.',
                $this->transform($tipoMoneda)
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
            'activo' => 'string|min:1|nullable|boolean',
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
            'activo' => 'string|min:1|nullable|boolean',
        ];


        $data = $request->validate($rules);


        return $data;
    }

    /**
     * Display the specified tipo moneda.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipoMoneda = TipoMoneda::findOrFail($id);

        return $this->successResponse(
            'Tipo Moneda was successfully retrieved.',
            $this->transform($tipoMoneda)
        );
    }

    /**
     * Update the specified tipo moneda in the storage.
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

            $tipoMoneda = TipoMoneda::findOrFail($id);
            $tipoMoneda->update($data);

            return $this->successResponse(
                'Tipo Moneda was successfully updated.',
                $this->transform($tipoMoneda)
            );
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Remove the specified tipo moneda from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $tipoMoneda = TipoMoneda::findOrFail($id);
            $tipoMoneda->delete();

            return $this->successResponse(
                'Tipo Moneda was successfully deleted.',
                $this->transform($tipoMoneda)
            );
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }


}
