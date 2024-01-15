<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Photo;

class UserController extends Controller
{
    public function get_form_data(int $user_id, array $form): object
    {
        $data = (object) [
            'firstname'         => $form['firstname'],
            'lastname'          => $form['lastname'],
            'birthday'          => $form['birthday'],
            'sex'               => $form['sex'],
            'email'             => $form['email'],
            'phone'             => $form['phone'],
            'street'            => $form['street'],
            'city'              => $form['city'],
            'post_code'         => $form['post_code'],
            'street_number'     => $form['street_number'],
            'flat_number'       => $form['flat_number'],
            'position_id'       => $form['position_id'] ?? null,
            'position_name'     => $form['position_name'] ?? null,
            'position_manual'   => $form['position_manual'],
            'availability'      => $form['availability'],
            'location'          => $form['location'],
            'add_info'          => $form['add_info'],
        ];

        return $data;
    }

    public function validate_from_data(object $user, ?object $image, int &$error): void
    {
        if($user->position_manual == 0) {
            if(empty($user->position_id)) {
                $user->error['position_id'] = __('Docelowe stanowisko nie może być puste');
                $error++;
            }
        } else {
            if(empty($user->position_name)) {
                $user->error['position_name'] = __('Podaj stanowisko nie może być puste');
                $error++;
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
            $allowedTypes = ["jpg", "jpeg", "png"];
            $extenstion = $image->getClientOriginalExtension();

            if(!in_array($extenstion, $allowedTypes)) {
                $user->error['image'] = __('Format zdjęcia jest nieprawidłowy. Obsługiwane formaty to: ') . strtoupper(implode(', ', $allowedTypes));
                $error++;
            }
        }
    }

    public function get_personal_data(int $user_id): object
    {
        $user = User::where('id', $user_id)->where('deleted', 0)->first();
        $photo = Photo::where('id', $user->photo_id)->where('deleted', 0)->first();

        if($photo) {
            $user->image = $photo->data;
        }

        return $user;
    }

    public function updateUser($user_id, $form_datas): void
    {
        if($form_datas['image']) {
            $form_datas['user']->photo_id = $this->updatePhoto($user_id, $form_datas);
        }


        $user = User::where('id', $user_id)->where('deleted', 0);
        $user->updated_at = date('Y-m-d H:i:s');
        $user->updated_by = $user_id;
        $user->update((array) $form_datas['user']);
    }

    private function updatePhoto($user_id, $form_datas)
    {
        // Remove old photo
        $user = User::where('id', $user_id)->where('deleted', 0)->first();
        if($user->photo_id) {
            Photo::where('id', $user->photo_id)->where('deleted', 0)->update([
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


}
