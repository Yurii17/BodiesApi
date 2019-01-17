<?php

use Faker\Factory as fake;

class messagesCest
{
    public $route = '/messages';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/messages'.$params;
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

    //------------- Send Post Create New Messages ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewMessages(ApiTester $I)
    {
        $data = [
            'senderId' => '1',
            'recipientId' => '2',
            'subject' => 'Some subject',
            'category' => 'info',
            'message' => fake::create()->text(20),
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //------------- Send Put Modify Messages BY ID ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyMessagesById(ApiTester $I)
    {
        $this->userID = 1;
        $data = [
            'senderId' => '1',
            'recipientId' => '2',
            'subject' => fake::create()->text(20),
            'category' => 'info',
            'message' => fake::create()->text(20),
        ];
        $I->sendPUT($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Show Messages By ID ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowMessagesByID(ApiTester $I)
    {
        $this->userID = 1;
        $I->sendGET($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Delete Messages By ID ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteMessagesByID(ApiTester $I)
    {
        $this->userID = 1;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }




    





}
