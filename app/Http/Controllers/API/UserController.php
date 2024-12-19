<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Validator;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserEmail;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        // $users = User::all();

        $query = User::select(DB::raw('users.id, users.name, users.email, users.created_at, count(*) as orders_count'))
        ->where('users.active','1')
        ->join('orders', 'users.id', '=', 'orders.user_id')
        ->groupBy('users.id', 'users.name', 'users.email','users.created_at');

        // dd($query);
                //  $query = User::select('id','email','name','created_at')
                //  ->where('active','1');


        if ($s = $request->query('search')) {
            $query->whereRaw("name LIKE '%" . $s . "%'")
            ->orWhereRaw("email LIKE '%" . $s . "%'");
        }

        if ($sort = $request->query('sortBy')) {
            $query->orderBy($sort,'desc');
        }

        $perPage = 5;
        $page = $request->query('page', 1);
        $total = $query->count();

        $data = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();

        $users = new UserResource($data);

        $result =[];
        $result['users'] = $data;
        $result['total'] = $total;
        $result['page'] = $page;
        $result['total_page'] = ceil($total / $perPage);

        return $this->sendResponse($result, 'Users retrieved successfully.');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required','string', 'min:8',],
        ]);


        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = User::create($input);

        $data = array(
            'name' => $user->name,
            'email' => $user->email,
          ); 
          Mail::to($user->email)->send(new UserEmail($data));
          Mail::to('masanam@yahoo.com')->send(new UserEmail($data));

        return $this->sendResponse(new UserResource($user), 'User created successfully.');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id): JsonResponse
    {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->sendError('User not found.');
        }

        return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user->name = $input['name'];
        $user->detail = $input['detail'];
        $user->save();

        return $this->sendResponse(new UserResource($user), 'User updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return $this->sendResponse([], 'User deleted successfully.');
    }
}
