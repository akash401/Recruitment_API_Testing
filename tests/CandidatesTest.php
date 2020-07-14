<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\User;
use App\Candidates;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
class CandidatesTest extends TestCase
{
       use DatabaseTransactions;
	   
	   protected $user;


//Create a user and authenticate him
protected function authenticate(){
    $user = User::create([
        'name' => 'test',
        'email' => 'test@gmail.com',
        'password' => Hash::make('secret1234'),
    ]);
    $this->user = $user;
    $token = JWTAuth::fromUser($user);
    return $token;
}

protected function headerdata(){
	
	 $token = $this->authenticate();
		$headerdata = [
					'Content-Type'   => 'application/json',
					'Accept'         => 'application/json',
					'HTTP_Authorization'  => 'Bearer '.$token
					];
  
    return $headerdata;
}
	   
    public function testCandidatesCreation()
    {
		
       $headerdata = $this->headerdata();
		
		$response = $this->json('POST', '/v1/candidates', [
            'first_name' => 'test_firstname',
            'last_name' => 'test_lastname',
            'email' => 'cakashv@addonit.in',
            'contact_number' => '8899889988',
            'gender' => 1,
            'specialization' => 'unittest specialization',
            'work_ex_year' => 3,
            'candidate_dob' => '2020-04-05',
            'address' => 'unittest address',
            'resume' => 'unittest testproduct',
        ], $headerdata);
        $this->seeStatusCode(201);
        $response->seeJson(['first_name' => 'test_firstname']);
    }

    public function testCandidatesDeletion()
    {
		$headerdata = $this->headerdata();
		 $candidates = Candidates::create([
            'first_name' => 'test_firstname',
            'last_name' => 'test_lastname',
            'email' => 'cakashv@addonit.in',
            'contact_number' => '8899889988',
            'gender' => 1,
            'specialization' => 'unittest specialization',
            'work_ex_year' => 3,
            'candidate_dob' => '2020-04-05',
            'address' => 'unittest address',
            'resume' => 'unittest testproduct',
        ]);
		$this->json('DELETE',"/v1/candidates/$candidates->id", [],  $headerdata);	
        $this->seeStatusCode(200);
        $this->seeJson(['Deleted Successfully']);
    }
    

    public function testCandidatesUpdate()
    {   
        $headerdata = $this->headerdata();
		$candidates = Candidates::create([
            'first_name' => 'test_firstname',
            'last_name' => 'test_lastname',
            'email' => 'cakashv@addonit.in',
            'contact_number' => '8899889988',
            'gender' => 1,
            'specialization' => 'unittest specialization',
            'work_ex_year' => 3,
            'candidate_dob' => '2020-04-05',
            'address' => 'unittest address',
            'resume' => 'unittest testproduct',
        ]);
		
        $parameters = [
            'first_name' => 'test_firstname_new',
            'last_name' => 'test_lastname_update',
            'email' => 'vvakash@addonit.in',
            'contact_number' => '8899889988',
            'gender' => 1,
            'specialization' => 'unittest specialization',
            'work_ex_year' => 3,
            'candidate_dob' => '2020-04-05',
            'address' => 'unittest address',
            'resume' => 'unittest testproduct',
        ];
        $this->json('PUT',"v1/candidates/$candidates->id", $parameters,$headerdata);
        $this->seeStatusCode(200);
        $this->seeJson($parameters);

    }

    public function testCandidatesListing()
    {   
		 $headerdata = $this->headerdata();
         $this->json('GET',"v1/candidates?limit=10",[],$headerdata);
        $this->seeStatusCode(200);
    }

    public function testCandidatesListingperticular()
    {  
		 $headerdata = $this->headerdata();
		 
		 $candidates = Candidates::create([
            'first_name' => 'test_firstname',
            'last_name' => 'test_lastname',
            'email' => 'cakashv@addonit.in',
            'contact_number' => '8899889988',
            'gender' => 1,
            'specialization' => 'unittest specialization',
            'work_ex_year' => 3,
            'candidate_dob' => '2020-04-05',
            'address' => 'unittest address',
            'resume' => 'unittest testproduct',
        ]);
         $this->json('GET',"v1/candidates/$candidates->id",[], $headerdata);
        $this->seeStatusCode(200);
    }

    public function testCandidatesListingpsearch()
    {   
		 $headerdata = $this->headerdata();
         $this->json('GET',"v1/candidates/search",[],$headerdata);
        $this->seeStatusCode(200);
    }

public function testRegister(){
    //User's data
    $data = [
        'email' => 'testb@gmail.com',
        'name' => 'Test',
        'password' => 'secret@1234',
        'password_confirmation' => 'secret@1234',
    ];
    //Send post request
    $response = $this->json('POST',"/save",$data);
    //Assert it was successful
    $response->seeStatusCode(201);
    User::where('email','testb@gmail.com')->delete();
}

public function testLogin()
{
    //Create user
    User::create([
        'name' => 'test',
        'email'=>'testb@gmail.com',
        'password' => Hash::make('secret@1234'),
    ]);
    //attempt login
    $response = $this->json('POST','/login',[
        'email' => 'testb@gmail.com',
        'password' => 'secret@1234',
    ]);
    //Assert it was successful and a token was received
    $response->seeStatusCode(200);
   User::where('email','test@gmail.com')->delete();
}
}
