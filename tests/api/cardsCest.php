<?php

use Faker\Factory as fake;

class cardsCest
{
    public $route = '/cards';
    public $ID;

    private function setRoute($params)
    {
        return $this->route = '/cards'.$params;
    }

    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+0badbae683b2c6ff5a14bfe90dcfef6d@gmail.com", "6bfAC<kkThESw2");
    }


    public function _before(ApiTester $I)
    {
    }

    //---------------Create-------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreate(ApiTester $I)
    {
        $data = [
            "token" => 'tok_visa'          // fake::create()->text(5)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(200);
    }

    //---------------Index---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetIndex(ApiTester $I)
    {
        $I->sendGet($this->route);
        $I->seeResponseCodeIs(200);
    }

    //---------------Show--------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShow(ApiTester $I)
    {
        $this->ID = 5;
        $I->sendGet($this->route.'/'.$this->ID);
        $I->seeResponseCodeIs(200);
    }

    //------------Delete--------------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteCards(ApiTester $I)
    {
        $this->ID = 5;
        $I->sendDELETE($this->route.'/'.$this->ID);
        $I->seeResponseCodeIs(204);
    }




























}
