<?php

use Faker\Factory as fake;

class workoutsCest
{
    public $route = '/workouts';
    public $userID;

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
        $I->loginAs('yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com', '8_yry7p>+-[fWg^.');
    }

    //----------- Send Post Create New workout(s)2  -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostCreateNewWorkoutsQuantity(ApiTester $I)
    {
        $data = [
            'quantity' => fake::create()->randomNumber(2, true),
            'sessionId' => fake::create()->randomNumber(2, true),
        ];
        $I->saveWorkouts([
            $data['quantity'], ' ',
            $data['sessionId'], ' ',
        ],'workouts.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //------------ Send Put Assign workout to Training  ------------//
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

    //------------ Send Get Listing of workouts   -------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfWorkouts(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //------------ Send Delete workout ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteWorkout(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }













}
