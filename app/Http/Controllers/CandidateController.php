<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Candidate\SkillController;
use App\Models\Position;
use App\Models\User;
use App\Models\Photo;

use App\Http\Controllers\Candidate\ExpirienceController;
use App\Http\Controllers\Candidate\EducationController;
use App\Http\Controllers\Candidate\InterestsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CandidateController extends Controller
{
    private object $ExpirienceController;
    private object $EducationController;
    private object $InterestsController;
    private object $SkillController;

    function __construct()
    {
        $this->ExpirienceController = new ExpirienceController();
        $this->EducationController = new EducationController();
        $this->InterestsController = new InterestsController();
        $this->SkillController = new SkillController();
    }

    private function get_form_data($user_id, $form): array
    {
        $data = [];

        // Get Personal Data
        $data['user'] = (object)[
            'firstname'         => $form['firstname'],
            'lastname'          => $form['lastname'],
            'birthday'          => $form['birthday'],
            'sex'               => $form['sex'],
            'email'             => $form['email'],
            'phone'             => $form['phone'],
            'street'            => $form['street'],
            'street_number'     => $form['street_number'],
            'flat_number'       => $form['flat_number'],
            'position_id'       => $form['position_id'] ?? null,
            'position_name'     => $form['position_name'] ?? null,
            'position_manual'   => $form['position_manual'],
            'availability'      => $form['availability'],
            'location'          => $form['location'],
        ];

        // Get Expirience Data
        foreach($form['exp_start_date'] as $index => $value) {
            $data['expirience'][] = (object) [
                'id'                => $form['exp_id'][$index],
                'user_id'           => $user_id,
                'start_date'        => $form['exp_start_date'][$index],
                'end_date'          => $form['exp_end_date'][$index] == '1970-01-01' ? null : $form['exp_end_date'][$index],
                'name'              => $form['exp_company_name'][$index],
                'position'          => $form['exp_position'][$index],
                'in_progress'       => $form['exp_in_progress'][$index] ?: 0,
                'responsibilities'  => $form['exp_responsibilities'][$index],
            ];
        }

        // Get Education Data
        foreach($form['edu_start_date'] as $index => $value) {
            $data['education'][] = (object)[
                'id'                => $form['edu_id'][$index],
                'user_id'           => $user_id,
                'start_date'        => $form['edu_start_date'][$index],
                'end_date'          => $form['edu_end_date'][$index],
                'name'              => $form['edu_education_name'][$index],
                'title'             => $form['edu_title'][$index],
                'in_progress'       => $form['exp_in_progress'][$index] ?: 0,
            ];
        }

        // Get Interest Data
        foreach($form['int_name'] as $index => $value) {
            $data['interest'][] = (object)[
                'id' => $form['int_id'][$index],
                'name' => $form['int_name'][$index],
                'user_id' => $user_id
            ];
        }

        // Get Skill Data
        foreach($form['skill_name'] as $index => $value) {
            $data['skill'][] = (object)[
                'id' => $form['skill_id'][$index],
                'name' => $form['skill_name'][$index],
                'user_id' => $user_id
            ];
        }


        return $data;
    }

    private function validate_form_data($form_datas)
    {
        $error = 0;

        $user = $form_datas['user'];
        $image = $form_datas['image'];
        $expirience = $form_datas['expirience'];
        $education = $form_datas['education'];
        $interest = $form_datas['interest'];
        $skill = $form_datas['skill'];

        // Walidacja usera

        if($user->position_manual == 0) {
            if(empty($user->position_id)) {
                $user->error['position_id'] = __('Docelowe stanowisko nie może być puste');
            }
        } else {
            if(empty($user->position_name)) {
                $user->error['position_name'] = __('Podaj stanowisko nie może być puste');
            }
        }

        if(empty($user->firstname)) {
            $user->error['firstname'] = __('Imię nie może być puste');
            $error++;
        }

        if(empty($user->lastname)) {
            $user->error['lastname'] = __('Nazwisko nie może być puste');
            $error++;
        }

        if(empty($user->birthday)) {
            $user->error['birthday'] = __('Data urodzenia nie może być pusta');
            $error++;
        }

        if(empty($user->email)) {
            $user->error['email'] = __('Email nie może być pusty');
            $error++;
        }

        if(empty($user->phone)) {
            $user->error['phone'] = __('Numer telefonu nie może być pusty');
            $error++;
        }

        // Walidacja Photo data
        if(!empty($image)) {
            $allowedTypes = ["jpeg", "png"];
            $extenstion = $image->getClientOriginalExtension();

            if(!in_array($extenstion, $allowedTypes)) {
                $user->error['image'] = __('Format zdjęcia jest nieprawidłowy. Obsługiwane formaty to JPEG oraz PNG');
                $error++;
            }
        }

        // Walidacja Expirience Data
        foreach($expirience as $exp) {
            if(empty($exp->start_date)) {
                $exp->error['start_date'] = __('Data rozpoczęcia nie może być pusta');
                $error++;
            }

            if($exp->in_progress == 0) {
                if(empty($exp->end_date)) {
                    $exp->error['end_date'] = __('Jeżeli nie jest zazaczone') . ' "' . __('Trwa nadal') . '" ' . __('Data zakończenia nie może być pusta');
                    $error++;
                } else {
                    if(strtotime($exp->start_date) >= strtotime($exp->end_date)) {
                        $exp->error['end_date'] = __('Data zakończenia nie może być większa od daty rozpoczęcia');
                        $error++;
                    }
                }
            }

            if(empty($exp->name)) {
                $exp->error['name'] = __('Nazwa firmy nie może być pusta');
                $error++;
            }
        }

        // Walidacja Education Data
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

        // Walidacja Skill Data
        foreach($skill as $ski) {
            if(empty($ski->name)) {
                $ski->error['name'] = __('Nazwa umiejętności nie może być pusta');
            }
        }

        // Walidacja Interest Data
        foreach($interest as $int) {
            if(empty($int->name)) {
                $int->error['name'] = __('Nazwa zaintersowania nie może być pusta');
                $error++;
            }
        }

        $form_datas['user'] = $user;
        $form_datas['image'] = $image;
        $form_datas['expirience'] = $expirience;
        $form_datas['education'] = $education;
        $form_datas['interest'] = $interest;
        $form_datas['skill'] = $skill;

        $form_datas['error'] = 0;
        if($error > 0) {
            $form_datas['error'] = 1;
        }

        return $form_datas;
    }

    public function index(Request $request)
    {
        $user_id = Auth::id();
        $disabled = '';

        // If user is recruiter and Id exists show form
        if(Auth::user()->is_recruiter) {

            if($id = $request->input('id', 0) !== 0) {

                try {
                    $user = User::findOrFail($id);
                } catch(ModelNotFoundException $e) {
                    return redirect(route('recruterHome'));
                }

                $user_id = $user->id;
                $disabled = 'disabled';
            } else {
                return redirect(route('recruterHome'));
            }

        }

        if($request->input('save')) {
            $form = $request->all();

            // Get Form data
            $form_datas = $this->get_form_data($user_id, $form);
            $form_datas['image'] = $request->file('image');

            // @TODO We have all data now Validate it
            $form_datas = $this->validate_form_data($form_datas);

            if(!$form_datas['error']) {
                // Everything ok let's add to db

                // Photo
                if($form_datas['image']) {
                    $form_datas['user']->photo_id = $this->updatePhoto($user_id, $form_datas);
                }

                // User
                $this->updateUser($user_id, $form_datas);

                // Expirience
                $this->ExpirienceController->addUpdateExpirience($user_id, $form_datas);

                // Education
                $this->EducationController->addUpdateEducation($user_id, $form_datas);

                // Skills
                $this->SkillController->addUpdateSkill($user_id, $form_datas);

                // Interests
                $this->InterestsController->addUpdateInterest($user_id, $form_datas);

                return redirect()->route('addEdit')->with('status', __('Formularz zapisany pomyślnie'));
            }

            $data['user'] = $form_datas['user'];
            $data['expirience'] = $this->ExpirienceController->renderForm($form_datas['expirience']);
            $data['education'] = $this->EducationController->renderForm($form_datas['education']);
            $data['interests'] = $this->InterestsController->renderForm($form_datas['interest']);
            $data['skill'] = $this->SkillController->renderForm($form_datas['skill']);

            $data['all_personal_datas'] = Position::where('deleted', 0)->get();

            return view('candidate_form', $data);
        }

        $data['user'] = $this->get_personal_data($user_id);
        $data['expirience'] = $this->ExpirienceController->get_expirience($user_id, $disabled);
        $data['education'] = $this->EducationController->get_education($user_id, $disabled);
        $data['interests'] = $this->InterestsController->get_interests($user_id, $disabled);
        $data['skill'] = $this->SkillController->get_skills($user_id, $disabled);

        $data['disabled'] = $disabled;
        $data['all_personal_datas'] = Position::where('deleted', 0)->get();

        return view('candidate_form', $data);
    }
    // Get

    private function get_personal_data(int $user_id)
    {
        $user = User::find($user_id);
        $photo = Photo::find($user->photo_id);

        if($photo) {
            $user->image = $photo->data;
        }

        return $user;
    }

    // Add Update

    private function updatePhoto($user_id, $form_datas)
    {
        // Remove old photo
        $user = User::find($user_id)->where('deleted', 0)->first();
        if($user->photo_id) {
            Photo::find($user->photo_id)->where('deleted', 0)->update([
                'deleted' => '1',
                'deleted_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // Add new photo
        $image = $form_datas['image'];

        $data = file_get_contents($image);
        $imageName = $image->getClientOriginalName();

        $params['name'] = $imageName;
        $params['data'] = base64_encode($data);

        return Photo::insertGetId($params);
    }

    private function updateUser($user_id, $form_datas)
    {
        $user = User::find($user_id)->where('deleted', 0);
        $user->updated_at = date('Y-m-d H:i:s');
        $user->updated_by = $user_id;
        $user->update((array) $form_datas['user']);
    }

}
