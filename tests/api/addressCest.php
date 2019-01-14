<?php

use Faker\Factory as fake;

class addressCest
{
    public $route = '/addresses';

    private function setRoute($params)
    {
        return $this->route = '/addresses'.$params;
    }

    public function _before(ApiTester $I)
    {
    }


    ///---------------Listing of addresses-------------------//
    public function sendGetListingOfAddress(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //----------------Create new address-----------------------//

    public function sendPostCreateNewAddress(ApiTester $I)
    {
        $I->sendPOST('/addresses', [
            "name" => "First Address",
            "address1" => "Madison Ave 2534",
            "address2" => "Madison Ave 365",
            "postalCode" => fake::create()->randomNumber(6,true),
            "city" => "Union City",
            "state" => "CA",
            "lat" => "37.60169400",
            "lon" => "-122.06193000"
        ]);
        $I->seeResponseCodeIs(201);
    }

    //----------------Show address--------------------//

    public function sendGetShowAddress(ApiTester $I)
    {
        $this->userID = 5;
        $this->setRoute('/'.$this->userID);

        $data = [
            "id" => 5,
            "createdAt" => "2018-12-10 14:16:10",
            "modifiedAt" => "2018-12-10 14:16:10",
            "expireAt" => null,
            "status" => null,
            "reviewId" => null,
            "reviewState" => null,
            "postalCode" => "94587",
            "city" => "Union City",
            "state" => "CA",
            "lat" => "37.60169400",
            "lon" => "-122.06193000",
            "userId" => null,
            "address1" => "Madison Ave 2534",
            "address2" => "Madison Ave 365",
            "name" => "First Address"
        ];
        $I->sendGET($this->route, $data);
        $I->seeResponseCodeIs(200);
    }

    //-----------------Modify Address---------------------//

    public function sendPutModifyAddress(ApiTester $I)
    {
        $this->userID = 8;
        $this->setRoute('/'.$this->userID);

        $data = [
            "name" => "First Address",
            "address1" => fake::create()->address,
            "address2" => "Madison Ave 365",
            "postalCode" => fake::create()->randomNumber(6,true),
            "city" => "Union City",
            "state" => "CA",
            "lat" => "37.60169400",
            "lon" => "-122.06193000"
        ];
        $I->sendPUT($this->route, $data);
        $I->seeResponseCodeIs(200);
    }

    //-----------------Delete Address-------------------//

    public function sendDeleteAddress(ApiTester $I)
    {
        $this->userID = 187;
        $this->setRoute('/'.$this->userID);
        $I->sendDELETE($this->route);
        $I->seeResponseCodeIs(204);
    }

    //-----------------Check Address-------------------//

    public function sendGetCheckAddress(ApiTester $I)
    {
        $data = [
            'zip' => '94587'
        ];
        $I->sendGET('/addresses/check', $data);
        $I->seeResponseCodeIs(200);
    }

    public function sendGetCheckAddressError(ApiTester $I)
    {
        $data = [
            'zip' => ''
        ];
        $I->sendGET('/addresses/check', $data);
        $I->seeResponseCodeIs(422);
    }

    //-----------Get city and state by first characters---------------//

    public function sendGetGetCityAndStateByFirstCharacters(ApiTester $I)
    {
        $I->sendGET('/addresses/city/Union');
        $I->seeResponseCodeIs(200);
    }

    public function sendGetGetCityAndStateByFirstCharactersError(ApiTester $I)
    {
        $I->sendGET('/addresses/city/Union City');
        $I->seeResponseCodeIs(404);
    }












}
