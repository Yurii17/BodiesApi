<?php

use Faker\Factory as fake;

class coachesCest
{
    public $route = '/coaches';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/coaches'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com", "8_yry7p>+-[fWg^.");
    }

    public function _before(ApiTester $I)
    {
    }

    //------------- Send Post Add new coach -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostAddNewCoach(ApiTester $I)
    {
        $data = [
            "expireAt" => "2019-12-10 12:00:00",
            "description" => fake::create()->text(20),
            "inHouse" => 1,
            "gender" => "male",
            "websiteName" => fake::create()->text(20),
            "website" => "http://coach.com",
            "twitter" => "http://twitter.com",
            "instagram" => "http://instagram.com",
            "linkedin" => "http://linkedin.com",
            "facebook" => "http://facebook.com"
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //------------- Send Put Edit Coach By ID -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutEditCoach(ApiTester $I)
    {
        $this->userID = 10;
        $data = [
            "expireAt" => "2019-12-10 12:00:00",
            "description" => 'Test QA',
            "inHouse" => 1,
            "gender" => "male",
            "websiteName" => 'Test QA',
            "website" => "http://coach.com",
            "twitter" => "http://twitter.com",
            "instagram" => "http://instagram.com",
            "linkedin" => "http://linkedin.com",
            "facebook" => "http://facebook.com"
        ];
        $I->sendPUT($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Show Coach By ID -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowCoachById(ApiTester $I)
    {
        $this->userID = 10;
        $data = [
            "expireAt" => "2019-12-10 12:00:00",
            "description" => 'Test QA',
            "inHouse" => 1,
            "gender" => "male",
            "websiteName" => 'Test QA',
            "website" => "http://coach.com",
            "twitter" => "http://twitter.com",
            "instagram" => "http://instagram.com",
            "linkedin" => "http://linkedin.com",
            "facebook" => "http://facebook.com"
        ];
        $I->sendGET($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Listing of coaches -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfCoaches(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Delete Coaches By ID -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteOfCoachesByID(ApiTester $I)
    {
        $this->userID = 8;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }

    //------------- Send Get Listing of activities by coach ID -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfCoachesByCoachID(ApiTester $I)
    {
        $this->userID = 10;
        $I->sendGET($this->route.'/'.$this->userID.'/activities');
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Listing of videos by coach ID -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfVideosByCoachID(ApiTester $I)
    {
        $this->userID = 10;
        $I->sendGET($this->route.'/'.$this->userID.'/videos');
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Listing of photos by coach ID -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfPhotosByCoachID(ApiTester $I)
    {
        $this->userID = 10;
        $I->sendGET($this->route.'/'.$this->userID.'/photos');
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Listing of spaces by coach ID -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfSpacesByCoachID(ApiTester $I)
    {
        $this->userID = 10;
        $I->sendGET($this->route.'/'.$this->userID.'/spaces');
        $I->seeResponseCodeIs(200);
    }










}
