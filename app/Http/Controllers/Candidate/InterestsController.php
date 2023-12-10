<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Interest;

class InterestsController extends Controller
{
    public function renderForm($interests = null)
    {
        $result = null;
        $i = 0;

        foreach($interests as $int) {
            $result .= view('candidate.interest', ['int' => $int, 'index' => $i]);
            $i++;
        }

        if(empty($result)) {
            $result .= view('candidate.interest', ['index' => $i]);
        }

        return [
            'result' => $result,
            'count' => $i++,
        ];
    }

    public function get_interests(int $user_id)
    {
        $interests = Interest::where('user_id', $user_id)->where('deleted', 0)->cursor();
        return $this->renderForm($interests);
    }

    public function addUpdateInterest($user_id, $form_datas)
    {
        $records = Interest::where('user_id', $user_id)->where('deleted', 0)->get();
        $to_delete = [];

        // Delete Interest
        foreach($records as $record) {
            $found = false;

            foreach($form_datas['interest'] as $int) {
                if($record->id == $int->id) {
                    $found = true;
                    break;
                }
            }

            if(!$found) {
                $to_delete[] = $record->id;
            }
        }

        if($to_delete) {
            Interest::whereIn('id', $to_delete)->update([
                'deleted' => '1',
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => $user_id
            ]);
        }

        // Add Update Interest
        foreach($form_datas['interest'] as $int) {
            if($int->id) {
                $record = Interest::where('id', $int->id);
                if($record) {
                    $int->updated_by = $user_id;
                    $record->update((array) $int);
                    continue;
                }
            }

            unset($int->id);
            $int->created_by = $user_id;
            Interest::create((array) $int);
        }
    }

}
