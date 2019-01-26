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

    //------------- Send Get Listing of Connections -------------------//
    public function sendGetListingOfConnections(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Post Create New Connection -------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendPostCreateNewConnection(ApiTester $I)
    {
        $data = [
            "entityClass" => "location",
            "entityId" => 2,
            "type" => "website",
            "value" => "www.ergonized.com",
        ];
        $I->saveConnections([
            $data['entityClass'], ' ',
            $data['entityId'], ' ',
            $data['type'], ' ',
            $data['value'], ' '
        ],'connections.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //------------- Send Get Show connection By Id -------------------//
    public function sendGetShowConnectionByID(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Put Modify connection By Id -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyConnectionByID(ApiTester $I)
    {
        $data = [
            "entityClass" => "location",
            "entityId" => 2,
            "type" => "website",
            "value" => "www.ergonized.com",
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Delete Connection By Id -------------------//
    public function sendDeleteConnectionByID(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }















}
