<?php

use Faker\Factory as fake;

class spaceAmenityCest
{
    public $route = '/spaceAmenity';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/spaceAmenity'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com", "8_yry7p>+-[fWg^.");
    }

    //----------------- Send Post Create New SpaceAmenity -----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewSpaceAmenity(ApiTester $I)
    {
        $data = [
            'spaceId' => 1,
            'amenityId' => 2
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //----------------- Send Put Modify SpaceAmenity BY ID -----------------------//
    public function sendPutModifySpaceAmenityByID(ApiTester $I)
    {
        $this->userID = 1;
        $data = [
            'spaceId' => 1,
            'amenityId' => 2
        ];
        $I->sendPUT($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //----------------- Send Get Show SpaceAmenity -----------------------//
    public function sendGetShowSpaceAmenity(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //----------------- Send Delete SpaceAmenity By ID -----------------------//
    public function sendDeleteSpaceAmenityById(ApiTester $I)
    {
        $this->userID = 1;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }

    

}
