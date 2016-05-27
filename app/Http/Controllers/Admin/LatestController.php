<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Latest;
use Illuminate\Http\Request;
use App\Http\Requests;

class LatestController extends AdminController
{
    public function index()
    {
        return view('admin.latest.edit');
    }

    public function store(Request $request)
    {
        $row = $request->get('row');
        $col = $request->get('col');
        $size= $request->get('size');
        $offset = $request->get('offset');
        $type = $request->get('type');
        $content = $request->get('content');
        $name = $request->get('name');
        $text = $request->get('text');

        $latest = new Latest();
        $latest->row = $row;
        $latest->col = $col;
        $latest->size = $size;
        $latest->offset = $offset;
        $latest->type = $type;
        $latest->content = $content;
        $latest->name = $name;
        $latest->text = $text;
        $latest->save();

        return response()->json([
            'success' => 0,
        ]);
    }

    public function destroyAll()
    {
        Latest::destroyAll();
        return response()->json([
            'success' => 0,
        ]);
    }
}
