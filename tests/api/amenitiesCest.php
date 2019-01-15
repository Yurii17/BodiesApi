<?php

use Faker\Factory as fake;

class amenitiesCest
{

    public $route = '/amenities';
    public $userID;

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

    //---------------- Create new amenity ----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewAmenity(ApiTester $I)
    {
        $data = [
            "code" => "FWF",
            "name" => fake::create()->text(20),
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //---------------- Modify amenity by ID ----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyAmenity(ApiTester $I)
    {
        $this->userID = 2;
        $data = [
            "code" => "FWF",
            "name" => fake::create()->text(20),
        ];
        $I->sendPUT($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //------------------- Delete amenity --------------------------//

    public function sendDeleteAmenityById(ApiTester $I)
    {
        $this->userID = 4;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }













}
