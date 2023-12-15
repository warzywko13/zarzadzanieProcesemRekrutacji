<?php

namespace App\Http\Controllers\Candidate;

use App\Models\Skill;
use App\Http\Controllers\Controller;

class SkillController extends Controller
{
    public function get_form_data(int $user_id, array $form): array
    {
        $data = [];

        foreach($form['skill_name'] as $index => $value) {
            $data[] = (object) [
                'id' => $form['skill_id'][$index],
                'name' => $form['skill_name'][$index],
                'user_id' => $user_id
            ];
        }

        return $data;
    }

    public function validate_form_data(array $skill, int $limit, int &$error): void
    {
        if(count($skill) > $limit) {
            $skill['error'] = __('Możesz dodać maksymalnie') . ' ' . $limit . ' ' . __('umiejętności');
            $error++;
        }

        foreach($skill as $ski) {
            if(empty($ski->name)) {
                $ski->error['name'] = __('Nazwa umiejętności nie może być pusta');
                $error++;
            }
        }
    }

    public function renderForm($skills = null, string $disabled = ''): array
    {
        $result = null;
        $i = 0;

        if($skills) {
            foreach($skills as $skill) {
                $result .= view('candidate.skill', ['skill' => $skill, 'index' => $i, 'disabled' => $disabled]);
                $i++;
            }
        }

        if(empty($result)) {
            $result .= view('candidate.skill', ['index' => $i, 'disabled' => $disabled]);
        }

        return [
            'result' => $result,
            'count' => $i++,
        ];
    }

    public function get_skills(int $user_id, string $disabled = '')
    {
        $skills = Skill::where('user_id', $user_id)->where('deleted', 0)->cursor();
        return $this->renderForm($skills, $disabled);
    }

    public function addUpdateSkill(int $user_id, array $form_datas): void
    {
        $records = Skill::where('user_id', $user_id)->where('deleted', 0)->get();
        $to_delete = [];

        // Delete Skill
        foreach($records as $record) {
            $found = false;

            foreach($form_datas['skill'] as $int) {
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
            Skill::where('id', $to_delete)->where('deleted', 0)->update([
                'deleted' => '1',
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => $user_id
            ]);
        }

        // Add Update Skill
        foreach($form_datas['skill'] as $skill) {
            if($skill->id) {
                $record = Skill::where('id', $skill->id)->where('deleted', 0);
                if($record) {
                    $skill->updated_by = $user_id;
                    $record->update((array) $skill);
                    continue;
                }
            }

            unset($skill->id);
            $skill->created_by = $user_id;
            Skill::create((array) $skill);
        }
    }
}
