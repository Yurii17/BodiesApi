<?php

use Faker\Factory as fake;

class workoutsCest
{
    public $route = '/workouts';
    public $userID;
    public $sessionID;
    public $trainingIds;
    public $reassignID;

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

    //----------- Send Post Create New Workouts  -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostCreateNewWorkouts(ApiTester $I)
    {
        $data = [
            'trainingIds' => [
              200,
              223,
              288
            ],
            'quantity' => fake::create()->randomNumber(2, true),
            'sessionId' => 43,
        ];
        $I->saveWorkouts([
            $data['quantity'], ' ',
            $data['sessionId'], ' ',
        ],'workouts.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $this->sessionID = $I->grabDataFromResponseByJsonPath('$.sessionId');
        $I->seeResponseCodeIs(201);
    }

    //------------ Send Put Assign workout to Training  ------------//
    /**
     * @param ApiTester
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPutAssignWorkoutToTraining(ApiTester $I)
    {
        $data = [
            "trainingId" => 200,
            "sessionId" => $this->sessionID[0]
        ];
        $I->sendPUT($this->route.'/assign', $data);
        $this->reassignID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(200);
    }

    //----------- Send Put Reassign Workout to Training --------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutReassignWorkoutsToTraining(ApiTester $I)
    {
        $data = [
            'trainingId' => 200
        ];
        $I->sendPUT($this->route.'/'.$this->reassignID[0].'/reassign', $data);
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

    //------------ Send Delete Unassign workouts ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteUnassignWorkouts(ApiTester $I)
    {
        $this->trainingIds = 200;
        $I->sendDELETE($this->route.'/'.$this->trainingIds);
        $I->seeResponseCodeIs(200);
    }

    //----------- Send Post Create New Workouts Error -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostCreateNewWorkoutsError(ApiTester $I)
    {
        $data = [
            'quantity' => fake::create()->randomNumber(2, true),
            'sessionId' => null
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'sessionId',
            'message' => 'Session Id cannot be blank.'
        ]);
    }

    //----------- Send Post Create New Workouts SessionId Error -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostCreateNewWorkoutsSessionIdError(ApiTester $I)
    {
        $data = [
            'quantity' => fake::create()->randomNumber(2, true),
            'sessionId' => fake::create()->text(20)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'sessionId',
            'message' => 'Session Id must be an integer.'
        ]);
    }











}
