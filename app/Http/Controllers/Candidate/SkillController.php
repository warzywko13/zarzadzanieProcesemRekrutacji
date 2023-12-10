<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Models\Skill;
use App\Http\Controllers\Controller;

class SkillController extends Controller
{
    public function renderForm($skills = null)
    {
        $result = null;
        $i = 0;

        if($skills) {
            foreach($skills as $skill) {
                $result .= view('candidate.skill', ['skill' => $skill, 'index' => $i]);
                $i++;
            }
        }

        if(empty($result)) {
            $result .= view('candidate.skill', ['index' => $i]);
        }

        return [
            'result' => $result,
            'count' => $i++,
        ];
    }

    public function get_skills(int $user_id)
    {
        $skills = Skill::where('user_id', $user_id)->where('deleted', 0)->cursor();
        return $this->renderForm($skills);
    }

    public function addUpdateSkill($user_id, $form_datas)
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
            Skill::whereIn('id', $to_delete)->update([
                'deleted' => '1',
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => $user_id
            ]);
        }

        // Add Update Skill
        foreach($form_datas['skill'] as $skill) {
            if($skill->id) {
                $record = Skill::where('id', $skill->id);
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
