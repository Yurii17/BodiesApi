<?php

use Faker\Factory as faker;
use bheller\ImagesGenerator\ImagesGeneratorProvider;

class photoCest
{
    public $route = '/photos';
    public $photoID;
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
        $I->loginAs('yurii.lobas+7336885c314290434c04d4bd3d5fbc54@gmail.com', '!pass76934');
    }

    //--------------- Send Post Upload New Photo   ---------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendPostUploadNewPhotos(ApiTester $I)
    {
        $data = [
            'entityId' => faker::create()->randomNumber(2),
            'entityClass' => 'user'
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
        $I->savePhoto([
            $data['entityId'], ' ',
            $data['entityClass'], ' '
        ], 'photo.txt');
        $I->seeResponseCodeIs(201);
        $this->photoID = $I->grabDataFromResponseByJsonPath('$.[*].id');
    }

    //-----------  Send Get Listing of Photos  --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     * @throws Exception
     */
    public function sendGetListingOfPhotos(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Get Show photo By ID  --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowPhotosById(ApiTester $I)
    {
        $I->sendGET($this->route.'/'.$this->photoID[0]);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Delete Photo By ID --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeletePhoto(ApiTester $I)
    {
        $I->sendDELETE($this->route.'/'.$this->photoID[0]);
        $I->seeResponseCodeIs(204);
    }













}
