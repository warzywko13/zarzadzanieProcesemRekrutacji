<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\User;

use App\Http\Controllers\Candidate\SkillController;
use App\Http\Controllers\Candidate\ExpirienceController;
use App\Http\Controllers\Candidate\EducationController;
use App\Http\Controllers\Candidate\InterestsController;
use App\Http\Controllers\Candidate\UserController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CandidateController extends Controller
{
    private object $ExpirienceController;
    private object $EducationController;
    private object $InterestsController;
    private object $SkillController;
    private object $UserController;

    function __construct()
    {
        $this->ExpirienceController = new ExpirienceController();
        $this->EducationController = new EducationController();
        $this->InterestsController = new InterestsController();
        $this->SkillController = new SkillController();
        $this->UserController = new UserController();
    }

    private function get_form_data($user_id, $form): array
    {
        $data = [];

        // Get Personal Data
        $data['user'] = $this->UserController->get_form_data($user_id, $form);

        // Get Expirience Data
        $data['expirience'] = $this->ExpirienceController->get_form_data($user_id, $form);

        // Get Education Data
        $data['education'] = $this->EducationController->get_form_data($user_id, $form);

        // Get Interest Data
        $data['interest'] = $this->InterestsController->get_form_data($user_id, $form);

        // Get Skill Data
        $data['skill'] = $this->SkillController->get_form_data($user_id, $form);

        return $data;
    }

    private function validate_form_data($form_datas)
    {
        $error = 0;

        // Walidacja usera
        $this->UserController->validate_from_data($form_datas['user'], $form_datas['image'], $error);

        // Walidacja Expirience Data
        $this->ExpirienceController->validate_form_data($form_datas['expirience'], 5, $error);

        // Walidacja Education Data
        $this->EducationController->validate_form_data($form_datas['education'], 5, $error);

        // Walidacja Skill Data
        $this->SkillController->validate_form_data($form_datas['skill'], 10, $error);

        // Walidacja Interest Data
        $this->InterestsController->validate_form_data($form_datas['interest'], 10, $error);

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

        } else {
            // If user is not recruiter and have id redirect
            if($id = $request->input('id', 0) !== 0) {
                return redirect(route('addEdit'));
            }
        }


        if($request->input('save')) {
            $form = $request->all();

            // Get Form data
            $form_datas = $this->get_form_data($user_id, $form);
            $form_datas['image'] = $request->file('image');

            // We have all data now Validate it
            $form_datas = $this->validate_form_data($form_datas);

            if(!$form_datas['error']) {
                // Everything ok let's add to db

                // User
                $this->UserController->updateUser($user_id, $form_datas);

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
            $data['disabled'] = $disabled;
            $data['expirience'] = $this->ExpirienceController->renderForm($form_datas['expirience'], $disabled);
            $data['education'] = $this->EducationController->renderForm($form_datas['education'], $disabled);
            $data['interests'] = $this->InterestsController->renderForm($form_datas['interest'], $disabled);
            $data['skill'] = $this->SkillController->renderForm($form_datas['skill'], $disabled);

            $data['all_personal_datas'] = Position::where('deleted', 0)->get();

            return view('candidate_form', $data);
        }

        $data['user'] = $this->UserController->get_personal_data($user_id);
        $data['expirience'] = $this->ExpirienceController->get_expirience($user_id, $disabled);
        $data['education'] = $this->EducationController->get_education($user_id, $disabled);
        $data['interests'] = $this->InterestsController->get_interests($user_id, $disabled);
        $data['skill'] = $this->SkillController->get_skills($user_id, $disabled);

        $data['disabled'] = $disabled;
        $data['all_personal_datas'] = Position::where('deleted', 0)->get();

        return view('candidate_form', $data);
    }
}
