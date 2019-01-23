<?php

use Faker\Factory as fake;

class usersCest
{
    public $route = '/users';
    public $userID;
    public $token;
    public $userPhone;

    // user + auth + sessions + cards + address + locations + workouts + settings + photo + billing +
    // messages + notifications + ratings + hosts + favorites + equipments + documents + documentActivity +
    // connections + coaches + coachSettings + coachActivity + attachments + amenities + activities +
    // reviews + service + spaceActivity + spaceAmenity + spaces + userActivity + videos

    public function _before(ApiTester $I)
    {
    }

    private function setRoute($params)
    {
        return $this->route = '/users'.$params;
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPassword(ApiTester $I)
    {
        $I->loginAs("yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com", "8_yry7p>+-[fWg^.");
    }
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    private function signInByPin(ApiTester $I)
    {
        $I->loginPin('30', '3753');
    }

    //-------------- Send Get All user list-----------------//

    public function sendGetUserAuthException(ApiTester $I)
    {
        $I->removeAuthToken();
        $I->sendGET($this->route);
    }

    public function sendGetUserError(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeForbiddenErrorMessage(["message" => "Login Required"]);
    }

    public function sendPostUserError(ApiTester $I)
    {
        $I->sendPOST($this->route, []);
        $I->seeErrorMessage([
            "field" => "email",
            "message" => "Email cannot be blank."
        ]);
    }

    public function sendPutUserError(ApiTester $I)
    {
        $I->sendPUT($this->route);
        $I->seeForbiddenErrorMessage(["message" => "Login Required"]);
    }

    public function sendPatchUserError(ApiTester $I)
    {
        $I->sendPATCH($this->route);
        $I->seeForbiddenErrorMessage(["message" => "Login Required"]);
    }

    public function sendDeleteUserError(ApiTester $I)
    {
        $I->sendDELETE($this->route);
        $I->seeForbiddenErrorMessage(["message" => "Login Required"]);
    }


    //------------------------Create new user-------------------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendPostCreateUserValid(ApiTester $I)
    {
        $data = [
            "email" => 'yurii.lobas+'.fake::create()->md5.'@gmail.com',
            "firstName" => fake::create()->firstName,
            "lastName" => fake::create()->lastName,
            "password" => "6bfAC<kkThESw2",
            "pin" => fake::create()->randomNumber(4, true),
            "dateOfBirth" => fake::create()->date("2000-01-09"),
            "defaultZip" => fake::create()->randomNumber(6,true),
            "phoneNumber" => +71231231233204
        ];
        $I->saveUser([
            $data['email'], ' ',
            $data['firstName'], ' ',
            $data['lastName'], ' ',
            $data['password'], ' ',
            $data['pin'], ' ',
            $data['dateOfBirth'], ' ',
            $data['defaultZip'], ' ',
            $data['phoneNumber'], ' '
            ], 'user.txt');
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $this->token = $I->grabDataFromResponseByJsonPath('$.token');
        $this->userPhone = $I->grabDataFromResponseByJsonPath('$.phoneNumber');
    }

    //-------------  Send Post Email Error  -------------//
    public function sendPostNullEmailError(ApiTester $I)
    {
        $data = [
            'email' => null,
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'email',
            'message' => 'Email cannot be blank.'
        ]);
    }

    public function sendPostEmptyEmailError(ApiTester $I)
    {
        $data = [
            'email' => ''
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(422);
        $I->seeErrorMessage([
            'field' => 'email',
            'message' => 'Email cannot be blank.'
        ]);
    }

    public function sendPostDomainEmailError(ApiTester $I)
    {
        $data = [
            'email' => 'email.domain.com'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'email',
            'message' => 'Email is not a valid email address.'
        ]);
    }

