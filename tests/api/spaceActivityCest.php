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

    //-------------- Send Get Listing of space activities  -------------------//
    public function sendGetListingOfSpaceActivities(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Post of Space Activities  -------------------//
    /**
     * @param ApiTester $I
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
    public function sendPutModifySpaceActivitiesById(ApiTester $I)
    {
        $data = [
            'spaceId' => 1,
            'activityId' => 2
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Get Space Activities By ID  -------------------//
    public function sendGetSpaceActivities(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Delete of Space Activities BY Id  -------------------//
    public function sendDeleteSpaceActivitiesById(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }





}
