<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Vote;
use App\Model\VoteResult;
use Illuminate\Http\Request;

use App\Http\Requests;

class VoteController extends AdminController
{
    public function index()
    {
        $vote = Vote::find(1);
        $result = VoteResult::all();

        return view('admin.vote.index', [
            'vote' => $vote,
            'result' => $result,
        ]);
    }
}
