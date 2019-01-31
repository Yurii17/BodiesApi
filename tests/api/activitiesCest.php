<?php

use Faker\Factory as fake;

class activitiesCest
{
    public $route = '/activities';
    public $userID;
    public $token;

    private function setRoute($params)
    {
        return $this->route = '/activities'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs('yurii.lobas+7336885c314290434c04d4bd3d5fbc54@gmail.com', '!pass76934');
    }

    //------------ Send Get Listing of Activities   -----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfActivities(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //------------ Send Post Create New Activity  ------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostCreateNewActivities(ApiTester $I)
    {
        $data = [
            'name' => 'Yoga',
            'code' => 'YO',
            'status' => '1',
            'shortDesc' => 'Yoga is a group of physical, mental, and spiritual practices',
            'fullDesc' => fake::create()->text(10),
            'isCertRequired' => 1
        ];
        $I->saveActivities([
            $data['name'], ' ',
            $data['code'], ' ',
            $data['status'], ' ',
            $data['shortDesc'], ' ',
            $data['fullDesc'], ' ',
            $data['isCertRequired'], ' '
        ], 'activities.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $this->token = $I->grabDataFromResponseByJsonPath('$.token');
        $I->seeResponseCodeIs(201);
    }

    //----------------- Send Post Create Empty Field Activities Error ---------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateEmptyFieldActivitiesError(ApiTester $I)
    {
        $data = [
            'name' => 'Yoga',
            'code' => 'YO',
            'status' => '1',
            'shortDesc' => 'Yoga is a group of physical, mental, and spiritual practices',
            'fullDesc' => fake::create()->text(10),
            'isCertRequired' => ' '
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'isCertRequired',
            'message' => 'Is Cert Required must be an integer.'
        ]);
    }

    //----------------- Send Post Activities Max Nb Chars Error ---------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostActivitiesMaxCharsError(ApiTester $I)
    {
        $data = [
            'name' => 'Yoga',
            'code' => 'YO',
            'status' => '1',
            'shortDesc' => fake::create()->text(1000),
            'fullDesc' => fake::create()->text(10),
            'isCertRequired' => '1'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'shortDesc',
            'message' => 'Short Desc should contain at most 500 characters.'
        ]);
    }

    //----------------- Send Post Activities Cert Required Error ---------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostActivitiesCertRequiredError(ApiTester $I)
    {
        $data = [
            'name' => 'Yoga',
            'code' => 'YO',
            'status' => '1',
            'shortDesc' => fake::create()->text(10),
            'fullDesc' => fake::create()->text(10),
            'isCertRequired' => fake::create()->text(10)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'isCertRequired',
            'message' => 'Is Cert Required must be an integer.'
        ]);
    }

    //-------------- Send Get Show activity by ID -------------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     * @before signInByPassword
     */
    public function sendGetShowActivities(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Put Modify activity by ID -------------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     * @before signInByPassword
     */
    public function sendPutModifyActivitiesById(ApiTester $I)
    {
        $data = [
            'name' => 'Yoga',
            'code' => 'YO',
            "shortDesc" => fake::create()->text(20),
            "fullDesc" => fake::create()->text(20),
            'isCertRequired' => '1'
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //------------ Send Delete Activities By ID -------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteActivitiesByID(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }














}
