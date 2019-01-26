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

    //--------------- Send Post Add New Coach Settings -----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostAddNewCoachSettings(ApiTester $I)
    {
        $data = [
            'gender' => 'male',
            'age' => '30to49',
            'minRating' => 3,
            'minReviews' => fake::create()->randomNumber(1, true),
            'userId' => 1
        ];
        $I->saveCoachSettings([
            $data['gender'], ' ',
            $data['age'], ' ',
            $data['minRating'], ' ',
            $data['minReviews'], ' ',
            $data['userId'], ' '
        ], 'coachSettings');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //--------------- Send Post Add New Coach Settings Error -----------------------//
    public function sendPostAddNewCoachSettingsError(ApiTester $I)
    {
        $data = [

        ];
        $I->sendPOST($this->route, $data);
        $I->seeForbiddenErrorMessage([]);
    }

    //--------------- Send Post Add New Coach Settings Empty Error --------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostAddNewCoachSettingsEmptyError(ApiTester $I)
    {
        $data = [

        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([[
            'field' => 'gender',
            'message' => 'Gender cannot be blank.'], [
            'field' => 'age',
            'message' => 'Age cannot be blank.']
        ]);
    }

    //----------------- Send Put Edit Coach Settings By ID --------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutEditCoachSettingsById(ApiTester $I)
    {
        $data = [
            'gender' => 'male',
            'age' => '30to49',
            'minRating' => 3,
            'minReviews' => 5
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //---------------- Send Get Show Coach Settings By ID ---------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowCoachSettingsById(ApiTester $I)
    {
        $data = [
            'gender' => 'male',
            'age' => '30to49',
            'minRating' => 3,
            'minReviews' => 5,
            'userId' => 1
        ];
        $I->sendGET($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //---------------- Send Get Listing of coaches settings ---------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingCoachesSettings(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //------------ Send Delete Coach Settings By Id --------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteCoachesSettings(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }















}
