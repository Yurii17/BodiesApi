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

    //----------- Send Post Create New Spaces ------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostCreateNewSpaces(ApiTester $I)
    {
        $data = [
            'locationId' => 206,
            'name' => 'Free wifi',
            'description' => fake::create()->text(20)
        ];
        $I->saveSpaces([
            $data['locationId'], ' ',
            $data['name'], ' ',
            $data['description'], ' '
        ], 'spaces.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //----------------- Send Put Modify Spaces BY ID ------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPutModifySpaces(ApiTester $I)
    {
        $data = [
            'locationId' => 200,
            'name' => 'Free wifi',
            'description' => fake::create()->text(20)
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //----------------- Send Delete Spaces By ID ------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteSpacesById(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }

    //----------- Send Get Listing of spaces  ------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfSpaces(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //----------------- Send Get Show Space By ID ------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowSpacesById(ApiTester $I)
    {
        $this->userID = 44;
        $I->sendGET($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(200);
    }

    //--------------- Send Get List assigned Activities BY Id ---------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListAssignedActivitiesById(ApiTester $I)
    {
        $this->userID = 44;
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
        $this->userID = 44;
        $I->sendGET($this->route.'/'.$this->userID.'/schedules');
        $I->seeResponseCodeIs(200);
    }

    //--------------- Send Get List assigned Video BY Id ---------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListAssignedVideosById(ApiTester $I)
    {
        $this->userID = 44;
        $I->sendGET($this->route.'/'.$this->userID.'/videos');
        $I->seeResponseCodeIs(200);
    }

    //--------------- Send Get List assigned Photos BY Id ---------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListAssignedPhotosById(ApiTester $I)
    {
        $this->userID = 44;
        $I->sendGET($this->route.'/'.$this->userID.'/photos');
        $I->seeResponseCodeIs(200);
    }








}
