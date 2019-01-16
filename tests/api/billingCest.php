<?php

use Faker\Factory as fake;

class billingCest
{
    public $route = '/deposit';
    public $userID;
    public $card_ID;

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

    public function _before(ApiTester $I)
    {
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

    //------------------ Send Post Add Funds Valid --------------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostAddFunds(ApiTester $I)
    {
        $data = [
            "amount" => fake::create()->randomNumber(3,true),
            "source" => "tok_visa",
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(200);
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

    //-------------- Send Get Show Card By ID ---------------------------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowCardsOfUserByID(ApiTester $I)
    {
        $this->userID = 30;
        $this->card_ID = 1;
        $I->sendGET('/users/'.$this->userID.'/cards/'.$this->card_ID);   //users/:id/cards/:card_id
        $I->seeResponseCodeIs(200);
    }

    //----------------- Send Post Add Card -----------------------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostAddCardById(ApiTester $I)
    {
        $this->userID = 30;
        $this->card_ID = 1;
        $I->sendPOST('/users/'.$this->userID.'/cards/'.$this->card_ID);    //users/:id/cards/:card_id
        $I->seeResponseCodeIs(201);
    }

    //-------------- Delete Card By Id --------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteCardById(ApiTester $I)
    {
        $this->userID = 30;
        $this->card_ID = 1;
        $I->sendDELETE('/users/'.$this->userID.'/cards/'.$this->card_ID);    //users/:id/cards/:card_id
        $I->seeResponseCodeIs(204);
    }














}
