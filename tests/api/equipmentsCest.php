<?php

use Faker\Factory as fake;

class equipmentsCest
{
    public $route = '/equipments';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/equipments'.$params;
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

    //------------- Send Get Listing of equipments --------------------//

    public function sendGetListingOfEquipments(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Show equipment BY ID --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowEquipmentByID(ApiTester $I)
    {
        $this->userID = 1;
        $I->sendGET($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Post Create new equipment -------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewEquipment(ApiTester $I)
    {
        $data = [
            'code' => 'TV',
            'name' => fake::create()->text(20)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //-------------- Send Put Modify equipment By ID -------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyEquipmentByID(ApiTester $I)
    {
        $this->userID = 1;
        $data = [
            'code' => 'TV',
            'name' => fake::create()->text(20)
        ];
        $I->sendGET($this->route.'/'.$this->userID, $data);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Delete equipment -------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteEquipmentByID(ApiTester $I)
    {
        $this->userID = 2;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }



























}
