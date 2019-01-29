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

    //------------- Send Post Create New Messages ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostCreateNewMessagesValid(ApiTester $I)
    {
        $data = [
            'senderId' => '1',
            'recipientId' => '2',
            'subject' => 'Some subject',
            'category' => 'info',
            'message' => fake::create()->text(20),
        ];
        $I->saveMessages([
            $data['senderId'], ' ',
            $data['recipientId'], ' ',
            $data['subject'], ' ',
            $data['category'], ' ',
            $data['message'], ' '
        ], 'messages.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //------------- Send Put Modify Messages BY ID ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyMessagesById(ApiTester $I)
    {
        $data = [
            'senderId' => '1',
            'recipientId' => '2',
            'subject' => fake::create()->text(20),
            'category' => 'info',
            'message' => fake::create()->text(20),
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Show Messages By ID ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowMessagesByID(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Delete Messages By ID ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteMessagesByID(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }










}
