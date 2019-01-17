<?php

use Faker\Factory as fake;

class ratingsCest
{
    public $route = '/ratings';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/ratings'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com", "8_yry7p>+-[fWg^.");
    }


    //-------------- Send Post Create new Ratings ---------//
    public function sendPostCreateNewRatings(ApiTester $I)
    {
        $data = [
            'id' => 1,
            'userId' => 2,
            'entityClass' => 'host',
            'entityId' => 2,
            'value' => fake::create()->randomNumber(2)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //-------------- Send Get Show Ratings By ID ---------//
    public function sendGetShowRatingsById(ApiTester $I)
    {
        $this->userID = 3;
        $I->sendGET($this->route.'/'.$this->userID);
        $I->seeResponseContainsJson([
            'id' => 3,
            'userId' => 2,
            'entityClass' => 'host',
            'entityId' => 2,
            'value' => 5
        ]);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Get Listing Ratings ---------//
    public function sendGetListingRatings(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Put Modify Ratings By ID ---------//
    public function sendPutModifyRatingsById(ApiTester $I)
    {
        $this->userID = 1;
        $data = [
            'entityClass' => 'host',
            'entityId' => 2,
            'value' => fake::create()->randomNumber(2)
        ];
        $I->sendPUT($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Create Ratings By ID ---------//
    public function sendDeleteRatingsByID(ApiTester $I)
    {
        $this->userID = 4;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }














}
