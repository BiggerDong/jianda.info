<?php

namespace App\Http\Controllers;

use App\Newtopics;
use Illuminate\Http\Request;

class NewTopicsController extends Controller
{
    public function store(Request $request)
    {
        $data = [
            'name' => $request->get('name'),
        ];

        Newtopics::create($data);
        return redirect('/topics');

    }
}
