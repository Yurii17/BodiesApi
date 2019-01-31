<?php

use Faker\Factory as fake;

class billingCest
{
    public $route = '/deposit';
    public $userID;
    public $card_ID;
    public $token;

    private function setRoute($params)
    {
        return $this->route = '/deposit'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com", "8_yry7p>+-[fWg^.");
    }

    //------------------ Send Post Add Funds Sign In Valid --------------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostAddFundsSignInValid(ApiTester $I)
    {
        $data = [
            "amount" => fake::create()->randomNumber(2,true),
            "source" => "1",
        ];
        $I->saveUserBilling([
            $data['amount'], ' ',
            $data['source'], ' '
        ], 'userBilling.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $this->token = $I->grabDataFromResponseByJsonPath('$.token');
        $I->seeResponseCodeIs(200);
    }

    //----------------- Send Post Add Funds Error ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostAddFundsError(ApiTester $I)
    {
        $data = [
            "amount" => fake::create()->randomNumber(6,true),
            "source" => "tok_visa",
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(422);
        $I->seeErrorMessage([
            "field" => "amount",
            "message" => "Amount must be no greater than 2000."
        ]);
    }

    //------------------ Send Post Add Funds Login Error --------------------------------//
    public function sendPostAddFundsLoginError(ApiTester $I)
    {
        $data = [
            "amount" => fake::create()->randomNumber(3,true),
            "source" => "tok_visa",
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(403);
        $I->seeResponseContainsJson([
            'message' => 'Login Required'
        ]);
    }

    //--------- Send Get Cards of user By ID---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetCardsOfUserByID(ApiTester $I)
    {
        $this->userID = 30;
        $I->sendGET('/users/'.$this->userID.'/cards');   //users/:id/cards
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Post Add Card By ID ---------------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostAddCardByID(ApiTester $I)
    {
        $this->userID = 30;
        $data = [
            'token' => 'tok_visa'
        ];
        $I->sendPost('/users/'.$this->userID.'/cards', $data);
        $this->card_ID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Get Show Card By ID ---------------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowCardsOfUserByID(ApiTester $I)
    {
        $this->userID = 30;
        $I->sendGET('/users/'.$this->userID.'/cards/'.$this->card_ID[0]);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Get User's Balance By ID ---------------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetUserBalanceByID(ApiTester $I)
    {
        $this->userID = 30;
        $I->sendGET('/users/'.$this->userID.'/balance');
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Get Payment History By ID ---------------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPaymentHistoryByID(ApiTester $I)
    {
        $this->userID = 30;
        $I->sendGET('/users/'.$this->userID.'/history');
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Post Buy Training By ID Valid ---------------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostBuyTrainingByIDValid(ApiTester $I)
    {
        $this->userID = 30;
        $I->sendPOST('/trainings/'.$this->userID.'/buy');
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Post Buy Training By ID Error ---------------------------------//

    public function sendPostBuyTrainingByIDError(ApiTester $I)
    {
        $this->userID = 30;
        $I->sendPOST('/trainings/'.$this->userID.'/buy');
        $I->seeResponseCodeIs(403);
        $I->seeResponseContainsJson([
            'message' => 'Login Required'
        ]);
    }

    //-------------- Delete Card By Id --------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteCardById(ApiTester $I)
    {
        $this->userID = 30;
        $I->sendDELETE('/users/'.$this->userID.'/cards/'.$this->card_ID[0]);
        $I->seeResponseCodeIs(204);
    }








}
