<?php

namespace App\Http\Controllers\ApiDocs;

use App\Http\Controllers\Controller;

class IngresosController extends Controller
{

    /**
     * Display the documentation's view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('api-docs.ingresos.index');
    }

}
