<?php

use Faker\Factory as fake;

class addressCest
{
    public $route = '/addresses';
    public $userID;
    public $token;

    private function setRoute($params)
    {
        return $this->route = '/addresses'.$params;
    }

    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com", "8_yry7p>+-[fWg^.");
    }


    ///---------------Listing of addresses-------------------//
    public function sendGetListingOfAddress(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //----------------Create new address-----------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendPostCreateNewAddress(ApiTester $I)
    {
        $data = [
            'name' => 'First Address',
            'address1' => 'Madison Ave 2534',
            'address2' => 'Madison Ave 365',
            'postalCode' => fake::create()->randomNumber(6,true),
            'city' => 'Union City',
            'state' => 'CA',
            'lat' => '37.60169400',
            'lon' => '-122.06193000',
            'status' => fake::create()->randomNumber(6,true),
            'reviewId' => '1',
            'reviewState' => fake::create()->randomNumber(6,true)
        ];
        $I->saveUserAddress([
            $data['name'], ' ',
            $data['address1'], ' ',
            $data['address2'], ' ',
            $data['postalCode'], ' ',
            $data['city'], ' ',
            $data['state'], ' ',
            $data['lat'], ' ',
            $data['lon'], ' ',
            $data['status'], ' ',
            $data['reviewId'], ' ',
            $data['reviewState'], ' '
        ], 'userAddress.txt');
        $I->sendPOST($this->route, $data);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $this->token = $I->grabDataFromResponseByJsonPath('$.token');
        $I->seeResponseCodeIs(201);
    }

    //------------- Send Get Show address By Id --------------------//

    public function sendGetShowAddressById(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //----------------- Send Put Modify Address By Id ---------------------//

    public function sendPutModifyAddress(ApiTester $I)
    {
        $data = [
            'createdAt' => '2018-12-10 14:16:10',
            'modifiedAt' => '2018-12-10 14:16:10',
            'expireAt' => null,
            'status' => null,
            'reviewId' => null,
            'reviewState' => null,
            'postalCode' => fake::create()->randomNumber(6,true),
            'city' => 'Union City',
            'state' => 'CA',
            'lat' => '37.60169400',
            'lon' => '-122.06193000',
            'userId' => null,
            'address1' => 'Madison Ave 2534',
            'address2' => 'Madison Ave 365',
            'name' => 'First Address'
        ];
        $I->sendPUT($this->route.'/'.$this->userID[0], $data);
        $I->seeResponseCodeIs(200);
    }

    //--------------Send Delete Address By ID-------------------//

    public function sendDeleteAddress(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }

    //-------------- Send Post Status Field Address Error----------------------------------//

    public function sendPostStatusFieldAddressError(ApiTester $I)
    {
        $data = [
            'name' => 'First Address',
            'address1' => 'Madison Ave 2534',
            'address2' => 'Madison Ave 365',
            'postalCode' => fake::create()->randomNumber(6,true),
            'city' => 'Union City',
            'state' => 'CA',
            'lat' => '37.60169400',
            'lon' => '-122.06193000',
            'status' => fake::create()->text(1000),
            'reviewId' => '1',
            'reviewState' => fake::create()->randomNumber(6,true)
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
                'field' => 'status',
                'message' => 'Status should contain at most 8 characters.'
        ]);
    }


    //------------- Send Get By Zip Address -------------------//

    public function sendGetZipAddressValid(ApiTester $I)
    {
        $I->sendGET($this->route.'/zip/94587');
        $I->seeResponseCodeIs(200);
    }

    public function sendGetFakeZipAddressError(ApiTester $I)
    {
        $I->sendGET($this->route.'/zip/'.fake::create()->text(10));
        $I->seeResponseCodeIs(404);
    }

    public function sendGetNullZipAddressError(ApiTester $I)
    {
        $I->sendGET($this->route.'/zip/');
        $I->seeResponseCodeIs(404);
    }

    //------------- Send Get By Check Address --------------------//
    public function sendGetCheckAddressValid(ApiTester $I)
    {
        $data = [
            'zip' => '94587'
        ];
        $I->sendGET($this->route.'/check', $data);
        $I->seeResponseCodeIs(200);
    }

    public function sendGetCheckAddressFakeZipError(ApiTester $I)
    {
        $data = [
            'zip' => fake::create()->text(10)
        ];
        $I->sendGET($this->route.'/check', $data);
        $I->seeErrorMessage([
            'name' => 'Unprocessable entity',
            'message' => 'Validation error'
        ]);
    }

    public function sendGetCheckAddressZipNullError(ApiTester $I)
    {
        $data = [
            'zip' => ' '
        ];
        $I->sendGET($this->route.'/check', $data);
        $I->seeErrorMessage([
            'name' => 'Unprocessable entity',
            'message' => 'Validation error'
        ]);
    }

    //-----------Send Get city and state by first characters---------------//

    public function sendGetStateByFirstCharactersValid(ApiTester $I)
    {
        $I->sendGET($this->route.'/city/California');
        $I->seeResponseCodeIs(200);
    }

    public function sendGetFakeStateByFirstCharactersError(ApiTester $I)
    {
        $I->sendGET($this->route.'/city/California'.fake::create()->text(10));
        $I->seeResponseCodeIs(404);
    }

    public function sendGetCityAndStateByFirstCharactersValid(ApiTester $I)
    {
        $I->sendGET($this->route.'/city/Union');
        $I->seeResponseCodeIs(200);
    }

    public function sendGetCityAndFakeStateByFirstCharactersError(ApiTester $I)
    {
        $I->sendGET($this->route.'/city/Union'.fake::create()->text(10));
        $I->seeResponseCodeIs(404);
    }

    public function sendGetCityAndNullStateByFirstCharactersError(ApiTester $I)
    {
        $I->sendGET($this->route.'/city/');
        $I->seeResponseCodeIs(404);
    }









}
