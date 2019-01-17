<?php 

class reviewsCest
{
    public $route = '/reviews';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/reviews'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com", "8_yry7p>+-[fWg^.");
    }

    //------------- Send Get Index -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetIndex(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Show By ID -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowByID(ApiTester $I)
    {
        $this->userID = 1;
        $I->sendGET($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Post Create -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreate(ApiTester $I)
    {
        $I->sendPOST($this->route);
        $I->seeResponseCodeIs(201);
    }

    //------------- Send Put Modify BY ID -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendSendPutModifyById(ApiTester $I)
    {
        $this->userID = 1;
        $I->sendPUT($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Delete By ID -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteByID(ApiTester $I)
    {
        $this->userID = 2;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }






















}
