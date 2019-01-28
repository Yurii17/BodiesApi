<?php

use Faker\Factory as fake;

class feedbacksCest
{
    public $route = '/feedbacks';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/feedbacks'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com", "8_yry7p>+-[fWg^.");
    }

    //-------------- Send Get Listing of feedBacks -------------------//
    public function sendGetListingOfFeedBacks(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Post Create New FeedBacks -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostCreateNewFeedBacks(ApiTester $I)
    {
        $data = [
            'entityClass' => 'host',
            'entityId' => fake::create()->randomNumber(2, true),
            'title' => 'Host',
            'message' => fake::create()->text(20)
        ];
        $I->saveFeedbacks([
            $data['entityClass'], ' ',
            $data['entityId'], ' ',
            $data['title'], ' ',
            $data['message'], ' '
        ], 'feedbacks.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //-------------- Send Put Modify Feedbacks By ID --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyFeedbacksById(ApiTester $I)
    {
        $data = [
            'entityClass' => 'host',
            'entityId' => fake::create()->randomNumber(2, true),
            'title' => fake::create()->text(20),
            'message' => fake::create()->text(20)
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //---------------- Send Get Show Feedbacks By ID --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowFeedbacksById(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Delete Feedbacks By ID -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteFeedbacksByID(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }

    //-------------- Send Post Create New Feedbacks UserId Error -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewFeedbacksUserIdError(ApiTester $I)
    {
        $data = [
            'userId' => 'id'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'userId',
            'message' => 'User ID must be an integer.'
        ]);
    }

    //-------------- Send Post Create New Feedbacks UserId Characters Error -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewFeedbacksUserIdCharactersError(ApiTester $I)
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

    //-------------- Send Post Create New Feedbacks Title Error -------------------//
    public function sendPostCreateNewFeedbacksTitleError(ApiTester $I)
    {
        $data = [
            'entityClass' => 'host',
            'entityId' => fake::create()->randomNumber(2, true),
            'title' => fake::create()->text(500),
            'message' => fake::create()->text(20)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'title',
            'message' => 'Title should contain at most 255 characters.'
        ]);
    }






}
