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

    //------------- Send Get Listing of equipments --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfEquipments(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Post Create new equipment -------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     * @before signInByPassword
     */
    public function sendPostCreateNewEquipment(ApiTester $I)
    {
        $data = [
            'id' => '1',
            'code' => 'TV',
            'name' => fake::create()->text(20),
            'createdAt' => '2019',
            'modifiedAt' => '2019',
            'expireAt' => '01',
            'status' => 'active'
        ];
        $I->saveEquipments([
            $data['id'], ' ',
            $data['code'], ' ',
            $data['name'], ' ',
            $data['createdAt'], ' ',
            $data['modifiedAt'], ' ',
            $data['expireAt'], ' ',
            $data['status'], ' '
        ], 'equipments.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //------------- Send Get Show equipment BY ID --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowEquipmentByID(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Put Modify equipment By ID -------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPutModifyEquipmentByID(ApiTester $I)
    {
        $data = [
            'id' => '1',
            'code' => fake::create()->text(10),
            'name' => fake::create()->text(20),
            'createdAt' => '2019',
            'modifiedAt' => '2019',
            'expireAt' => '01',
            'status' => 'active'
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Delete equipment By ID -------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteEquipmentByID(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }

    //-------------- Send Post Create new equipment Empty Valid -------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewEquipmentEmptyValid(ApiTester $I)
    {
        $data = [
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
    }

    //-------------- Send Post Create new equipment Name Error -------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewEquipmentNameError(ApiTester $I)
    {
        $data = [
            'code' => 'TV',
            'name' => fake::create()->text(100),
            'createdAt' => '2019',
            'modifiedAt' => '2019',
            'expireAt' => '01',
            'status' => 'active'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'name',
            'message' => 'Name should contain at most 32 characters.'
        ]);
    }

    //-------------- Send Post Create new equipment Code Error -------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewEquipmentCodeError(ApiTester $I)
    {
        $data = [
            'code' => fake::create()->text(50)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'code',
            'message' => 'Code should contain at most 10 characters.'
        ]);
    }

    //-------------- Send Post Create new equipment Status Error -------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewEquipmentStatusError(ApiTester $I)
    {
        $data = [
            'status' => fake::create()->text(50)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'status',
            'message' => 'Status should contain at most 8 characters.'
        ]);
    }



















}
