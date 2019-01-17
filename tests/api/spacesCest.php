<?php

use Faker\Factory as fake;


class spacesCest
{
    public $route = '/spaces';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/spaces'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com", "8_yry7p>+-[fWg^.");
    }

    //----------- Send Get Listing of spaces  ------------//
    public function sendGetListingOfSpaces(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //----------------- Send Post Create New Space ------------------//
    public function sendPostCreateNewSpaces(ApiTester $I)
    {
        $data = [
            'createdAt' => fake::create()->randomNumber(2),
            'userId' => 1,
            'code' => 'FWF',
            'name' => 'Free wifi',
            'description' => fake::create()->text(20)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //----------------- Send Put Modify Spaces BY ID ------------------//
    public function sendPutModifySpaces(ApiTester $I)
    {
        $this->userID = 1;
        $data = [
            'createdAt' => fake::create()->randomNumber(2),
            'userId' => 1,
            'code' => 'FWF',
            'name' => 'Free wifi',
            'description' => fake::create()->text(20)
        ];
        $I->sendPUT($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //----------------- Send Get Show Space By ID ------------------//
    public function sendGetShowSpacesById(ApiTester $I)
    {
        $this->userID = 1;
        $I->sendGET($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(200);
    }

    //----------------- Send Delete Spaces By ID ------------------//
    public function sendDeleteSpacesById(ApiTester $I)
    {
        $this->userID = 2;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }


    //--------------- Send Get List assigned Activities BY Id ---------------//
    public function sendGetListAssignedActivitiesById(ApiTester $I)
    {
        $this->userID = 1;
        $I->sendGET($this->route.'/'.$this->userID.'/activities');
        $I->seeResponseCodeIs(200);
    }

    //--------------- Send Get List assigned Schedules BY Id ---------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListAssignedSchedulesById(ApiTester $I)
    {
        $this->userID = 1;
        $I->sendGET($this->route.'/'.$this->userID.'/schedules');
        $I->seeResponseCodeIs(200);
    }

    //--------------- Send Get List assigned Video BY Id ---------------//
    public function sendGetListAssignedVideosById(ApiTester $I)
    {
        $this->userID = 1;
        $I->sendGET($this->route.'/'.$this->userID.'/videos');
        $I->seeResponseCodeIs(200);
    }

    //--------------- Send Get List assigned Photos BY Id ---------------//
    public function sendGetListAssignedPhotosById(ApiTester $I)
    {
        $this->userID = 1;
        $I->sendGET($this->route.'/'.$this->userID.'/photos');
        $I->seeResponseCodeIs(200);
    }


}
