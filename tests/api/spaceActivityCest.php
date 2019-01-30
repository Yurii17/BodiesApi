<?php

use Faker\Factory as fake;

class spaceActivityCest
{
    public $route = '/spaceActivities';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/spaceActivities'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com", "8_yry7p>+-[fWg^.");
    }

    //-------------- Send Post of Space Activities  -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostSpaceActivities(ApiTester $I)
    {
        $data = [
            'spaceId' => fake::create()->randomNumber(2),
            'activityId' => 2
        ];
        $I->saveSpaceActivity([
            $data['spaceId'], ' ',
            $data['activityId'], ' '
        ], 'spaceActivity.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //-------------- Send Put Modify of Space Activities By ID  -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPutModifySpaceActivitiesById(ApiTester $I)
    {
        $data = [
            'spaceId' => 1,
            'activityId' => 2
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Get Show Space Activities By ID  -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendGetSpaceActivitiesById(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Get Listing of space activities  -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendGetListingOfSpaceActivities(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Delete of Space Activities BY Id  -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendDeleteSpaceActivitiesById(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }

    //-------------- Send Delete of Space Activities Error  -------------------//
    public function sendDeleteSpaceActivitiesError(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeForbiddenErrorMessage([]);
    }

    //-------------- Send Post of Space Activities Error -------------------//
    public function sendPostSpaceActivitiesError(ApiTester $I)
    {
        $data = [
            'spaceId' => fake::create()->randomNumber(2),
            'activityId' => 2
        ];
        $I->sendPOST($this->route, $data);
        $I->seeForbiddenErrorMessage([]);
    }

    //-------------- Send Post of Space Activities SpaceId Error -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostSpaceActivitiesSpaceIdError(ApiTester $I)
    {
        $data = [
            'spaceId' => '@',
            'activityId' => 2
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'spaceId',
            'message' => 'Space ID must be an integer.'
        ]);
    }

    //------------- Send Post of Space Activities ActivityId Error --------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostSpaceActivitiesActivityIdError(ApiTester $I)
    {
        $data = [
            'spaceId' => fake::create()->randomNumber(2),
            'activityId' => '@'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'activityId',
            'message' => 'Activity ID must be an integer.'
        ]);
    }


}
