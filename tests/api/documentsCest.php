<?php

use Faker\Factory as fake;

class documentsCest
{
    public $route = '/documents';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/documents'.$params;
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

    //------------- Send Post Add New Document----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostAddNewDocument(ApiTester $I)
    {
        $data = [
            'name' => 'New Cert',
            'file' => '1',
            'startDate' => '2018-12-24',
            'expDate' => '2019-12-22',
            'provider' => 'Cert Provider',
            'number' => '1111-345345-ID',
            'contactName' => 'John Doe',
            'contactPhone' => '5555555555',
            'contactEmail' => 'john@doe.com',
            'type' => 'insurance',
            'isComAccredited' => '1',
            'createdAt' => '2018-12-18 08:49:11',
            'modifiedAt' => '2018-12-18 08:49:11'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //------------- Send Put Edit document By ID----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutEditDocumentByID(ApiTester $I)
    {
        $this->userID = 3;
        $data = [
            'name' => 'New Cert',
            'file' => '1',
            'startDate' => '2018-12-24',
            'expDate' => fake::create()->date(), //'2019-12-22',
            'provider' => 'Cert Provider',
            'number' => '1111-345345-ID',
            'contactName' => 'John Doe',
            'contactPhone' => '5555555555',
            'contactEmail' => 'john@'.fake::create()->md5.'doe.com',
            'type' => 'insurance',
            'isComAccredited' => '1',
            'createdAt' => '2018-12-18 08:49:11',
            'modifiedAt' => '2018-12-18 08:49:11'
        ];
        $I->sendPUT($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Show documents By ID ----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowDocumentsByID(ApiTester $I)
    {
        $this->userID = 8;
        $data = [
            'name' => 'New Cert',
            'file' => '1',
            'startDate' => '2018-12-24',
            'expDate' => '2019-12-22',
            'provider' => 'Cert Provider',
            'number' => '1111-345345-ID',
            'contactName' => 'John Doe',
            'contactPhone' => '5555555555',
            'contactEmail' => 'john@doe.com',
            'type' => 'insurance',
            'isComAccredited' => '1',
            'createdAt' => '2018-12-18 08:49:11',
            'modifiedAt' => '2018-12-18 08:49:11'
        ];
        $I->sendGET($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }


    //------------- Send Get Listing of documents ----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfDocuments(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Delete document By ID ----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteDeleteDocumentByID(ApiTester $I)
    {
        $this->userID = 3;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }

























}
