<?php

use Faker\Factory as fake;

class userActivityCest
{
    public $route = '/userActivities';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/userActivities'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com", "8_yry7p>+-[fWg^.");
    }

    //--------------- Send Get Listing of User Activities ----------//
    public function sendGetListingOfUserActivities(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //--------------- Send Post New Assign Activity to User ----------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostAssignActivityToUserBySignIn(ApiTester $I)
    {
        $data = [
            'userId' => 1,
            'activityId' => 2
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    public function sendPostAssignActivityToUser(ApiTester $I)
    {
        $data = [
            'userId' => 1,
            'activityId' => fake::create()->randomNumber(1)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }


    //--------------- Send Delete user activity BY ID ----------//
    public function sendDeleteUserActivityById(ApiTester $I)
    {
        $this->userID = 2;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }












}
