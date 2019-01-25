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
     * @throws Exception
     */
    public function sendPostAssignActivityToUserBySignIn(ApiTester $I)
    {
        $data = [
            'userId' => 1,
            'activityId' => 1
        ];
        $I->saveUserActivities([
           $data['userId'], ' ',
           $data['activityId'], ' '
        ],'userActivities.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //-------------  Send Post Assign Activity Error ----------------//
    public function sendPostAssignActivityToUserError(ApiTester $I)
    {
        $data = [
            'userId' => 1,
            'activityId' => 123
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([]);
    }


    //--------------- Send Delete user activity BY ID ----------//
    public function sendDeleteUserActivityById(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }












}