    public function sendPostMissingEmailError(ApiTester $I)
    {
        $data = [
            'email' => '@gmail.com'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'email',
            'message' => 'Email is not a valid email address.'
        ]);
    }

    public function sendPostDoubleDomainEmailError(ApiTester $I)
    {
        $data = [
            'email' => 'email.@domain@.com'
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'email',
            'message' => 'Email is not a valid email address.'
        ]);
    }

    public function sendPostDoubleDogEmailError(ApiTester $I)
    {
        $data = [
            'email' => '@@',
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'email',
            'message' => 'Email is not a valid email address.'
        ]);
    }

    //-------------  Send Post Password Error ------------//
    public function sendPostPasswordError(ApiTester $I)
    {
        $data = [
            'email' => 'test1312@example.com',
            'password' => '%ty*<yWwR',
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'password',
            'message' => 'Password too weak, it must contains letters(upper and lower cased), digits and special chars'
        ]);
    }

    //-------------- Send Post Zip Error ------------------//
    public function sendPostCreateUserZipError(ApiTester $I)
    {
        $data = [
            'email' => 'test1312@example.com',
            'defaultZip' => 612321233,
        ];
        $I->sendPOST($this->route, $data);
        $I->seeErrorMessage([
            'field' => 'defaultZip',
            'message' => 'Default Zip should contain at most 6 characters.'
        ]);
    }

    //------------- Send Get User by Id:30 ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetUserByID30(ApiTester $I)
    {
        $userID = 30;
        $data = [
            'email' => 'yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com',
            'firstName' => 'Jalon',
            'lastName' => 'Braun',
            'phoneNumber' => '+8653057446',
            'dateOfBirth' => '2000-01-09',
            'defaultZip' => '266453',
        ];
        $I->sendGET($this->route.'/'.$userID, $data);
        $I->seeResponseCodeIs(200);
        foreach ($data as $item) {
            $I->seeResponseContains($item);
        }
    }

    //------------- Send Get User by Id ----------------//
    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetUserByID(ApiTester $I)
    {
        $userID = 30;
        $I->sendGET($this->route.'/'.$userID);
        $I->seeResponseCodeIs(200);
    }

    //---------------- Send Post Sing In By Password Valid-------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendPostSignInByPasswordValid(ApiTester $I)
    {
        $user = $I->getUserData('user.txt');
        $I->loginAs($user['email'], $user['password']);
        $I->seeResponseCodeIs(200);
    }

    //------------------ Send Post Sign In By Pin Valid -------------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     * @depends sendPostCreateUserValid
     */
    public function sendPostSignInByPinValid(ApiTester $I)
    {
        $user = $I->getUserDataByPin('user.txt');
        $data = [
            'identity' => $this->userID[0],
            'secret' => $user['pin']
        ];
        $I->sendPOST($this->route.'/login/by-pin', $data);
        $I->seeResponseCodeIs(200);
    }

    //------------------ Send Post Sign In By Pin Null Identity Error-------------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendPostSignInByPinNullIdentityError(ApiTester $I)
    {
        $user = $I->getUserDataByPin('user.txt');
        $data = [
            'identity' => null,
            'secret' => $user['pin']
        ];
        $I->sendPOST($this->route.'/login/by-pin', $data);
        $I->seeErrorMessage([
            'field' => 'identity',
            'message' => 'User ID cannot be blank.'
        ]);
    }

    //------------------ Send Post Sign In By Fake Pin Error-------------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendPostSignInByFakePinError(ApiTester $I)
    {
        $data = [
            'secret' => fake::create()->randomNumber(5)
        ];
        $I->sendPOST($this->route.'/login/by-pin', $data);
        $I->seeErrorMessage([
            'field' => 'secret',
            'message' => 'PIN should contain at most 4 characters.'
        ]);
    }


    //----------------  Send Post Confirm email  ---------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendPostConfirmEmail(ApiTester $I)
    {
        $data = [
            'code' => '1234'
        ];
        $I->sendPOST($this->route.'/'.$this->userID[0].'/confirm-email', $data);
    }

    //---------------   Send Get Confirm Email --------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendGetConfirmEmail(ApiTester $I)
    {
        $I->seeMethodNotAllowed();
    }

    //--------------   Send Post Confirm Phone  ---------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendPostConfirmPhone(ApiTester $I)
    {
        $data = [
            'code' => '0123'
        ];
        $I->sendPOST($this->route.'/'.$this->userID[0].'/confirm-phone', $data);
        $I->seeResponseContains(200);
    }

    //--------------   Send Post Confirm Phone Error  ---------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendPostConfirmPhoneError(ApiTester $I)
    {
        $data = [
            'code' => '01234'
        ];
        $I->sendPOST($this->route.'/'.$this->userID[0].'/confirm-phone', $data);
        $I->seeErrorMessage([
            'field' => 'code',
            'message' => 'Code should contain at most 4 characters.'
        ]);
    }

    //---------------- Send Post Re-send Confirm Email ---------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendPostReSendConfirmEmail(ApiTester $I)
    {
        $I->sendPOST($this->route.'/'.$this->userID[0].'/confirm-email');
        $I->seeResponseCodeIs(200);
    }

    //--------------  Send Post Re-send Confirm Phone ------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendPostReSendConfirmPhone(ApiTester $I)
    {
        $data = [
            'code' => '1234'
        ];
        $I->sendPOST($this->route.'/'.$this->userID[0].'/confirm-phone', $data);
        $I->seeResponseCodeIs(200);
    }

    //---------------  Send Get Current User Info -------------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendGetCurrentUserInfo(ApiTester $I)
    {
        $I->sendGet($this->route.'/me');
        $I->seeResponseCodeIs(200);
    }

    //---------------  Send GET Password Strength  ----------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendGetPasswordStrength(ApiTester $I)
    {
        $user = $I->getUserData('user.txt');
        $data = [
            'identity' => $user['email'],
            'password' => $user['password'],
        ];
        $I->sendGet($this->route.'/login/password-strength', $data);
        $I->seeResponseCodeIs(200);
    }

    //--------------  Send Post Set Random Password  ---------------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendPostSetRandomPassword(ApiTester $I)
    {
        $user = $I->getUserData('user.txt');
        $I->loginAs($user['email'], $user['password']);
        $I->sendPOST("/users/set-random", [
                "email" => $user['email']
            ]);
        $I->seeResponseCodeIs(200);
    }

    //------------  Send Post Reset password by Email --------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendPostResetPasswordByEmail(ApiTester $I)
    {
        $user = $I->getUserData('user.txt');
        $I->loginAs($user['email'], $user['password']);
        $I->sendPOST("/users/reset/by-email", [
            "email" => $user['email']
        ]);
        $I->seeResponseCodeIs(200);
    }

    //------------- Send Post Reset password by Phone  --------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendPostResetPasswordByPhone(ApiTester $I)
    {
        $user = $I->getUserData('user.txt');
        $I->loginAs($user['email'], $user['password']);
        $I->sendPOST("/users/reset/by-phone", [
            "phoneNumber" => $user['phoneNumber']
        ]);
        $I->seeResponseCodeIs(200);
    }

    //------------   Send Post Set New Password   ----------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendPostSetNewPassword(ApiTester $I)
    {
        $user = $I->getUserData('user.txt');
        $I->loginAs($user['email'], $user['password']);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $this->setRoute('/'.$this->userID[0].'/set-password');
        $I->sendPOST($this->route, [
            "password" => "6bfAC<kkThESw2",
            "token" => ""
        ]);
        $I->seeResponseCodeIs(200);
    }

    //----------------- Send Post Validate Code  ------------------------//
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendPostValidateCode(ApiTester $I)
    {
        $user = $I->getUserData('user.txt');
        $I->loginAs($user['email'], $user['password']);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $this->setRoute('/'.$this->userID[0].'/validate-code');
        $I->sendPOST($this->route, [
            "id" => $this->userID[0] ,
            "code" => "1111"
        ]);
        $I->seeResponseCodeIs(200);
    }

    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function sendPostValidateCodeError(ApiTester $I)
    {
        $user = $I->getUserData('user.txt');
        $I->loginAs($user['email'], $user['password']);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $this->setRoute('/'.$this->userID[0].'/validate-code');
        $I->sendPOST($this->route, [
            "id" => $this->userID[0] ,
            "code" => "132323"
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeErrorMessage([
            "field" => "code",
            "message" => "Code should contain at most 4 characters."
        ]);
    }




















}
