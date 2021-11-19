<?php

namespace App\Http\Controllers\Api;


use App\Models\Lectura;
use App\Models\Mes;
use App\Models\Parcel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        try {
            DB::beginTransaction();
            /**
             * pos
             * mes_id   actual
             *parcel_id
             * ----
             * buscar la lectura anterios segun  el mes id
             */

            $mes = new Mes();
            $mes->name = $request->input('name');
            $mes->year = $request->input('year');
//            $mes->index =  $request->input('index'); // 1 =>enero , 2=> febrero
            $mes->index = $request->input('index'); // 1 =>enero , 2=> febrero
            $mes->enabled = true;
            $mes->save();

            $lastMont = null;
            if ($mes->index == '1') {
                $lastMont = Mes::where('year', '=', (int)($mes->year) - 1)
                    ->where('index', '=', 12)->first();
            } else {
                $lastMont = Mes::where('year', '=', (int)($mes->year))
                    ->where('index', '=', ((int)$mes->index) - 1)
                    ->first();
            }

            $parcels = Parcel::where('enabled', '=', 1)->get();

            foreach ($parcels as $parcel) {
                $lastLectura = Lectura::where('mes_id', $lastMont->id)->first();


                $lectura = new Lectura();
                if ($lastLectura) {
                    $lectura->lecturaAnterior = ($lastLectura->lecturaAnterior);
                } else {

                    $lastLectura = Lectura::where('parcel_id', $parcel->id)->latest();

                    if ($lastLectura) {
                        $lectura->lecturaAnterior = $parcel->ultimalectura;
                    } else {
                        $lectura->lecturaAnterior = ($lastLectura->lecturaAnterior);
                    }
                }

                $lectura->lecturaActual = '';
                $lectura->cubos = '';
                $lectura->cubosExeso = 0;
                $lectura->total = 0;
//                $lectura->fecha = '';
                $lectura->lecturado = false;
                $lectura->mes_id = $mes->id;
                $lectura->parcel_id = $parcel->id;
                $lectura->save();
            }
            DB::commit();
            return $this->successResponse(
                'Se creo todo con exito.',
                $this->transform($mes)
            );
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorResponse($exception);
        }
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

    public function mesesIngresosParcel($parcel_id)
    {
        $meses = Mes::with(['ingresos' => function ($q) use ($parcel_id) {
            $q->where('pagado', 0)->where('parcel_id', $parcel_id);
        }])->get();
        return response()->json(['ok' => true, 'data' => $meses], 200);
    }

    public function getAllWithLectura()
    {

        $meses = Mes::with('lecturas')->get();

        return response()->json(['ok' => true, 'data' => $meses], 200);
    }

    public function getg(Request $request)
    {

        $meses = Mes::with('lecturas')->get();

        return response()->json(['ok' => true, 'data' => $meses], 200);
    }

}
