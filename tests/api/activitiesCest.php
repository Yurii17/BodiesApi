<?php

use Faker\Factory as fake;

class activitiesCest
{
    public $route = '/activities';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/activities'.$params;
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

    //--------------Listing of activities------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfActivities(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //--------------Create new activity-------------------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewActivities(ApiTester $I)
    {
        $data = [
            "name" => "Yoga",
            "code" => "YO",
            "shortDesc" => "Yoga is a group of physical, mental, and spiritual practices",
            "fullDesc" => fake::create()->text(10),
            "isCertRequired" => 1
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //-------------- Show activity by ID -------------------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowActivities(ApiTester $I)
    {
        $this->userID = 8;
        $data = [
            "name" => "Yoga",
            "code" => "YO",
            "shortDesc" => "Yoga is a group of physical, mental, and spiritual practices",
            "fullDesc" => "Nihil.",
            "isCertRequired" => 1
        ];
        $I->sendGET($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Modify activity by ID -------------------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyActivitiesById(ApiTester $I)
    {
        $this->userID = 7;
        $data = [
            "shortDesc" => fake::create()->text(20),
            "fullDesc" => fake::create()->text(20)
        ];
        $I->sendPUT($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //------------ Delete activity -------------------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteActivitiesByID(ApiTester $I)
    {
        $this->userID = 5;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }














}
