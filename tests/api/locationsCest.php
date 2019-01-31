<?php

use Faker\Factory as fake;

class locationsCest
{
    public $route = '/locations';
    public $userID;

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
        $I->loginAs('yurii.lobas+0badbae683b2c6ff5a14bfe90dcfef6d@gmail.com', '6bfAC<kkThESw2');
    }

    //--------------- Send Post Create new location  ---------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
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
            "isFreeWifi" => 0
        ];
        $I->saveLocations([
            $data['addressId'], ' ',
            $data['name'], ' ',
            $data['description'], ' ',
            $data['logo'], ' ',
            $data['isLegalOwner'], ' ',
            $data['type'], ' ',
            $data['isParking'], ' ',
            $data['size'], ' ',
            $data['isTowelService'], ' ',
            $data['isShowers'], ' ',
            $data['isInternet'], ' ',
            $data['isFreeWifi'], ' '
        ], 'locations.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //----------- Send Get Index  --------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetIndexLocation(ApiTester $I)
    {
        $I->sendGet($this->route);
        $I->seeResponseCodeIs(200);
    }

    //------------ Send Get Show location by Id  -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowLocationByID(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //------------  Send Put Modify location By Id ----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyLocation(ApiTester $I)
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
            "isFreeWifi" => 0
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //------------ Send Get List assigned activities By ID --------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListAssignedActivitiesById(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0].'/activities');
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get List assigned Spaces By ID  -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListAssignedSpacesById(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0].'/spaces');
        $I->seeResponseCodeIs(200);
    }

    //------------ Send Get List Assigned Connections By ID  --------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListAssignedConnectionsById(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0].'/connections');
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get List Assigned Video By Id -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListAssignedVideoById(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0].'/videos');
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get List Assigned Photo By Id ---------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListAssignedPhotoById(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0].'/photos');
        $I->seeResponseCodeIs(200);
    }

    //------------  Send Get Listing of locations for user By ID -------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfLocationsForUser(ApiTester $I)
    {
        $I->sendGET($this->route.'/user/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Get List Assigned Documents By ID -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListAssignedDocumentsById(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0].'/documents');
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Get List Personal locations for user By ID  ---------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListPersonalLocationsForUserById(ApiTester $I)
    {
        $I->sendGET($this->route.'/personal');
        $I->seeResponseCodeIs(200);
    }

    //------------ Send Delete location By Id  --------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteLocationById(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }




















}
