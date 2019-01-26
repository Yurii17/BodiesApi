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

    //------------- Send Post Add new Coaches -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostAddNewCoaches(ApiTester $I)
    {
        $data = [
            "userId" => "1",
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
        $I->saveCoaches([
            $data['userId'], ' ',
            $data['description'], ' ',
            $data['inHouse'], ' ',
            $data['gender'], ' ',
            $data['websiteName'], ' ',
            $data['website'], ' ',
            $data['twitter'], ' ',
            $data['instagram'], ' ',
            $data['linkedin'], ' ',
            $data['facebook'], ' '
        ], 'coaches.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //------------- Send Post Add new Coaches Error -----------------//
    public function sendPostAddNewCoachesError(ApiTester $I)
    {
        $data = [
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(403);
    }

    //------------- Send Post Add new Coaches Empty Error -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostAddNewCoachesEmptyError(ApiTester $I)
    {
        $data = [
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([[
            'field' => 'gender',
            'message' => 'Gender cannot be blank.'], [
            'field' => 'description',
            'message' => 'Description cannot be blank.']
        ]);
    }

    //------------- Send Put Edit Coach By ID -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutEditCoach(ApiTester $I)
    {
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
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Show Coach By ID -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowCoachById(ApiTester $I)
    {
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
        $I->sendGET($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Listing of Coaches -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfCoaches(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Listing of Activities by coach ID -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfCoachesByCoachID(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0].'/activities');
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Listing of videos by coach ID -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfVideosByCoachID(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0].'/videos');
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Listing of Photos by coach ID -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfPhotosByCoachID(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0].'/photos');
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Listing of spaces by coach ID -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfSpacesByCoachID(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0].'/spaces');
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Delete Coaches By ID -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteOfCoachesByID(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }










}
