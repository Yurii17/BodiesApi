<?php

use Faker\Factory as fake;

class notificationsCest
{
    public $route = '/notifications';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/notifications'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com", "8_yry7p>+-[fWg^.");
    }

    //-------------- Send Post Create New Notifications  --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewNotifications(ApiTester $I)
    {
        $data = [
            'entityClass' => 'host',
            'entityId' => 10,
            'category' => 'info',
            'message' =>  fake::create()->text(20)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }


    //-------------- Send Put Modify Notifications BY ID --------------------//
    public function sendPutModifyNotificationByID(ApiTester $I)
    {
        $this->userID = 1;
        $data = [
            'entityClass' => 'host',
            'entityId' => fake::create()->randomNumber(2),
            'category' => 'info',
            'message' =>  fake::create()->text(20)
        ];
        $I->sendPUT($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }


    //-------------- Send Get Listing of Notifications --------------------//
    public function sendGetListingOfNotifications(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }


    //-------------- Send Get Show of Notifications By ID --------------------//
    public function sendGetShowOfNotificationsByID(ApiTester $I)
    {
        $this->userID = 1;
        $I->sendGET($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Delete Notifications By ID --------------------//
    public function sendDeleteNotificationsByID(ApiTester $I)
    {
        $this->userID = 2;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }



}
