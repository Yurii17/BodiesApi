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

    //---------------- Send Post Add New Session Settings  ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostAddNewSessionSettingsValid(ApiTester $I)
    {
        $data = [
            'type' => 'private',
            'participantsMax' => fake::create()->randomNumber(3),
            'distance' => fake::create()->randomNumber(2),
            'spend' => fake::create()->randomNumber(2),
            'atHome' => fake::create()->randomNumber(1),
            'backgroundCheck' => fake::create()->randomNumber(2),
            'userId' => fake::create()->randomNumber(2)
        ];
        $I->saveSettings([
            $data['type'], ' ',
            $data['participantsMax'], ' ',
            $data['distance'], ' ',
            $data['spend'], ' ',
            $data['atHome'], ' ',
            $data['backgroundCheck'], ' ',
            $data['userId'], ' '
        ],'settings.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    public function sendPostAddNewSessionSettingsError(ApiTester $I)
    {
        $data = [
            'type' => 'private'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeForbiddenErrorMessage([
            'name' => 'Forbidden',
            'message' => 'Access denied'
        ]);
    }

    //-------------  Send Put Edit Session settings  --------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutEditSessionSettings(ApiTester $I)
    {
        $data = [
            'type' => 'private',
            'participantsMax' => fake::create()->randomNumber(3),
            'distance' => fake::create()->randomNumber(2),
            'spend' => fake::create()->randomNumber(2),
            'atHome' => fake::create()->randomNumber(1),
            'backgroundCheck' => fake::create()->randomNumber(2),
//            'userId' => fake::create()->randomNumber(2)
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Get Listing of Sessions Settings  -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingSessionSettings(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //-----------  Send Show Session Settings  --------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowSessionSettingsByID(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Delete Session Settings By ID---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteSessionSettingsByID(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }














}
