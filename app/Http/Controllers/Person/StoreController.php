<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use App\Http\Requests\Person\StoreRequest;
use App\Models\Person;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {


        $data = $request->validated();


     $person=  Person::create($data);
        //dd($request);
       return $person;

    }
}
