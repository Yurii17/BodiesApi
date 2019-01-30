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
     * @throws Exception
     */
    public function sendPostCreateNewSpaceAmenity(ApiTester $I)
    {
        $data = [
            'spaceId' => 68,
            'amenityId' => 2
        ];
        $I->saveSpaceAmenity([
            $data['spaceId'], ' ',
            $data['amenityId'], ' '
        ],'spaceAmenity.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //----------------- Send Put Modify SpaceAmenity BY ID -----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifySpaceAmenityByID(ApiTester $I)
    {
        $data = [
            'spaceId' => 2,
            'amenityId' => 2
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //----------------- Send Get Show SpaceAmenity -----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowSpaceAmenity(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //----------------- Send Delete SpaceAmenity By ID -----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteSpaceAmenityById(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }



}
