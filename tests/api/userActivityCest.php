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
        $I->loginAs('yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com', '8_yry7p>+-[fWg^.');
    }

    //--------------- Send Get Listing of User Activities ----------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
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
        $I->saveUserActivity([
           $data['userId'], ' ',
           $data['activityId'], ' '
        ],'userActivity.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //--------------- Send Delete user activity BY ID ----------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendDeleteUserActivityById(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }

    //-------------  Send Post Assign Activity Error ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostAssignActivityError(ApiTester $I)
    {
        $data = [
            'userId' => 1,
            'activityId' => '@'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([]);
    }

    //-------------  Send Post Assign Activity UserId Error ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostAssignActivityUserIdError(ApiTester $I)
    {
        $data = [
            'userId' => '@',
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([]);
    }

    //-------------  Send Post Assign Activity ID Error ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostAssignActivityIDError(ApiTester $I)
    {
        $data = [
            'activityId' => '@',
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([]);
    }

    //-------------  Send Post Assign Activity Empty Error ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostAssignActivityEmptyError(ApiTester $I)
    {
        $data = [
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([[
            'field' => 'userId',
            'message' => 'User ID cannot be blank.'], [
            'field' => 'activityId',
            'message' => 'Activity ID cannot be blank.'
        ]]);
    }










}
