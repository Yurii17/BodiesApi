<?php

use Faker\Factory as fake;

class productsCest
{
    public $route = '/products';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/products'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com", "8_yry7p>+-[fWg^.");
    }

    //------------ Send Post Create New Products ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostCreateNewProducts(ApiTester $I)
    {
        $data = [
            'sessionId' => 1,
            'workoutsQuantity' => 2,
            'price' => fake::create()->randomNumber(2),
            'title' => fake::create()->text(20)
        ];
        $I->saveProducts([
            $data['sessionId'], ' ',
            $data['workoutsQuantity'], ' ',
            $data['price'], ' ',
            $data['title'], ' ',
        ], 'products.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //------------ Send Put Modify Product By ID ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyById(ApiTester $I)
    {
        $data = [
            'sessionId' => 1,
            'workoutsQuantity' => 1,
            'price' => 1,
            'title' => fake::create()->text(20)
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //------------ Send Get Listing of Products  ----------------//
    public function sendGetListingOfProducts(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //------------ Send Get Show of Products By Id ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowOfProductsById(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //------------ Send Delete Products By ID  ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteProductsById(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }

    //------------ Send Post Create New Products Error ----------------//
    public function sendPostCreateNewProductsEmptyError(ApiTester $I)
    {
        $data = [
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([[
            'field' => 'userId',
            'message' => 'User ID cannot be blank.'], [
            'field' => 'sessionId',
            'message' => 'Session ID cannot be blank.'
        ]]);
    }

    //------------ Send Post Create New Products UserID Error ----------------//
    public function sendPostCreateNewProductsUserIdError(ApiTester $I)
    {
        $data = [
            'userId' => '@'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([[
            'field' => 'userId',
            'message' => 'User ID must be an integer.'], [
            'field' => 'sessionId',
            'message' => 'Session ID cannot be blank.'
        ]]);
    }

    //------------ Send Post Create New Products SessionID Error ----------------//
    public function sendPostCreateNewProductsSessionIdError(ApiTester $I)
    {
        $data = [
            'sessionId' => '@'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([[
            'field' => 'userId',
            'message' => 'User ID cannot be blank.'], [
            'field' => 'sessionId',
            'message' => 'Session ID must be an integer.'
        ]]);
    }























}
