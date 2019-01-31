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
        $I->loginAs('yurii.lobas+0badbae683b2c6ff5a14bfe90dcfef6d@gmail.com', '6bfAC<kkThESw2');
    }

    //-------------- Send Post Create New Notifications  --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostCreateNewNotifications(ApiTester $I)
    {
        $data = [
            'entityClass' => 'user',
            'entityId' => 1,
            'category' => 'info',
            'message' =>  fake::create()->text(20),
            'userId' => 1
        ];
        $I->saveNotifications([
            $data['entityClass'], ' ',
            $data['entityId'], ' ',
            $data['category'], ' ',
            $data['message'], ' ',
            $data['userId'], ' '
        ], 'notifications.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //-------------- Send Put Modify Notifications BY ID --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyNotificationByID(ApiTester $I)
    {
        $data = [
            'entityClass' => 'host',
            'entityId' => fake::create()->randomNumber(2),
            'category' => 'info',
            'message' =>  fake::create()->text(20)
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Get Listing of Notifications --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfNotifications(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Get Show of Notifications By ID --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowOfNotificationsByID(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Delete Notifications By ID --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteNotificationsByID(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }

    //-------------- Send Delete Notifications Forbidden Error --------------------//
    public function sendDeleteNotificationsForbiddenError(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeForbiddenErrorMessage([]);
    }

    //-------------- Send Post Create New Notifications Error --------------------//
    public function sendPostCreateNewNotificationsError(ApiTester $I)
    {
        $data = [
        ];
        $I->sendPOST($this->route, $data);
        $I->seeForbiddenErrorMessage([]);
    }

    //-------------- Send Post Create New Notifications Empty Error --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewNotificationsEmptyError(ApiTester $I)
    {
        $data = [
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([[
            'field' => 'userId',
            'message' => 'User ID cannot be blank.'], [
            'field' => 'entityId',
            'message' => 'Entity ID cannot be blank.'
        ]]);
    }

    //-------------- Send Post Create New Notifications UserId Error --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewNotificationsUserIdError(ApiTester $I)
    {
        $data = [
            'userId' => '@'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'userId',
            'message' => 'User ID must be an integer.'
        ]);
    }

    //-------------- Send Post Create New Notifications EntityId Error --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewNotificationsEntityIdError(ApiTester $I)
    {
        $data = [
            'entityId' => '@'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'entityId',
            'message' => 'Entity ID must be an integer.'
        ]);
    }

    //-------------- Send Post Create New Notifications Fake Error --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewNotificationsFakeError(ApiTester $I)
    {
        $data = [
            'entityId' => fake::create()->text(10),
            'userId' => fake::create()->text(10)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([[
            'field' => 'entityId',
            'message' => 'Entity ID must be an integer.'], [
            'field' => 'userId',
            'message' => 'User ID must be an integer.'
        ]]);
    }






}
