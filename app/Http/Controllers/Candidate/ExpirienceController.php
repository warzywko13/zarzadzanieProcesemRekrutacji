<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Expirience;


class ExpirienceController extends Controller
{
    public function renderForm($expiriences = null)
    {
        $result = null;
        $i = 0;

        if($expiriences) {
            foreach($expiriences as $exp) {
                $result .= view('candidate.expirience', ['exp' => $exp, 'index' => $i]);
                $i++;
            }
        }

        if(empty($result)) {
            $result .= view('candidate.expirience', ['index' => $i]);
        }

        return [
            'result' => $result,
            'count' => $i++,
        ];
    }

    public function get_expirience(int $user_id)
    {
        $expiriences = Expirience::where('user_id', $user_id)->where('deleted', 0)->cursor();
        return $this->renderForm($expiriences);
    }

    public function addUpdateExpirience($user_id, $form_datas)
    {
        // Delete Expirience
        $records = Expirience::where('user_id', $user_id)->where('deleted', 0)->get();
        $to_delete = [];

        foreach($records as $record) {
            $found = false;

            foreach($form_datas['expirience'] as $exp) {
                if($record->id == $exp->id) {
                    $found = true;
                    break;
                }
            }

            if(!$found) {
                $to_delete[] = $record->id;
            }
        }

        if($to_delete) {
            Expirience::whereIn('id', $to_delete)->update([
                'deleted' => '1',
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => $user_id
            ]);
        }

        // Add Update Expirience
        foreach($form_datas['expirience'] as $exp) {
            if($exp->id) {
                $record = Expirience::where('id', $exp->id);
                if($record) {
                    $exp->updated_by = $user_id;
                    $record->update((array) $exp);
                    continue;
                }
            }

            unset($exp->id);
            $exp->created_by = $user_id;
            Expirience::create((array) $exp);
        }
    }
}
