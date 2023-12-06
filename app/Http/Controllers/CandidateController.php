<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Expirience;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{

    public function index(Request $request)
    {
        $user_id = Auth::id();
        $data = [];


        if($request->input('save')) {
            $form = $request->all();

            // Get Form data
            $form_datas = $this->get_form_data($user_id, $form);


            // @TODO We have all data now Validate it


            // Everything ok let's add to db
            //User
            $this->addUpdateUser($user_id, $form_datas);

            // Expirience
            $this->addUpdateExpirience($user_id, $form_datas);

            // Education
            $this->addUpdateEducation($user_id, $form_datas);

        }

        $data['personal_data'] = $this->get_personal_data($user_id);
        $data['work_expirience'] = $this->get_work_expirience($user_id);
        $data['education'] = $this->get_education($user_id);

        return view('candidate_form', $data);
    }

    private function get_work_expirience(int $user_id)
    {
        $work_expiriences = Expirience::where('user_id', $user_id)->where('deleted', 0)->cursor();
        $result = null;

        if(!$work_expiriences->isEmpty()) {
            $i = 0;
            foreach($work_expiriences as $work_expirience) {
                $result .= view('candidate.work_expirience', ['exp' => $work_expirience, 'index' => $i]);
                $i++;
            }
        } else {
            $result .= view('candidate.work_expirience', ['index' => 0]);
        }

        return [
            'result' => $result,
            'count' => Expirience::where('user_id', $user_id)->where('deleted', 0)->count()
        ];
    }

    private function get_personal_data(int $user_id)
    {
        return User::find($user_id);
    }

    private function get_education(int $user_id)
    {
        $educations = Education::where('user_id', $user_id)->where('deleted', 0)->cursor();
        $result = null;

        if(!$educations->isEmpty()) {
            $i = 0;
            foreach($educations as $education) {
                $result .= view('candidate.education', ['edu' => $education ,'index' => $i]);
                $i++;
            }
        } else {
            $result .= view('candidate.education', ['index' => 0]);
        }

        return [
            'result' => $result,
            'count' => Education::where('user_id', $user_id)->where('deleted', 0)->count()
        ];
    }

    private function get_form_data($user_id, $form): array
    {
        $data = [];

        // Get Personal Data
        $data['user'] = [
            'firstname'     => $form['firstname'],
            'lastname'      => $form['lastname'],
            'sex'           => $form['sex'],
            'email'         => $form['email'],
            'phone'         => $form['phone'],
            'street'        => $form['street'],
            'street_number' => $form['street_number'],
            'flat_number'   => $form['flat_number']
        ];

        // Get Photo Data


        // Get Expirience Data
        foreach($form['exp_start_date'] as $index => $value) {
            $data['expirience'][] = [
                'id'                => $form['exp_id'][$index],
                'user_id'           => $user_id,
                'start_date'        => $form['exp_start_date'][$index],
                'end_date'          => $form['exp_end_date'][$index] == '1970-01-01' ? null : $form['exp_end_date'][$index],
                'name'              => $form['exp_company_name'][$index],
                'position'          => $form['exp_position'][$index],
                'in_progress'       => $form['exp_in_progress'][$index],
                'responsibilities'  => $form['exp_responsibilities'][$index],
            ];
        }

        // Get Education Data
        foreach($form['edu_start_date'] as $index => $value) {
            $data['education'][] = [
                'id'                => $form['edu_id'][$index],
                'user_id'           => $user_id,
                'start_date'        => $form['edu_start_date'][$index],
                'end_date'          => $form['edu_end_date'][$index],
                'name'              => $form['edu_education_name'][$index],
                'title'             => $form['edu_title'][$index],
                'in_progress'       => $form['exp_in_progress'][$index],
            ];
        }

        // Get Interest Data

        // Get Skill Data

        return $data;
    }

    private function addUpdateUser($user_id, $form_datas)
    {
        $user = User::find($user_id)->where('deleted', 0);
        $user->update($form_datas['user']);
    }


    private function addUpdateExpirience($user_id, $form_datas)
    {
        // Delete Expirience
        $records = Expirience::where('user_id', $user_id)->where('deleted', 0)->get();
        $to_delete = [];

        foreach($records as $record) {
            $found = false;

            foreach($form_datas['expirience'] as $exp) {
                if($record->id == $exp['id']) {
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
            if($exp['id']) {
                $record = Expirience::where('id', $exp['id']);
                if($record) {
                    $exp['updated_by'] = $user_id;
                    $record->update($exp);
                    continue;
                }
            }

            unset($exp['id']);
            $exp['created_by'] = $user_id;
            Expirience::create($exp);
        }
    }

    private function addUpdateEducation($user_id, $form_datas)
    {
        // Delete Education
        $records = Education::where('user_id', $user_id)->where('deleted', 0)->get();
        $to_delete = [];

        foreach($records as $record) {
            $found = false;

            foreach($form_datas['education'] as $edu) {
                if($record->id == $edu['id']) {
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
            if($edu['id']) {
                $record = Education::where('id', $edu['id']);
                if($record) {
                    $exp['updated_by'] = $user_id;
                    $record->update($exp);
                    continue;
                }
            }

            unset($edu['id']);
            $edu['created_by'] = $user_id;
            Education::create($edu);
        }
    }
}
