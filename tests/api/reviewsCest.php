<?php

use Faker\Factory as fake;

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

    //------------- Send Post Create Reviews -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostCreateReviews(ApiTester $I)
    {
        $data = [
            'entityId' => fake::create()->randomNumber(2),
            'entityClass' => 'host'
        ];
        $I->saveReviews([
            $data['entityId'], ' ',
            $data['entityClass'], ' '
        ], 'reviews.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //------------- Send Get Index Reviews -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetIndexReviews(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Show Reviews By ID -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowReviewsByID(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Put Modify Reviews BY ID -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendSendPutModifyReviewsById(ApiTester $I)
    {
        $data = [
            'entityId' => fake::create()->randomNumber(2),
            'entityClass' => 'host'
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Delete Reviews By ID -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteReviewsByID(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }

    //------------- Send Post Create Reviews Error ---------------//
    public function sendPostCreateReviewsError(ApiTester $I)
    {
        $data = [
        ];
        $I->sendPOST($this->route, $data);
        $I->seeForbiddenErrorMessage([]);
    }

    //------------- Send Post Create Reviews Empty Error ---------------//
    /**
    * @param ApiTester $I
    * @before signInByPassword
    */
    public function sendPostCreateReviewsEmptyError(ApiTester $I)
    {
        $data = [
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([]);
    }

    //------------- Send Post Create Reviews EntityId Error ---------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateReviewsEntityIdError(ApiTester $I)
    {
        $data = [
            'entityId' => '@'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([]);
    }

    //------------- Send Post Create Reviews EntityId Error ---------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateReviewsEntityClassError(ApiTester $I)
    {
        $data = [
            'entityClass' => '@'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([]);
    }















}
