<?php

use Faker\Factory as fake;

class settingsCest
{
    public $route = '/sessionSettings';
    public $userID;


    private function setRoute($params)
    {
        return $this->route = '/sessionSettings'.$params;
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

    //----------------Add new session settings-----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostAddNewSessionSettings(ApiTester $I)
    {
        $data = [
            "type" => "private", //fake::create()->randomNumber(2,true)
            "favorites" => "1",
            "distance" => "2",
            "spend" => "10",
            "atHome" => "0"
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //-------------Edit session settings----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutEditSessionSettings(ApiTester $I)
    {
        $this->userID = 3;
        $data = [
            "type" => "private", //fake::create()->randomNumber(2,true)
            "favorites" => "1",
            "distance" => fake::create()->randomNumber(2,true),
            "spend" => "10",
            "atHome" => "0"
        ];
        $I->sendPUT($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //--------------Listing of sessions settings-----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingSessionSettings(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //-------------Show session settings--------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowSessionSettingsByID(ApiTester $I)
    {
        $this->userID = 3;
        $data = [
            "type" => "private", //fake::create()->randomNumber(2,true)
            "favorites" => '1',
            "distance" => '50',
            "spend" => '10',
            "atHome" => '0'
        ];
        $I->sendGET($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //-------------------Delete Session settings By ID---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteSessionSettingsByID(ApiTester $I)
    {
        $this->userID = 28;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }














}
