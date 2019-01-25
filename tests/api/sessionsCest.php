<?php

use Faker\Factory as fake;

class sessionsCest
{
    public $route = '/sessions';
    public $userID;
    public $sessionIds;
    public $trainingIds;

    private function setRoute($params)
    {
        return $this->route = '/sessions'.$params;
    }

    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+0badbae683b2c6ff5a14bfe90dcfef6d@gmail.com", "6bfAC<kkThESw2");
    }

    //-------------- Send Post Add New Session Valid -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostAddNewSessionValid(ApiTester $I)
    {
        $data = [
            'name' => 'Test Session',
            'description' => fake::create()->text(50),
            'type' => 'fit',
            'price' => fake::create()->randomNumber(2),
            'atHome' => '1',
            'isGroup' => 1,
            'participantsMax' => fake::create()->randomNumber(2,true),
            'isLevelBeginner' => '1',
            'isLevelIntermediate' => '1',
            'isLevelAdvanced' => '1',
            'trainingIntro' => 1,
            'trainingSingle' => '1',
            'trainingMultiple' => 1,
            'userId' => 1
        ];
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    public function sendPostAddNewSessionError(ApiTester $I)
    {
        $data = [
            'price' => 1,
            'name' => 'Test Session',
            'description' => 'Test',
            'type' => 'fit',
        ];
        $I->sendPOST($this->route, $data);
        $I->seeForbiddenErrorMessage([
            'name' => 'Forbidden',
            'message' => 'Access denied'
        ]);
    }

    //------------  Send Put Edit Session By ID  ------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutEditSessionById(ApiTester $I)
    {
        $data = [
            "price" => 100,
            "name" => "Test Session",
            "description" => fake::create()->text(10),
            "type" => "fit",
            "isGroup" => 1,
            "inHouse" => 1,
            "participantsMax" => fake::create()->randomNumber(2,true),
            "trainingIntro" => 1,
            "trainingMultiple" => 1
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //--------------- Send Get Listing of Sessions  ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfSessions(ApiTester $I)
    {
        $I->sendGet($this->route);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Post Create Trainings by Session ID   ------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostCreateTrainingsBySessionID(ApiTester $I)
    {
        $data = [
            'id' => 1,
            'createdAt' => '2019-01-03 12:20:53',
            'modifiedAt' => '2019-01-03 12:20:53',
            'expireAt' => null,
            'status' => null,
            'userId' => 1,
            'sessionId' => 1,
            'participantsCurrent '=> 1,
            'startDatetime' => '2018-12-12 12:00:00',
            'endDatetime' => '2018-12-12 13:00:00',
            'spaceId' => 15,
            'participantsCurrent' => 1,
            'start' => [
                '2019-02-01 10:00:00',
                '2019-02-02 10:00:00',
                '2019-02-03 10:00:00'
            ],
            'end' => [
                '2019-02-01 12:00:00',
                '2019-02-02 12:00:00',
                '2019-02-03 12:00:00'
            ]
        ];
        $I->sendPOST($this->route.'/'.$this->userID[0].'/trainings', $data);
        $I->seeResponseCodeIs(200);
        $this->sessionIds = $I->grabDataFromResponseByJsonPath('$.[*].session.id');
        $this->trainingIds = $I->grabDataFromResponseByJsonPath('$[*].id');
    }

    //------------  Send Put Update Trainings by Session ID   -------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutUpdateTrainingsBySessionId(ApiTester $I)
    {
        $data = [
            'spaceId' => 15,
            'participantsCurrent' => 1,
            'start' => [
                '2019-02-01 12:00:00',
                '2019-02-02 12:00:00',
                '2019-02-03 12:00:00'
            ],
            'end' => [
                '2019-02-01 14:00:00',
                '2019-02-02 14:00:00',
                '2019-02-03 14:00:00'
            ],
            'trainingIds' => [$this->trainingIds[0]]
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0].'/trainings', $data);
        $I->seeResponseCodeIs(200);
    }

    //--------------  Send Get Show Session By ID ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowSessionById(ApiTester $I)
    {
        $I->sendGet($this->route.'/'.$this->sessionIds[0]);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Get Listing of Trainings by Session ID   -----------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfTrainingsBySessionID(ApiTester $I)
    {
        $I->sendGet($this->route.'/'.$this->sessionIds[0].'/trainings');
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Delete trainings by Session ID  -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteTrainingsBySessionId(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->trainingIds[0].'/trainings');
        $I->seeResponseCodeIs(204);
    }

    //-------------  Send Get Listing of Activities by Session ID   --------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfActivitiesBySessionID(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0].'/activities');
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Post Create activities by Session ID   ------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateActivitiesBySessionID(ApiTester $I)
    {
        $data = [
            'activities' => [
                fake::create()->randomNumber(1,true),
                fake::create()->randomNumber(1,true),
                fake::create()->randomNumber(1,true)
        ]];
        $I->sendPOST($this->route.'/'.$this->sessionIds[0].'/activities', $data);
        $I->seeResponseCodeIs(200);
    }

    //--------------  Send Put Update activities by Session ID  --------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutUpdateActivitiesBySessionID(ApiTester $I)
    {
        $data = [
            'activities' => [
                fake::create()->randomNumber(1,true),
                fake::create()->randomNumber(1,true),
                fake::create()->randomNumber(1,true)
            ]];
        $I->sendPUT($this->route.'/'.$this->sessionIds[0].'/activities', $data);
        $I->seeResponseCodeIs(200);
    }

    //--------------- Send Delete Activities by Session ID   ---------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteActivitiesBySessionID(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->sessionIds[0].'/activities');
        $I->seeResponseCodeIs(204);
    }

    //-------------- Send Get Listing of Coaches by Session ID  --------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfCoachesBySessionID(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->sessionIds[0].'/coaches');
        $I->seeResponseCodeIs(200);
    }

    //--------------- Send Post Create Coach by Session ID  --------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateCoachBySessionID(ApiTester $I)
    {
        $data = [
            "coach" => [
                fake::create()->randomNumber(1,true)],
            'userId' => $this->userID[0]
        ];
        $I->sendPOST($this->route.'/'.$this->sessionIds[0].'/coaches', $data);
        $I->seeResponseCodeIs(200);
    }

    //-------------   Send Put Update Coach by Session ID  ---------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutUpdateCoachBySessionID (ApiTester $I)
    {
        $data = [
            "coach" => [
                fake::create()->randomNumber(1,true),
                fake::create()->randomNumber(1,true),
                fake::create()->randomNumber(1,true)
            ]];
        $I->sendPUT($this->route.'/'.$this->sessionIds[0].'/coaches', $data);
        $I->seeResponseCodeIs(200);
    }

    //--------------  Send Delete Coaches by Session ID   --------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteCoachBySessionID(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->sessionIds[0].'/coaches');
        $I->seeResponseCodeIs(204);
    }

    //-------------   Send Delete Session By Id --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteSessionById(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->sessionIds[0]);
        $I->seeResponseCodeIs(204);
    }









}
