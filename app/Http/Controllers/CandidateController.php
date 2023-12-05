<?php

namespace App\Http\Controllers;

use App\Models\Expirience;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::id();
        $work_expirience = $this->get_work_expirience($user_id);

        return view('candidate_form', ['work_expirience' => $work_expirience['result'], 'count' => $work_expirience['count']]);
    }

    final public function get_work_expirience(int $user_id)
    {
        $work_expiriences = Expirience::where('user_id', $user_id)->cursor();
        $result = null;

        if(!$work_expiriences->isEmpty()) {
            foreach($work_expiriences as $work_expirience) {
                $i = 0;
                $result .= view('work_expirience', ['exp' => $work_expirience, 'index' => $i]);

                $i++;
            }
        } else {
            $result .= view('candidate.work_expirience', ['index' => 0]);
        }

        return [
            'result' => $result,
            'count' => Expirience::where('user_id', $user_id)->count()
        ];
    }

    final public function add_work_expirience(Request $request){
        return view('candidate.work_expirience', ['index' => 1]);
    }
}
