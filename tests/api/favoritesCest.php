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
     * @throws Exception
     */
    public function sendPostCreateNewFavorites(ApiTester $I)
    {
        $data = [
            'entityClass' => 'host',
            'entityId' => fake::create()->randomNumber(2, true)
        ];
        $I->saveFavorites([
            $data['entityClass'], ' ',
            $data['entityId'], ' '
        ], 'favorites.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
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
        $data = [
            'entityClass' => 'host',
            'entityId' => 10,
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //---------------- Send Get Show favorites By ID --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowFavoritesById(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Delete favorites By ID -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteFavoritesByID(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }

    //-------------- Send Post Create New favorites UserId Error -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewFavoritesUserIdError(ApiTester $I)
    {
        $data = [
            'userId' => 'id'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'userId',
            'message' => 'User ID must be an integer.'
        ]);
    }

    //-------------- Send Post Create New favorites UserId Characters Error -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewFavoritesUserIdCharactersError(ApiTester $I)
    {
        $data = [
            'userId' => '@'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'userId',
            'message' => 'User ID must be an integer.'
        ]);
    }




















}
