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
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostCreateNewRatings(ApiTester $I)
    {
        $data = [
            'entityClass' => 'training',
            'entityId' => fake::create()->randomNumber(1),
            'value' => fake::create()->numberBetween(1,5)
        ];
        $I->saveUserRatings([
            $data['entityClass'], ' ',
            $data['entityId'], ' ',
            $data['value'], ' '
        ], 'userRatings.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //-------------- Send Get Show Ratings By ID ---------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowRatingsById(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Get Listing Ratings ---------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingRatings(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Put Modify Ratings By ID ---------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyRatingsById(ApiTester $I)
    {
        $data = [
            'entityClass' => 'host',
            'entityId' => 2,
            'value' => fake::create()->numberBetween(1, 5)
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Delete Ratings By ID ---------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteRatingsByID(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }

    //-------------- Send Post Create Same Ratings Error  ---------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostCreateSameRatingsError(ApiTester $I)
    {
        $data = [
            'entityClass' => 'training',
            'entityId' => 10,
            'value' => 10
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([]);
    }














}
