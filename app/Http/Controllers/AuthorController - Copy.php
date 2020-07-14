<?php

namespace App\Http\Controllers;
use Validator;
use App\Candidates;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class AuthorController extends Controller
{
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required',
        ]);

        try {

          if (! $token = $this->jwt->attempt($request->only('email', 'password'))) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent' => $e->getMessage()], 500);

        }

        return response()->json(compact('token'),200);
    }

    public function save(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' =>'required',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors(),400);       
        }

        $user=User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
		 $token = JWTAuth::fromUser($user);
       // return response()->json($suc,200); 
	   return response()->json(compact('token'),200);
    }



    public function showAllCandidates(Request $request)
    {   

        $input = $request->all();
        $validator = Validator::make($input, [
            'limit' => 'required',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors(),400);       
        }
        $candidateslist=Candidates::paginate($input['limit']);
       
        return response()->json($candidateslist,200);
    }

    public function search(Request $request)
    {   
        //var_dump($request->input('email'));exit;
        $candidates = Candidates::where('email', 'LIKE', '%' . $request->input('email') . '%')
        ->orWhere('first_name', 'LIKE', '%' . $request->input('first_name') . '%')
        ->orWhere('last_name', 'LIKE', '%' . $request->input('last_name'). '%')
        ->paginate($request->input('limit'));
         return response()->json($candidates,200);
    }



    public function showOneCandidates($id)
    {

        $cand = Candidates::find($id);
        if (is_null($cand)) {
            return  response()->json('Candidates Not Found',404); 
        }
        return response()->json(Candidates::find($id));
    }

    public function create(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'first_name' => 'required',
            'email' => 'required|email|unique:candidates'
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors(),400);       
        }

        $author = Candidates::create($input);
        return response()->json($author, 201);
    }

    public function update($id, Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'first_name' => 'required',
            'email' => 'required|email|unique:candidates'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);       
        }

        $cand = Candidates::find($id);
        if (is_null($cand)) {
            return  response()->json('Candidates Not Found',404); 
        }

        $author = Candidates::findOrFail($id);
        $author->update($request->all());
        return response()->json($author, 200);
    }

    public function delete($id)
    {   
        $cand = Candidates::find($id);
        if (is_null($cand)) {
            return  response()->json('Candidates Not Found',404); 
        }
        Candidates::findOrFail($id)->delete();
        return  response()->json('Deleted Successfully', 200);
    }
}