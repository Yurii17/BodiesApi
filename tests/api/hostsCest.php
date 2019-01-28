<?php

use Faker\Factory as fake;

class hostsCest
{
    public $route = '/hosts';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/hosts'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com", "8_yry7p>+-[fWg^.");
    }

    //-------------- Send Post Create new host By Id ---------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostCreateNewHost(ApiTester $I)
    {
        $data = [
            "userId" => fake::create()->randomNumber(2),
            "addressId" => "12",
            "name" => "Some name",
            "description" => fake::create()->text(25)
        ];
        $I->saveHosts([
            $data['userId'], ' ',
            $data['addressId'], ' ',
            $data['name'], ' ',
            $data['description'], ' '
        ], 'hosts.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //-------------  Send Put Modify hosts By ID -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyHostByID(ApiTester $I)
    {
        $data = [
            'status' => fake::create()->text(10),
            'reviewId' => 1,
            'reviewState' => 1,
            'addressId' => 12,
            'name' => 'TEST',
            'description' => fake::create()->text(25)
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //--------------- Send Get Listing of hosts ----------------------//
    public function sendGetListingOfHosts(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //--------------- Send Get Show host By ID ----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowHostByID(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //--------------- Send Delete host By ID ----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteHostByID(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }

    //-------------- Send Post Create new host Error  -------//
    public function sendPostCreateNewHostError(ApiTester $I)
    {
        $data = [
            'status' => 'New',
            'reviewId' => fake::create()->randomNumber(2,true),
            'reviewState' => 1,
            'addressId' => 12,
            'name' => 'Some name',
            'description' => fake::create()->text(25)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'userId',
            'message' => 'User ID cannot be blank.'
        ]);
    }

    //-------------- Send Post Create new host Empty Error  -------//
    public function sendPostCreateNewHostEmptyError(ApiTester $I)
    {
        $data = [
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'userId',
            'message' => 'User ID cannot be blank.'
        ]);
    }



















}
