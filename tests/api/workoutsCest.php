<?php

use Faker\Factory as fake;

class workoutsCest
{

    public $route = '/workouts';
    public $trainingID;

    private function setRoute($params)
    {
        return $this->route = '/workouts'.$params;
    }

    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+0badbae683b2c6ff5a14bfe90dcfef6d@gmail.com", "6bfAC<kkThESw2");
    }


    public function _before(ApiTester $I)
    {
    }


    //-------------Listing of workouts-----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfWorkouts(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }


    //-----------Create new workout(s)-----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewWorkoutsTrainingIds(ApiTester $I)
    {
        $data = [
            "trainingIds" => [
                fake::create()->randomNumber(1, true),
                fake::create()->randomNumber(1, true),
                fake::create()->randomNumber(1, true)
        ],
            "sessionId" => fake::create()->randomNumber(2, true)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //-----------Create new workout(s)2-----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewWorkoutsQuantity(ApiTester $I)
    {
        $data = [
            "quantity" => fake::create()->randomNumber(2, true),
            "sessionId" => fake::create()->randomNumber(2, true)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //------------Assign workout to training------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutAssignWorkoutToTraining(ApiTester $I)
    {
        $data = [
            "trainingId" => fake::create()->randomNumber(2, true),
            "sessionId" => fake::create()->randomNumber(2, true)
        ];
        $I->sendPUT($this->route.'/assign', $data);
        $I->seeResponseCodeIs(200);
    }

    //----------------Unasign workout Delete-----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteUnasignWorkout(ApiTester $I)
    {
        $this->trainingID = 24;
        $I->sendDELETE($this->route.'/'.$this->trainingID);
        $I->seeResponseCodeIs(200);
    }













}
