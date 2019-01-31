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
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs('yurii.lobas+7336885c314290434c04d4bd3d5fbc54@gmail.com', '!pass76934');
    }

    //------------- Send Get Listing of Addresses  -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendGetListingOfAddress(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //------------  Send Post Create New Address  --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
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

    //------------  Send Post Create New Address Forbidden Error --------------------//
    public function sendPostCreateNewAddressForbiddenError(ApiTester $I)
    {
        $data = [
        ];
        $I->sendPOST($this->route, $data);
        $I->seeForbiddenErrorMessage([]);
    }

    //------------  Send Post Create New Address Null Data Error --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostCreateNewAddressNullDataError(ApiTester $I)
    {
        $data = [
            'name' => ' ',
            'address1' => ' ',
            'address2' => ' ',
            'postalCode' => ' ',
            'city' => ' ',
            'state' => ' ',
            'lat' => ' ',
            'lon' => ' ',
            'status' => ' ',
            'reviewId' => ' ',
            'reviewState' => ' '
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([]);
    }

    //------------- Send Get Show address By Id --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowAddressById(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(200);
    }

    //----------------- Send Put Modify Address By Id ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
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

    //--------------  Send Delete Address By ID  -------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteAddress(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }

    //-------------- Send Post Status Field Address Error  ----------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
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
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetZipAddressValid(ApiTester $I)
    {
        $I->sendGET($this->route.'/zip/94587');
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Fake Zip Address Error  -------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetFakeZipAddressError(ApiTester $I)
    {
        $I->sendGET($this->route.'/zip/'.fake::create()->text(10));
        $I->seeResponseCodeIs(404);
    }

    //------------- Send Get Null Zip Address Error -------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetNullZipAddressError(ApiTester $I)
    {
        $I->sendGET($this->route.'/zip/');
        $I->seeResponseCodeIs(404);
    }

    //------------- Send Get By Check Address --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetCheckAddressValid(ApiTester $I)
    {
        $data = [
            'zip' => '94587'
        ];
        $I->sendGET($this->route.'/check', $data);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Check Address Fake Zip Error -------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
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

    //------------- Send Get Check Address Zip Null Error ------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
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

    //-----------  Send Get city and state by first Characters  ---------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetStateByFirstCharactersValid(ApiTester $I)
    {
        $I->sendGET($this->route.'/city/California');
        $I->seeResponseCodeIs(200);
    }

    //--------------  Send Get Fake State By Characters Error --------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetFakeStateByFirstCharactersError(ApiTester $I)
    {
        $I->sendGET($this->route.'/city/California'.fake::create()->text(10));
        $I->seeResponseCodeIs(404);
    }

    //-------------- Send Get City And State By First Characters Valid --------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetCityAndStateByFirstCharactersValid(ApiTester $I)
    {
        $I->sendGET($this->route.'/city/Union');
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get City And Fake State By First Characters Error ---------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetCityAndFakeStateByFirstCharactersError(ApiTester $I)
    {
        $I->sendGET($this->route.'/city/Union'.fake::create()->text(10));
        $I->seeResponseCodeIs(404);
    }

    //-------------  Send Get City And Null State By First Characters Error//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetCityAndNullStateByFirstCharactersError(ApiTester $I)
    {
        $I->sendGET($this->route.'/city/');
        $I->seeResponseCodeIs(404);
    }









}
