<?php

use Faker\Factory as fake;

class serviceCest
{
    public $route = '/';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com", "8_yry7p>+-[fWg^.");
    }

    //--------------- Send Get Service ---------------------//
    public function sendGetService(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }











}
