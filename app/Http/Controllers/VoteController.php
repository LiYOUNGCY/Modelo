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
        $vote = Vote::find(1);

        if(is_null($voteResult)) {
            return view('vote.index');
        }
        else {
            return redirect('vote/result')
        }
    }

    public function store(Request $request)
    {
        //validate

        $user = Container::getUser();
        $voteResult = VoteResult::where('user_id', $user->id)->first();

        $result = $request->get('vote');
        $reason = $request->get('reason');

        if (is_null($voteResult)) {
            $vote = Vote::findOrNew(1);
            $total = (int)$vote->total + 1;
            $count = (int)$vote->$result + 1;
            $vote->total = $total;
            $vote->$result = $count;
            $vote->save();

            $voteResult = new VoteResult();
            $voteResult->user_id = $user->id;
            $voteResult->result_a = $result . ' - ' . $count;
            $voteResult->result_b = $total;
            $voteResult->reason = $reason;
            $voteResult->save();
        }

        return redirect('vote/result');
    }

    public function result()
    {
        $user = Container::getUser();
        $voteResult = VoteResult::where('user_id', $user->id)->first();
        $vote = Vote::find(1);

        return view('vote.result', [
            'result_a' => $voteResult->result_a,
            'result_b' => $voteResult->result_b,
            'vote' => $vote,
        ]);
    }
}
