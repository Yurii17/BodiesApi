<?php

use Faker\Factory as fake;

class documentActivityCest
{
    public $route = '/documentActivity';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/documentActivity'.$params;
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

    //--------------Send Post Add new document activity----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostAddNewDocumentActivity(ApiTester $I)
    {
        $data = [
            'documentId' => '1',
            'activityId' => '2',
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //--------------Send Put Edit document activity ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutEditDocumentActivity(ApiTester $I)
    {
        $this->userID = 5;
        $data = [
            'documentId' => '2',
            'activityId' => '2',
        ];
        $I->sendPUT($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(201);
    }

    //--------------Send Get Listing of document activities ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfDocumentActivities(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //--------------Send Get Show document activity By ID ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowDocumentActivityByID(ApiTester $I)
    {
        $this->userID = 5;
        $I->sendGET($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(200);
    }

    //--------------Send Delete document activity By ID ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteDocumentActivityByID(ApiTester $I)
    {
        $this->userID = 6;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }



















}
