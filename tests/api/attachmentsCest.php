<?php

use Faker\Factory as fake;
use bheller\ImagesGenerator\ImagesGeneratorProvider;

class attachmentsCest
{
    public $route = '/attachments';
    public $userID;
    public $token;

    private function setRoute($params)
    {
        return $this->route = '/attachments'.$params;
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

    //-------------- Upload new attachment -----------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     * @before signInByPassword
     */
    public function sendPostUploadNewAttachment(ApiTester $I)
    {
        $data = [
            'entityId' => fake::create()->randomNumber(2, true),
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
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $I->seeResponseCodeIs(201);
    }

    //-------------- Send Get Listing of Attachments  ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfAttachments(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //------------ Send Get Show Attachments By ID --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowAttachmentsById(ApiTester $I)
    {
        $this->userID = 64;
        $I->sendGET($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Send Delete Attachments By ID --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteAttachmentsById(ApiTester $I)
    {
        $this->userID = 64;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }




}
