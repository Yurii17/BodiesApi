<?php

use Faker\Factory as fake;

class coachSettingsCest
{
    public $route = '/coachSettings';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/coachSettings'.$params;
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


    //--------------- Send Post Add new coach settings -----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostAddNewCoachSettings(ApiTester $I)
    {
        $data = [
            'gender' => 'male',
            'age' => '30to49',
            'minRating' => 3,
            'minReviews' => fake::create()->randomNumber(1, true)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //----------------- Send Put Edit coach settings By ID --------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutEditCoachSettingsById(ApiTester $I)
    {
        $this->userID = 5;
        $data = [
            'gender' => 'male',
            'age' => '30to49',
            'minRating' => 3,
            'minReviews' => 5
        ];
        $I->sendPUT($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //---------------- Send Get Show coach settings By ID ---------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowCoachSettingsById(ApiTester $I)
    {
        $this->userID = 5;
        $data = [
            'gender' => 'male',
            'age' => '30to49',
            'minRating' => 3,
            'minReviews' => 5
        ];
        $I->sendGET($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //---------------- Send Get Listing of coaches settings ---------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingCoachesSettings(ApiTester $I)
    {
        $this->userID = 5;
        $I->sendGET($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(200);
    }


    //------------ Send Delete Coach Settings --------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteCoachesSettings(ApiTester $I)
    {
        $this->userID = 10;
        $I->sendGET($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(200);
    }






}
