<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Education;

class EducationController extends Controller
{
    public function renderForm($educations = null)
    {
        $result = null;
        $i = 0;

        if($educations) {
            foreach($educations as $edu) {
                $result .= view('candidate.education', ['edu' => $edu, 'index' => $i]);
                $i++;
            }
        }

        if(empty($result)) {
            $result .= view('candidate.education', ['index' => $i]);
        }

        return [
            'result' => $result,
            'count' => $i++,
        ];
    }

    public function get_education(int $user_id)
    {
        $educations = Education::where('user_id', $user_id)->where('deleted', 0)->cursor();
        return $this->renderForm($educations);
    }

    public function addUpdateEducation($user_id, $form_datas)
    {
        // Delete Education
        $records = Education::where('user_id', $user_id)->where('deleted', 0)->get();
        $to_delete = [];

        foreach($records as $record) {
            $found = false;

            foreach($form_datas['education'] as $edu) {
                if($record->id == $edu->id) {
                    $found = true;
                    break;
                }
            }

            if(!$found) {
                $to_delete[] = $record->id;
            }
        }

        if($to_delete) {
            Education::whereIn('id', $to_delete)->update([
                'deleted' => '1',
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => $user_id
            ]);
        }

        // Add Update Education
        foreach($form_datas['education'] as $edu) {
            if($edu->id) {
                $record = Education::where('id', $edu->id);
                if($record) {
                    $edu->updated_by = $user_id;
                    $record->update((array) $edu);
                    continue;
                }
            }

            unset($edu->id);
            $edu->created_by = $user_id;
            Education::create((array) $edu);
        }
    }
}
