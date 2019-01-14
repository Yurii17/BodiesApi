<?php

use Faker\Factory as fake;

class photoCest
{
    public $route = '/photos';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/photos'.$params;
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

    //-----------------Upload new photo------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostUploadNewPhotos(ApiTester $I)
    {
        $data = [
            "entityId" => 1,
            "entityClass" => "user",
            "files[]" => 'photo.png'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(200);
    }

    //--------------Listing of photos--------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfPhotos(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //--------------Show photo By ID--------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowPhotosById(ApiTester $I)
    {
        $this->userID = 1;
        $I->sendGET($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(200);
    }

    //--------------Delete Photo--------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeletePhotos(ApiTester $I)
    {
        $this->userID = 2;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(200);
    }










}
