<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodosController extends Controller {
    public function store() {
        $data = request()->validate([
            'content' => 'required',
            'isCompleted' => 'required',
            'apiToken' => 'required',
        ]);

        User::firstWhere('apiToken', request()->apiToken)->todos()->create($data);

        return response('STORED', 200);
    }

    public function delete() {
        Todo::firstWhere('id', request()->id)->delete();
        return response("DELETED", 200);
    }

    public function index() {
        return User::firstWhere('apiToken', request()->apiToken)->todos;
    }
}
