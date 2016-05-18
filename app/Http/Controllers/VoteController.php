<?php

namespace App\Http\Controllers;

use App\Container\Container;
use App\Model\Vote;
use App\Model\VoteResult;
use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class VoteController extends Controller
{
    public function index()
    {
        $user = Container::getUser();
        $voteResult = VoteResult::where('user_id', $user->id)->first();
        if(is_null($voteResult)) {
            return view('vote.index');
        }
        else {
            return view('vote.result', [
                'result_a' => $voteResult->result_a,
                'result_b' => $voteResult->result_b,
            ]);
        }
    }

    public function store(Request $request)
    {
        //validate


        $user = Container::getUser();
        $voteResult = VoteResult::where('user_id', $user->id)->first();

        $result = $request->get('vote');

        if (is_null($voteResult)) {
            $vote = Vote::findOrNew(1);
            $total = (int)$vote->total + 1;
            $count = (int)$vote->$result + 1;
            $vote->total = $total;
            $vote->$result = $count;
            $vote->save();

            $voteResult = new VoteResult();
            $voteResult->user_id = $user->id;
            $voteResult->result_a = $result . $count;
            $voteResult->result_b = $total;
            $voteResult->save();
        }

        return view('vote.result', [
            'result_a' => $voteResult->result_a,
            'result_b' => $voteResult->result_b,
        ]);
    }
}
