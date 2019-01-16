<?php

use Faker\Factory as fake;

class coachActivityCest
{
    public $route = '/coachActivities';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/coachActivities'.$params;
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

    //-------------- Send Get Listing of coach activities ------------------//

    public function sendGetListingOfCoachActivities(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }



    //----------------- Send Post Assign Activity to coach ----------------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostAssignActivityToCoach(ApiTester $I)
    {
        $data = [
            "activityId" => 1,
            "coachId" => fake::create()->randomNumber(2, true),
            "certificateId" => 1,
            "availableTo" => "2019-11-30",
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //-------------------- Send Get Show coach activity -----------------------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowCoachActivity(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //------------------ Modify coach activity By Id ----------------------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyCoachActivityById(ApiTester $I)
    {
        $this->userID = 1;
        $data = [
            "activityId" => 1,
            "coachId" => 2,
            "certificateId" => 1,
            "availableTo" => "2019-11-30",
        ];
        $I->sendPUT($this->route.'/'. $this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    public function sendGetShowModifyCoachActivityById(ApiTester $I)
    {
        $this->userID = 1;
        $data = [
            "activityId" => 1,
            "coachId" => 2,
            "certificateId" => 1,
            "availableTo" => "2019-11-30"
        ];
        $I->sendGET($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //------------- Delete coach activity ---------------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteCoachActivityById(ApiTester $I)
    {
        $this->userID = 1;
        $I->sendDELETE($this->route.'/'. $this->userID);
        $I->seeResponseCodeIs(204);
    }









}
