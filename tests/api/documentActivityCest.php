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

    //--------------  Send Post Add New Document Activity  ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostAddNewDocumentActivity(ApiTester $I)
    {
        $data = [
            'documentId' => '1',
            'activityId' => '2',
            'userId' => 1
        ];
        $I->saveDocumentActivity([
            $data['documentId'], ' ',
            $data['activityId'], ' '
        ], 'documentActivity');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //--------------Send Put Edit document activity ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutEditDocumentActivity(ApiTester $I)
    {
        $data = [
            'documentId' => '11',
            'activityId' => '25',
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //--------------  Send Get Listing of document activities ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfDocumentActivities(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //--------------  Send Get Show document activity By ID ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowDocumentActivityByID(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //--------------  Send Delete document activity By ID ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteDocumentActivityByID(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }

    //--------------  Send Post Add New Document Activity Error ----------------//
    public function sendPostAddNewDocumentActivityError(ApiTester $I)
    {
        $data = [
            'documentId' => '1',
            'activityId' => '2',
            'userId' => 1
        ];
        $I->sendPOST($this->route, $data);
        $I->seeForbiddenErrorMessage([]);
    }



















}
