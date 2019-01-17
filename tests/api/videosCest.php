<?php

use Faker\Factory as fake;

class videosCest
{
    public $route = '/videos';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/videos'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com", "8_yry7p>+-[fWg^.");
    }


    //----------------- Send Get Listing of Videos By Id ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfVideosById(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //----------------- Send Post Videos By Id ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostOfVideosById(ApiTester $I)
    {
        $data = [
            'entityId' => 1,
            'entityClass' => "user",
            'files[]' => 'file source',
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //---------------- Send Delete Videos By Id ---------------------//
    public function sendDeleteVideosById(ApiTester $I)
    {
        $I->sendDELETE($this->route);
        $I->seeResponseCodeIs(204);
    }





}
