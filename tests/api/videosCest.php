<?php

use Faker\Factory as fake;

class videosCest
{
    public $route = '/videos';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/videos'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs('yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com', '8_yry7p>+-[fWg^.');
    }

    //----------------- Send Post Videos By Id ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostOfVideosById(ApiTester $I)
    {
        $data = [
            'entityId' => 1,
            'entityClass' => 'user',
            'files[]' => 'file source',
        ];
        $path = codecept_data_dir() . 'image';
        $file = $I->fileData(1, 'png');
        $I->sendPOST($this->route, $data, [
            'file' => [
                'name' => $file[0],
                'error' => UPLOAD_ERR_OK,
                'size' => filesize($path . '/' . ($file[0])),
                'tmp_name' => $path . '/' . ($file[0])
            ]
        ]);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //----------------- Send Get Listing of Videos By Id ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfVideosById(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //---------------- Send Delete Videos By Id ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteVideosById(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->userID[0]);
        $I->seeResponseCodeIs(204);
    }





}
