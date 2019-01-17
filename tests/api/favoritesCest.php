<?php

use Faker\Factory as fake;

class favoritesCest
{
    public $route = '/favorites';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/favorites'.$params;
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

    //-------------- Send Get Listing of favorites -------------------//
    public function sendGetListingOfFavorites(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }


    //-------------- Send Post Create New favorites -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewFavorites(ApiTester $I)
    {
        $data = [
            'entityClass' => 'host',
            'entityId' => fake::create()->randomNumber(2)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //-------------- Send Post Create New favorites Error -------------------//
    public function sendPostCreateNewFavoritesError(ApiTester $I)
    {
        $data = [
            'entityClass' => 'host',
            'entityId' => fake::create()->randomNumber(2)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(500);
    }

    //-------------- Send Put Modify favorite By ID --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyFavoritesById(ApiTester $I)
    {
        $this->userID = 1;
        $data = [
            'entityClass' => 'host',
            'entityId' => 10,
        ];
        $I->sendPUT($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //---------------- Send Get Show favorites By ID --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowFavoritesById(ApiTester $I)
    {
        $this->userID = 1;
        $data = [
            "id" => 1,
            'entityClass' => 'host',
            'entityId' => 10,
        ];
        $I->sendGET($this->route.'/'.$this->userID);
        $I->seeResponseContainsJson($data);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Delete favorites By ID -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteFavoritesByID(ApiTester $I)
    {
        $this->userID = 4;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }






















}
