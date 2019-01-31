<?php

use Faker\Factory as fake;

class amenitiesCest
{

    public $route = '/amenities';
    public $userID;
    public $token;

    private function setRoute($params)
    {
        return $this->route = '/amenities'.$params;
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

    //---------------- Listing of amenities ----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfAmenities(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //---------------- Show amenity by ID ----------------------//
    /**
    * @param ApiTester $I
    * @before signInByPassword
    */
    public function sendGetShowAmenityByID(ApiTester $I)
    {
        $this->userID = 1;
        $data =[
            "id" => 1,
            "createdAt" => "2019-01-15 18:46:06",
            "modifiedAt" => "2019-01-15 18:46:06",
            "expireAt" => null,
            "status" => null,
            "code" => "FWF",
            "name" => "Free wifi"
        ];
        $I->sendGET($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //---------------- Send Post Create new amenity Valid ----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostCreateNewAmenityValid(ApiTester $I)
    {
        $data = [
            'id' => '1',
            'createdAt' => '2019-01-14',
            'modifiedAt' => '2019-01-19',
            'expireAt' => null,
            'status' => null,
            'code' => 'FWF',
            'name' => fake::create()->text(20),
        ];
        $I->saveUserAddress([
            $data['id'], ' ',
            $data['createdAt'], ' ',
            $data['modifiedAt'], ' ',
            $data['expireAt'], ' ',
            $data['status'], ' ',
            $data['code'], ' ',
            $data['name'], ' '
        ], 'userAmenities.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $this->token = $I->grabDataFromResponseByJsonPath('$.token');
        $I->seeResponseCodeIs(201);
    }

    //---------------- Send Put Modify amenity by ID ----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyAmenity(ApiTester $I)
    {
        $data = [
            "code" => "FWF",
            "name" => fake::create()->text(20),
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //------------------- Send Delete amenity --------------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteAmenityById(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }

    //---------------- Send Post Create Fake Status Amenity Error ----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateFakeStatusAmenityError(ApiTester $I)
    {
        $data = [
            'status' => fake::create()->text(20)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'status',
            'message' => 'Status should contain at most 8 characters.'
        ]);
    }

    //---------------- Send Post Create Fake Code Amenity Error ----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateFakeCodeAmenityError(ApiTester $I)
    {
        $data = [
            'code' => fake::create()->text(20)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'code',
            'message' => 'Code should contain at most 10 characters.'
        ]);
    }

















}
