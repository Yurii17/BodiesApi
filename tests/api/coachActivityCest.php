<?php

use Faker\Factory as fake;

class coachActivityCest
{
    public $route = '/coachActivities';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/coachActivities'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com", "8_yry7p>+-[fWg^.");
    }

    //----------------- Send Post Assign Activity to coach -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostAssignActivityToCoach(ApiTester $I)
    {
        $data = [
            'coachId' => fake::create()->randomNumber(2, true),
            'activityId' => 1,
            'certificateId' => 1,
            'availableTo' => '2019-11-30',
            'status' => 'Active'
        ];
        $I->saveCoachActivity([
            $data['activityId'], ' ',
            $data['coachId'], ' ',
            $data['certificateId'], ' ',
            $data['availableTo'], ' ',
            $data['status'], ' '
        ], 'coachActivity.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //----------------- Send Post Assign Activity to Coach Error -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostAssignActivityToCoachError(ApiTester $I)
    {
        $data = [
            'coachId' => fake::create()->randomNumber(2, true),
            'activityId' => 1,
            'certificateId' => '1q',
            'availableTo' => '2019qqq-11-301',
            'status' => 'Active'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'certificateId',
            'message' => 'Certificate ID must be an integer.'
        ]);
    }

    //----------------- Send Post Assign Activity to Coach Fake Error -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostAssignActivityToCoachFakeError(ApiTester $I)
    {
        $data = [
            'coachId' => fake::create()->text(10),
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([[
            'field' => 'coachId',
            'message' => 'Coach ID must be an integer.'], [
                'field' => 'activityId',
                'message' => 'Activity ID cannot be blank.']
        ]);
    }

    //----------------- Send Post Assign Activity to Coach Null Error -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostAssignActivityToCoachNullError(ApiTester $I)
    {
        $data = [
            'coachId' => null,
            'activityId' => null
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([[
            'field' => 'coachId',
            'message' => 'Coach ID cannot be blank.'], [
            'field' => 'activityId',
            'message' => 'Activity ID cannot be blank.']
        ]);
    }

    //-------------------- Send Get Show coach activity -----------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowCoachActivity(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Get Show of coach activities Forbidden Error ------------------//
    public function sendGetListingOfCoachActivitiesForbiddenError(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeForbiddenErrorMessage([]);
    }

    //------------------ Send Put Modify Coach Activity By Id ----------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyCoachActivityById(ApiTester $I)
    {
        $data = [
            'coachId' => fake::create()->randomNumber(2, true),
            'activityId' => 1,
            'certificateId' => 1,
            'availableTo' => '2019-12-01',
            'status' => 'Active'
        ];
        $I->sendPUT($this->route.'/'. $this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //-------------  Send Get Show Modify Coach Activity By Id ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowModifyCoachActivityById(ApiTester $I)
    {
        $data = [
            'activityId' => 1,
            'certificateId' => 1,
            'availableTo' => '2019-12-01',
            'status' => 'Active'
        ];
        $I->sendGET($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Delete Coach Activity By ID ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteCoachActivityById(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'. $this->userID[0]);
        $I->seeResponseCodeIs(204);
    }









}
