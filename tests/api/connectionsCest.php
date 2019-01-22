<?php

use Faker\Factory as fake;

class connectionsCest
{
    public $route = '/connections';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/connections'.$params;
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

    //------------- Send Get Listing of connections -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfConnections(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Post Create new connection -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewConnection(ApiTester $I)
    {
        $data = [
            "entityClass" => "location",
            "entityId" => 2,
            "type" => "website",
            "value" => "www.ergonized.com",
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //------------- Send Get Show connection By Id -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowConnectionByID(ApiTester $I)
    {
        $this->userID = 30;
        $I->sendGET($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Put Modify connection By Id -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyConnectionByID(ApiTester $I)
    {
        $this->userID = 22;
        $data = [
            "entityClass" => "location",
            "entityId" => 2,
            "type" => "website",
            "value" => "www.ergonized.com",
        ];
        $I->sendPUT($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Delete Connection By Id -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteConnectionByID(ApiTester $I)
    {
        $this->userID = 22;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }















}
