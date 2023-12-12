<?php

namespace App\Http\Controllers\Candidate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Expirience;


class ExpirienceController extends Controller
{
    public function get_form_data(int $user_id, array $form): array
    {
        $data = [];

        foreach($form['exp_start_date'] as $index => $value) {
            $data[] = (object) [
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

        return $data;
    }

    public function validate_form_data(array $expirience, int $limit, int &$error): void
    {
        if(count($expirience) > $limit) {
            $expirience['error'] = __('Możesz dodać maksymalnie') . ' ' . $limit . ' ' .__('doświadczeń zawodowych');
            $error++;
        }

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
    }

    public function renderForm($expiriences = null, string $disabled = '')
    {
        $result = null;
        $i = 0;

        if($expiriences) {
            foreach($expiriences as $exp) {
                $result .= view('candidate.expirience', ['exp' => $exp, 'index' => $i, 'disabled' => $disabled]);
                $i++;
            }
        }

        if(empty($result)) {
            $result .= view('candidate.expirience', ['index' => $i, 'disabled' => $disabled]);
        }

        return [
            'result' => $result,
            'count' => $i++,
        ];
    }

    public function get_expirience(int $user_id, string $disabled = '')
    {
        $expiriences = Expirience::where('user_id', $user_id)->where('deleted', 0)->cursor();
        return $this->renderForm($expiriences, $disabled);
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
