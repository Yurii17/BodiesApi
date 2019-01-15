<?php

use Faker\Factory as fake;
use bheller\ImagesGenerator\ImagesGeneratorProvider;

class attachmentsCest
{
    public $route = '/attachments';
    public $userID;

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
     * @before signInByPassword
     */
    public function sendPostUploadNewAttachment(ApiTester $I)
    {
        $data = [
            "entityId" => fake::create()->randomNumber(2, true),
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

    //--------------Listing of attachments--------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetListingOfAttachments(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
    }

    //--------------Show attachments By ID--------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetShowAttachmentsById(ApiTester $I)
    {
        $this->userID = 33;
        $I->sendGET($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(200);
    }

    //-------------- Delete Attachments By ID --------------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendDeleteAttachmentsById(ApiTester $I)
    {
        $this->userID = 2;
        $I->sendDELETE($this->route.'/'.$this->userID);
        $I->seeResponseCodeIs(204);
    }




}
