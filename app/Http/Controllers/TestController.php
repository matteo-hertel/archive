<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helpers;

use App\Http\Requests;

class TestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("test.index");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * validation rules, number must be:
         * an integer
         * >= 1
         * <= 100
         */
        $this->validate($request, [
        'number' => 'required|integer|min:1|max:100',
        ]);

        $number = $request->get("number");

        $rangeArray = Helpers::createArrayRange($number);
        $missingNumber = Helpers::findMissingNumber($rangeArray);

        return view("test.create", compact("missingNumber", "rangeArray" ,$missingNumber, $rangeArray));
    }


}
