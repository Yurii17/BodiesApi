<?php

use Faker\Factory as faker;
use bheller\ImagesGenerator\ImagesGeneratorProvider;

class photoCest
{
    public $route = '/photos';
    public $userID;

    private function setRoute($params)
    {
        return $this->route = '/photos'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com", "8_yry7p>+-[fWg^.");
    }

    //--------------- Send Post Upload New Photo   ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendPostUploadNewPhotos(ApiTester $I)
    {
        $data = [
            "entityId" => 1,
            "entityClass" => "user"
            ];
        $path = codecept_data_dir() . 'image';
        $file = $I->fileData(2, 'png');
        $I->sendPOST($this->route, $data, [
            'file' => [
                'name' => $file[0],
                'error' => UPLOAD_ERR_OK,
                'size' => filesize($path . '/' . ($file[0])),
                'tmp_name' => $path . '/' . ($file[0])
            ],
            [
                'name' => $file[1],
                'error' => UPLOAD_ERR_OK,
                'size' => filesize($path . '/' . ($file[1])),
                'tmp_name' => $path . '/' . ($file[1])
            ]
        ]);
        $I->seeResponseCodeIs(201);
    }

    //--------------Listing of photos--------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfPhotos(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //--------------Show photo By ID--------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowPhotosById(ApiTester $I)
    {
        $this->userID = 30;
        $I->sendGET($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(200);
    }

    //--------------Delete Photo--------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeletePhotos(ApiTester $I)
    {
        $this->userID = 1;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }













}
