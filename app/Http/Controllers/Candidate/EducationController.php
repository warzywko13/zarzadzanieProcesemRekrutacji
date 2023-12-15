<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Education;

class EducationController extends Controller
{
    public function get_form_data(int $user_id, array $form): array
    {
        $data = [];

        foreach($form['edu_start_date'] as $index => $value) {
            $data[] = (object)[
                'id'                => $form['edu_id'][$index],
                'user_id'           => $user_id,
                'start_date'        => $form['edu_start_date'][$index],
                'end_date'          => $form['edu_end_date'][$index],
                'name'              => $form['edu_education_name'][$index],
                'major'             => $form['edu_major'][$index],
                'title'             => $form['edu_title'][$index],
                'in_progress'       => $form['edu_in_progress'][$index] ?: 0,
            ];
        }

        return $data;
    }

    public function validate_form_data(array $education, int $limit, int &$error): void
    {
        if(count($education) > $limit) {
            $education['error'] = __('Możesz dodać maksymalnie') . ' ' . $limit . ' ' .__('wykształceń');
            $error++;
        }

        foreach($education as $edu) {
            if(empty($edu->start_date)) {
                $edu->error['start_date'] = __('Data rozpoczęcia nie może być pusta');
                $error++;
            }

            if($edu->in_progress == 0) {
                if(empty($edu->end_date)) {
                    $edu->error['end_date'] = __('Jeżeli nie jest zazaczone') . ' "' . __('Trwa nadal') . '" ' . __('Data zakończenia nie może być pusta');
                    $error++;
                } else {
                    if(strtotime($edu->start_date) >= strtotime($edu->end_date)) {
                        $edu->error['end_date'] = __('Data zakończenia nie może być większa od daty rozpoczęcia');
                        $error++;
                    }
                }
            }

            if(empty($edu->name)) {
                $edu->error['name'] = __('Nazwa uczelni nie może być pusta');
                $error++;
            }

        }
    }

    public function renderForm($educations = null, string $disabled = '')
    {
        $result = null;
        $i = 0;

        if($educations) {
            foreach($educations as $edu) {
                $result .= view('candidate.education', ['edu' => $edu, 'index' => $i, 'disabled' => $disabled]);
                $i++;
            }
        }

        if(empty($result)) {
            $result .= view('candidate.education', ['index' => $i, 'disabled' => $disabled]);
        }

        return [
            'result' => $result,
            'count' => $i++,
        ];
    }

    public function get_education(int $user_id, string $disabled = '')
    {
        $educations = Education::where('user_id', $user_id)->where('deleted', 0)->cursor();
        return $this->renderForm($educations, $disabled);
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
            Education::where('id', $to_delete)->update([
                'deleted' => '1',
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => $user_id
            ]);
        }

        // Add Update Education
        foreach($form_datas['education'] as $edu) {
            if($edu->id) {
                $record = Education::where('id', $edu->id)->where('deleted', 0);
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
