<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Models\Position;
use App\Models\User;

class RecruiterController extends Controller
{

    private $filter;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('recruiter');
        $this->filter = new FilterController();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $form = $request->all();
        $users = $this->get_user_list($form);
        $filter = $this->filter->get_user_filter_data();

        return view('home', ['users' => $users, 'filter' => $filter, 'selected' => $form]);
    }

    public function positons(Request $request)
    {
        $form = $request->all();
        $where = "";

        if(isset($form['position'])) {
            $position = $this->filter->generate_sql_array('p.id', $form['position']);
            $where .= $position;
        }

        if(isset($form['created_at'])) {
            $created_at = " AND DATE(p.created_at) =  '" . $form['created_at'] . "'";
            $where .= $created_at;
        }

        $sql = "SELECT
                    p.id
                    , p.name
                    , IFNULL(p.created_at, '-') as created_at
                    , IFNULL(p.updated_at, '-') as updated_at
                FROM positions p
                WHERE deleted = 0
                $where";

        $results = DB::select($sql);
        $positions = $this->filter->createPagination($results);

        $filter = $this->filter->get_positions_filter_data();

        return view('position_list', ['positions' => $positions, 'filter' => $filter, 'selected' => $form]);
    }

    public function delete_position($id)
    {
        if($id) {
            $position = Position::where('id', $id)
                ->where('deleted', 0)
                ->first();

            if($position) {
                $position->update([
                    'deleted' => 1,
                    'deleted_at' => date('Y-m-d H:i:s'),
                    'deleted_by' => Auth::id()
                ]);

                return redirect()->route('recruterPosition')->with('status', __('Pozycja pomyślnie usunięta'));
            }
        }

        return redirect()->route('recruterPosition')->with('error', __('Nieprawidłowe id'));
    }

    public function addedit_position(Request $request)
    {
        $data = [];

        // On save
        if($request->input('save')) {
            $name =  $request->input('name');
            $id = $request->input('id');

            if($id) {
                $exists = Position::where('deleted', 0)
                    ->where('name', $name)
                    ->where('id', '<>', $id)
                    ->first();
            } else {
                $exists = Position::where('deleted', 0)
                    ->where('name', $name)
                    ->first();
            }

            if($exists) {
                $data['error'] = __('Podana nazwa stanowiska już istnieje');
            } else {
                if($id) {
                    Position::find($id)->update([
                        'name' => $name
                    ]);
                } else {
                    Position::create([
                        'name' => $name
                    ]);
                }

                return redirect()->route('recruterPosition')->with('status', $id ? __('Stanowisko zostało zedytowane') : __('Stanowisko zostało dodane') );
            }
        }

        // If id exists
        if($id = $request->input('id')) {
            $data['position'] = Position::findOrFail($id)->where('deleted', 0)->first();
        }


        return view('addedit_position', $data);
    }

    private function get_user_list($form)
    {
        $where = "";

        // Filter username
        if(isset($form['username'])) {
            $username = $this->filter->generate_sql_array('u.id', $form['username']);
            $where .= $username;
        }

        // Filter age
        if(isset($form['age'])) {
            $where .= " AND TIMESTAMPDIFF(YEAR, u.birthday, CURDATE()) = '" . $form['age'] . "'";
        }

        // Filter sex
        if(isset($form['sex'])) {
            $where .= " AND u.sex = '" . $form['sex'] . "'";
        }

        // Fitler position
        if(isset($form['position'])) {
            $where .= " AND IF(u.position_manual = 1, u.position_name, p.name) like '%" . $form['position'] . "%'";
        }

        // Filter city
        if(isset($form['city'])) {
            $city = $this->filter->generate_sql_array('u.city', $form['city']);
            $where .= $city;
        }

        // Filter phone
        if(isset($form['phone'])) {
            $phone = $this->filter->generate_sql_array('u.phone', $form['phone']);
            $where .= $phone;
        }

        // Filter access
        if(isset($form['availability'])) {
            $availability = $this->filter->generate_sql_array('u.availability', $form['availability']);
            $where .= $availability;
        }

        $sql = "SELECT
                u.id
                , CONCAT(u.firstname, ' ', u.lastname) AS username
                , TIMESTAMPDIFF(YEAR, u.birthday, CURDATE()) AS age
                , u.sex
                , IF(u.position_manual = 1, u.position_name, p.name) AS position
                , u.city
                , u.phone
                , u.availability
            FROM users u
            LEFT JOIN positions p ON u.position_id = p.id AND p.deleted = 0
            WHERE u.deleted = 0
            $where
            ";

        $results = DB::select($sql);

        foreach ($results as $result) {
            if (!empty($result->sex)) {
                $result->sex = $result->sex == 1 ? __('Mężczyzna') : __('Kobieta'); // Fixed the comparison
            }

            switch ($result->availability) {
                case 1:
                    $result->availability = __('Miesiąc');
                    break;

                case 2:
                    $result->availability = __('2 Miesiące');
                    break;

                case 3:
                    $result->availability = __('3 Miesiące');
                    break;

                default:
                    $result->availability = __('Dowolna'); // Fixed the typo in 'availability'
            }
        }

        return $this->filter->createPagination($results);
    }
}
