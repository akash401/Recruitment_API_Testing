<?php

use Laravel\Lumen\Testing\DatabaseTransactions;

 use WithoutMiddleware;
class CandidatesTest extends TestCase
{
       use DatabaseTransactions;
   
    public function testCandidatesCreation()
    {

       $this->withoutMiddleware();

        $response = $this->post('/v1/candidates', [
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
        $this->seeStatusCode(201);
        $response->seeJson(['first_name' => 'test_firstname']);
    }

    public function testCandidatesDeletion()
    {
        $this->withoutMiddleware();
        $this->delete("/v1/candidates/2", [], []);
        $this->seeStatusCode(200);
        $this->seeJson(['Deleted Successfully']);
    }
    

    public function testCandidatesUpdate()
    {   $this->withoutMiddleware();
       
        $parameters = [
            'first_name' => 'test_firstname',
            'last_name' => 'test_lastname',
            'email' => 'vvakash@addonit.in',
            'contact_number' => '8899889988',
            'gender' => 1,
            'specialization' => 'unittest specialization',
            'work_ex_year' => 3,
            'candidate_dob' => '2020-04-05',
            'address' => 'unittest address',
            'resume' => 'unittest testproduct',
        ];

        $this->put("v1/candidates/4", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJson($parameters);

    }

    public function testCandidatesListing()
    {   $this->withoutMiddleware();
         $this->get("v1/candidates?limit=10",[]);
        $this->seeStatusCode(200);
    }

    public function testCandidatesListingperticular()
    {   $this->withoutMiddleware();
         $this->get("v1/candidates/1",[]);
        $this->seeStatusCode(200);
    }

    public function testCandidatesListingpsearch()
    {   $this->withoutMiddleware();
         $this->get("v1/candidates/search?email=akash@addonit.in&first_name=akash&last_name=raikar",[]);
        $this->seeStatusCode(200);
    }

    
    public function testCandidatesListingpsave()
    {  
         $this->post("/save?email=akash@addonit.in&name=akash&password=welcome",[]);
        $this->seeStatusCode(200);
    }

    public function testCandidateslogin()
    {  
         $this->get("/login?email=akash@addonit.in&password=welcome",[]);
        $this->seeStatusCode(200);
    }

  
}
