<?php

use Faker\Factory as fake;

class locationsCest
{
    public $route = '/locations';
    public $locationID;

    private function setRoute($params)
    {
        return $this->route = '/locations'.$params;
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

    //---------------Create new location------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewLocation(ApiTester $I)
    {
        $data = [
            "addressId" => fake::create()->randomNumber(2, true),
            "name" => fake::create()->name,
            "description" => fake::create()->text(10),
            "logo" => "",
            "isLegalOwner" => '1',
            "type" => "commercial",
            "isParking" => 1,
            "size" => 3,
            "isBathroom" => 0,
            "isTowelService" => 1,
            "isShowers" => 1,
            "isInternet" => 1,
            "isFreeWifi" =>0
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //---------------Index---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetIndexLocation(ApiTester $I)
    {
        $I->sendGet($this->route);
        $I->seeResponseCodeIs(200);
    }

    //---------------Show location by Id---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowLocationByID(ApiTester $I)
    {
        $this->locationID = 159;
        $I->sendGET($this->route.'/'.$this->locationID);
        $I->seeResponseCodeIs(200);
    }

    //---------------Modify location----------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyLocation(ApiTester $I)
    {
        $this->locationID = 159;
        $data = [
            "addressId" => fake::create()->randomNumber(2, true),
            "name" => fake::create()->name,
            "description" => fake::create()->text(10),
            "logo" => "",
            "isLegalOwner" => '1',
            "type" => "commercial",
            "isParking" => 1,
            "size" => 3,
            "isBathroom" => 0,
            "isTowelService" => 1,
            "isShowers" => 1,
            "isInternet" => 1,
            "isFreeWifi" =>0
        ];
        $I->sendPUT($this->route.'/'.$this->locationID, $data);
        $I->seeResponseCodeIs(200);
    }

    //----------------Delete location----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteLocation(ApiTester $I)
    {
        $this->locationID = 163;
        $I->sendDELETE($this->route.'/'.$this->locationID);
        $I->seeResponseCodeIs(204);
    }

    //---------------List assigned activities--------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListAssignedActivities(ApiTester $I)
    {
        $this->locationID = 170;
        $I->sendGET($this->route.'/'.$this->locationID.'/activities');
        $I->seeResponseCodeIs(200);
    }

    //--------------List assigned spaces-----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListAssignedSpaces(ApiTester $I)
    {
        $this->locationID = 170;
        $I->sendGET($this->route.'/'.$this->locationID.'/spaces');
        $I->seeResponseCodeIs(200);
    }

    //--------------List assigned connections-----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListAssignedConnections(ApiTester $I)
    {
        $this->locationID = null;
        $I->sendGET($this->route.'/'.$this->locationID.'/connections');
        $I->seeResponseCodeIs(200);
    }

    //--------------List assigned video-----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListAssignedVideo(ApiTester $I)
    {
        $this->locationID = null;
        $I->sendGET($this->route.'/'.$this->locationID.'/videos');
        $I->seeResponseCodeIs(200);
    }

    //--------------List assigned photo-----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListAssignedPhoto(ApiTester $I)
    {
        $this->locationID = 170;
        $I->sendGET($this->route.'/'.$this->locationID.'/photos');
        $I->seeResponseCodeIs(200);
    }

    //--------------Listing of locations for user-----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfLocationsForUser(ApiTester $I)
    {
        $this->locationID = 169;
        $I->sendGET($this->route.'/user/'.$this->locationID);
        $I->seeResponseCodeIs(200);
    }

    //--------------List assigned documents-----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListAssignedDocuments(ApiTester $I)
    {
        $this->locationID = 169;
        $I->sendGET($this->route.'/'.$this->locationID.'/documents');
        $I->seeResponseCodeIs(200);
    }

    //--------------List personal locations for user-----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListPersonalLocationsForUser(ApiTester $I)
    {
        $this->locationID = 64;
        $I->sendGET($this->route.'/personal');
        $I->seeResponseCodeIs(200);
    }























}
