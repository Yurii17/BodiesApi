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

    //------------- Send Post Add New Document  -------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
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
        $I->saveDocuments([
            $data['name'], ' ',
            $data['file'], ' ',
            $data['startDate'], ' ',
            $data['expDate'], ' ',
            $data['provider'], ' ',
            $data['number'], ' ',
            $data['contactName'], ' ',
            $data['contactPhone'], ' ',
            $data['contactEmail'], ' ',
            $data['type'], ' ',
            $data['isComAccredited'], ' ',
            $data['createdAt'], ' ',
            $data['modifiedAt'], ' '
        ],'documents.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //------------- Send Put Edit document By ID----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutEditDocumentByID(ApiTester $I)
    {
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
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Show documents By ID ----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowDocumentsByID(ApiTester $I)
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
        $I->sendGET($this->route.'/'.$this->userID[0], $data);
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
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }

    //------------- Send Post Add New Document Error -------------------//
    public function sendPostAddNewDocumentError(ApiTester $I)
    {
        $data = [
        ];
        $I->sendPOST($this->route, $data);
        $I->seeForbiddenErrorMessage([]);
    }

    //------------- Send Post Add New Document Name Error -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostAddNewDocumentNameError(ApiTester $I)
    {
        $data = [
            'name' => fake::create()->randomDigit,
            'file' => '1',
            'startDate' => '2018-12-24',
            'expDate' => fake::create()->date()
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([[
            'field' => 'number',
            'message' => 'Number cannot be blank.'], [
            'field' => 'contactEmail',
            'message' => 'Contact Email cannot be blank.'], [
            'field' => 'type',
            'message' => 'Type cannot be blank.'
        ]]);
    }





















}
