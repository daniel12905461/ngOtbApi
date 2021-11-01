<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Lectura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class LecturasController extends Controller
{

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $lecturas = Lectura::with('parcel','me')->paginate(25);

        $data = $lecturas->transform(function ($lectura) {
            return $this->transform($lectura);
        });

        return $this->successResponse(
            'Lecturas were successfully retrieved.',
            $data,
            [
                'links' => [
                    'first' => $lecturas->url(1),
                    'last' => $lecturas->url($lecturas->lastPage()),
                    'prev' => $lecturas->previousPageUrl(),
                    'next' => $lecturas->nextPageUrl(),
                ],
                'meta' =>
                [
                    'current_page' => $lecturas->currentPage(),
                    'from' => $lecturas->firstItem(),
                    'last_page' => $lecturas->lastPage(),
                    'path' => $lecturas->resolveCurrentPath(),
                    'per_page' => $lecturas->perPage(),
                    'to' => $lecturas->lastItem(),
                    'total' => $lecturas->total(),
                ],
            ]
        );
    }

    /**
     * Store a new lectura in the storage.
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
            
            $lectura = Lectura::create($data);

            return $this->successResponse(
			    'Lectura was successfully added.',
			    $this->transform($lectura)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Display the specified lectura.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $lectura = Lectura::with('parcel','me')->findOrFail($id);

        return $this->successResponse(
		    'Lectura was successfully retrieved.',
		    $this->transform($lectura)
		);
    }

    /**
     * Update the specified lectura in the storage.
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
            
            $lectura = Lectura::findOrFail($id);
            $lectura->update($data);

            return $this->successResponse(
			    'Lectura was successfully updated.',
			    $this->transform($lectura)
			);
        } catch (Exception $exception) {
            return $this->errorResponse('Unexpected error occurred while trying to process your request.');
        }
    }

    /**
     * Remove the specified lectura from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $lectura = Lectura::findOrFail($id);
            $lectura->delete();

            return $this->successResponse(
			    'Lectura was successfully deleted.',
			    $this->transform($lectura)
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
            'lectura_actual' => 'required|string|min:1|max:255',
            'fecha' => 'required|string|min:1',
            'parcel_id' => 'required',
            'mes_id' => 'required', 
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
                'lectura_actual' => 'required|string|min:1|max:255',
            'fecha' => 'required|string|min:1',
            'parcel_id' => 'required',
            'mes_id' => 'required', 
        ];

        
        $data = $request->validate($rules);




        return $data;
    }

    /**
     * Transform the giving lectura to public friendly array
     *
     * @param App\Models\Lectura $lectura
     *
     * @return array
     */
    protected function transform(Lectura $lectura)
    {
        return [
            'id' => $lectura->id,
            'lectura_actual' => $lectura->lectura_actual,
            'fecha' => $lectura->fecha,
            'parcel_id' => optional($lectura->Parcel)->latitude,
            'mes_id' => optional($lectura->Me)->nombre,
        ];
    }


}
