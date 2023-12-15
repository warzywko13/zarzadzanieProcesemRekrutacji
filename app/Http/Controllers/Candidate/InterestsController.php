<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Interest;

class InterestsController extends Controller
{
    public function get_form_data(int $user_id, array $form): array
    {
        $data = [];

        foreach($form['int_name'] as $index => $value) {
            $data[] = (object) [
                'id' => $form['int_id'][$index],
                'name' => $form['int_name'][$index],
                'user_id' => $user_id
            ];
        }

        return $data;
    }

    public function validate_form_data(array $interest, int $limit, int &$error): void
    {
        if(count($interest) > $limit) {
            $interest['error'] = __('Możesz dodać maksymalnie') . ' ' . $limit . ' ' . __('zainteresowań');
            $error++;
        }

        foreach($interest as $int) {
            if(empty($int->name)) {
                $int->error['name'] = __('Nazwa zaintersowania nie może być pusta');
                $error++;
            }
        }
    }

    public function renderForm($interests = null, string $disabled = '')
    {
        $result = null;
        $i = 0;

        foreach($interests as $int) {
            $result .= view('candidate.interest', ['int' => $int, 'index' => $i, 'disabled' => $disabled]);
            $i++;
        }

        if(empty($result)) {
            $result .= view('candidate.interest', ['index' => $i, 'disabled' => $disabled]);
        }

        return [
            'result' => $result,
            'count' => $i++,
        ];
    }

    public function get_interests(int $user_id, string $disabled = '')
    {
        $interests = Interest::where('user_id', $user_id)->where('deleted', 0)->cursor();
        return $this->renderForm($interests, $disabled);
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
            Interest::where('id', $to_delete)->where('deleted', 0)->update([
                'deleted' => '1',
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => $user_id
            ]);
        }

        // Add Update Interest
        foreach($form_datas['interest'] as $int) {
            if($int->id) {
                $record = Interest::where('id', $int->id)->where('deleted', 0);
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
