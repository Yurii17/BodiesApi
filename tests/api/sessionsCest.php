<?php

use Faker\Factory as fake;


class sessionsCest
{
    public $route = '/sessions';
    public $userID;


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

    public function _before(ApiTester $I)
    {
    }


    //--------------Add new session----------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostAddNewSession(ApiTester $I)
    {
        $data = [
        "price" => 100,
        "name" => "Test Session",
        "description" => "Bla bla bla",
        "type" => "fit",
        "isGroup" => 1,
        "inHouse" => 1,
        "participantsMax" => fake::create()->randomNumber(2,true),
        "trainingIntro" => 1,
        "trainingMultiple" => 1
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //------------------Edit session------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutEditSession(ApiTester $I)
    {
        $this->userID = 52;
        $data = [
            "price" => 100,
            "name" => "Test Session",
            "description" => fake::create()->text(5,true),
            "type" => "fit",
            "isGroup" => 1,
            "inHouse" => 1,
            "participantsMax" => fake::create()->randomNumber(2,true),
            "trainingIntro" => 1,
            "trainingMultiple" => 1
        ];
        $I->sendPUT($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //--------------------Listing of sessions--------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfSessions(ApiTester $I)
    {
        $I->sendGet($this->route);
        $I->seeResponseCodeIs(200);
    }

    //--------------------ShowSession-------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowSession(ApiTester $I)
    {
        $this->userID = 30;
        $I->sendGet($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(200);
    }


    //-------------------Delete Session---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteSession(ApiTester $I)
    {
        $this->userID = 52;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }

    //----------------Listing of trainings by Session ID----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfTrainingsBySessionID(ApiTester $I)
    {
        $this->userID = 22;
        $I->sendGet($this->route.'/'.$this->userID.'/trainings');
        $I->seeResponseCodeIs(200);
    }

    //-----------------Create trainings by Session ID----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateTrainingsBySessionID(ApiTester $I)
    {
        $this->userID = 22;
        $data = [
            'locationId' => 1,
                'start' => [
                '2018-12-12 12:00:00',
                '2018-12-13 12:00:00',
                '2018-12-14 12:00:00'
                ],
                    'end' => [
                        '2018-12-12 13:00:00',
                        '2018-12-13 13:50:00',
                        '2018-12-14 13:00:00'
                        ]
        ];
        $I->sendGet($this->route.'/'.$this->userID.'/trainings', $data);
        $I->seeResponseCodeIs(200);
    }

    //------------Update trainings by Session ID---------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutUpdateTrainingsBySessionId(ApiTester $I)
    {
        $this->userID = 42;
        $data = [
            'locationId' => 1,
            'start' => [
                '2018-12-12 12:00:00',
                '2018-12-13 12:00:00',
                '2018-12-14 12:00:00'
            ],
            'end' => [
                '2018-12-12 13:00:00',
                '2018-12-13 13:00:00',
                '2018-12-14 13:00:00'
            ]
        ];
        $I->sendPUT($this->route.'/'.$this->userID.'/trainings', $data);
        $I->seeResponseCodeIs(200);
    }

    //-------------------Delete trainings by Session ID----------------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteTrainingsBySessionId(ApiTester $I)
    {
        $this->userID = 42;
        $I->sendDELETE($this->route.'/'.$this->userID.'/trainings');
        $I->seeResponseCodeIs(204);
    }

    //----------------Listing of activities by Session ID---------------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfActivitiesBySessionID(ApiTester $I)
    {
        $this->userID = 42;
        $I->sendGET($this->route.'/'.$this->userID.'/activities');
        $I->seeResponseCodeIs(200);
    }

    //----------------Create activities by Session ID----------------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateActivitiesBySessionID(ApiTester $I)
    {
        $this->userID = 42;
        $data = [
            "activities" => [
                fake::create()->randomNumber(1,true),
                fake::create()->randomNumber(1,true),
                fake::create()->randomNumber(1,true)
        ]];
        $I->sendPOST($this->route.'/'.$this->userID.'/activities', $data);
        $I->seeResponseCodeIs(200);
    }

    //-----------------Update activities by Session ID--------------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutUpdateActivitiesBySessionID(ApiTester $I)
    {
        $this->userID = 42;
        $data = [
            "activities" => [
                fake::create()->randomNumber(1,true),
                fake::create()->randomNumber(1,true),
                fake::create()->randomNumber(1,true)
            ]];
        $I->sendPUT($this->route.'/'.$this->userID.'/activities', $data);
        $I->seeResponseCodeIs(200);
    }

    //------------------Delete activities by Session ID---------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteActivitiesBySessionID(ApiTester $I)
    {
        $this->userID = 42;
        $I->sendDELETE($this->route.'/'.$this->userID.'/activities');
        $I->seeResponseCodeIs(204);
    }

    //-----------------Listing of coaches by Session ID--------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfCoachesBySessionID(ApiTester $I)
    {
        $this->userID = 42;
        $I->sendGET($this->route.'/'.$this->userID.'/coaches');
        $I->seeResponseCodeIs(200);
    }

    //-----------------Create coaches by Session ID--------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateCoachesBySessionID(ApiTester $I)
    {
        $this->userID = 42;
        $data = [
            "coaches" => [
                fake::create()->randomNumber(1,true),
                fake::create()->randomNumber(1,true),
                fake::create()->randomNumber(1,true)
            ]];
        $I->sendPOST($this->route.'/'.$this->userID.'/coaches', $data);
        $I->seeResponseCodeIs(200);
    }

    //----------------Update coaches by Session ID---------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutUpdateCoachesBySessionID (ApiTester $I)
    {
        $this->userID = 42;
        $data = [
            "coaches" => [
                fake::create()->randomNumber(1,true),
                fake::create()->randomNumber(1,true),
                fake::create()->randomNumber(1,true)
            ]];
        $I->sendPUT($this->route.'/'.$this->userID.'/coaches', $data);
        $I->seeResponseCodeIs(200);
    }

    //-----------------Delete coaches by Session ID--------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteCoachesBySessionID(ApiTester $I)
    {
        $this->userID = 42;
        $I->sendDELETE($this->route.'/'.$this->userID.'/coaches');
        $I->seeResponseCodeIs(204);
    }




}
