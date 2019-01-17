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

    public function _before(ApiTester $I)
    {
    }

    //-------------- Send Post Create new host ---------------//
    public function sendPostCreateNewHost(ApiTester $I)
    {
        $data = [
            "userId" => fake::create()->randomNumber(2),
            "addressId" => "12",
            "name" => "Some name",
            "description" => fake::create()->text(25)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //-------------- Send Post Create new host By ID -------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewHostByID(ApiTester $I)
    {
        $data = [
            'status' => 'New',
            'reviewId' => fake::create()->randomNumber(2,true),
            'reviewState' => 1,
            'userId' =>  fake::create()->randomNumber(2,true),
            'addressId' => 12,
            'name' => 'Some name',
            'description' => fake::create()->text(25)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //-------------  Send Put Modify hosts By ID -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyHostByID(ApiTester $I)
    {
        $this->userID = 11;
        $data = [
            'status' => fake::create()->text(10),
            'reviewId' => fake::create()->randomNumber(2,true),
            'reviewState' => 1,
            'addressId' => 12,
            'name' => 'Some name',
            'description' => fake::create()->text(25)
        ];
        $I->sendPUT($this->route.'/'.$this->userID, $data);
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
        $this->userID = 11;
        $I->sendGET($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(200);
    }

    //--------------- Send Delete host By ID ----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteHostByID(ApiTester $I)
    {
        $this->userID = 2;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }






















}
