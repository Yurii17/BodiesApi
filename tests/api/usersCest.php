<?php

use Faker\Factory as fake;

class usersCest
{
    public $route = '/users';
    public $userID;
    public $userPhone;

    // user + auth + sessions + cards + address + locations + workouts + settings + photo + billng
    // messages + notifications + ratings + hosts + favorites + equipments + documents + documentActivity +
    // connections + coaches + coachSettings + coachActivity + attachments + amenities + activities +
    // reviews + service + spaceActivity + spaceAmenity + spaces + userActivity + videos
    /**
     * @param ApiTester $I
     * @throws Exception
     */

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


    //----------------Get all user list-----------------//

    public function sendGetUserAuthException(ApiTester $I)
    {
        $I->removeAuthToken();
        $I->sendGET($this->route);
    }

    public function sendGetUser(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeForbiddenErrorMessage(["message" => "Login Required"]);
    }

    public function sendPostUser(ApiTester $I)
    {
        $I->sendPOST($this->route, []);
        $I->seeResponseCodeIs(422);
        $I->seeErrorMessage([
            "field" => "email",
            "message" => "Email cannot be blank."
        ]);
    }

    public function sendPutUser(ApiTester $I)
    {
        $I->sendPUT($this->route);
        $I->seeForbiddenErrorMessage(["message" => "Login Required"]);
    }

    public function sendPatchUser(ApiTester $I)
    {
        $I->sendPATCH($this->route);
        $I->seeForbiddenErrorMessage(["message" => "Login Required"]);
    }

    public function sendDeleteUser(ApiTester $I)
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
            "phoneNumber" => fake::create()->phoneNumber
        ];

        $I->saveUser([
        $data['email'], ' ',
        $data['firstName'], ' ',
        $data['lastName'], ' ',
        $data['password'], ' ',
        $data['pin'], ' ',
        $data['dateOfBirth'], ' ',
        $data['defaultZip'], ' ',
        $data['phoneNumber']
    ], 'user.txt');
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(201);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $this->userPhone = $I->grabDataFromResponseByJsonPath('$.phoneNumber');
    }



    public function sendPostNullEmailError(ApiTester $I)
    {
        $data = [
            "email" => null,
            "firstName" => fake::create()->firstName,
            "lastName" => fake::create()->lastName,
            "password" => fake::create()->password(),
            "pin" => fake::create()->randomNumber(4, true),
            "dateOfBirth" => "1970-01-01",
            "defaultZip" => fake::create()->randomNumber(6,true),
            "phoneNumber" => fake::create()->phoneNumber
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(422);
        $I->seeErrorMessage([
            "field" => "email",
            "message" => "Email cannot be blank."]);
    }

    public function sendPostEmptyEmailError(ApiTester $I)
    {
        $data = [
            "email" => "",
            "firstName" => fake::create()->firstName,
            "lastName" => fake::create()->lastName,
            "password" => fake::create()->password(),
            "pin" => fake::create()->randomNumber(4, true),
            "dateOfBirth" => "1970-01-01",
            "defaultZip" => fake::create()->randomNumber(6,true),
            "phoneNumber" => fake::create()->phoneNumber
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(422);
        $I->seeErrorMessage([
            "field" => "email",
            "message" => "Email cannot be blank."]);
    }

    public function sendPostDomainEmailError(ApiTester $I)
    {
        $data = [
            "email" => "email.domain.com",
            "firstName" => fake::create()->firstName,
            "lastName" => fake::create()->lastName,
            "password" => fake::create()->password(),
            "pin" => fake::create()->randomNumber(4, true),
            "dateOfBirth" => "1970-01-01",
            "defaultZip" => fake::create()->randomNumber(6,true),
            "phoneNumber" => fake::create()->phoneNumber
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(422);
        $I->seeErrorMessage([
            "field" => "email",
            "message" => "Email is not a valid email address."]);
    }

    public function sendPostMissingEmailError(ApiTester $I)
    {
        $data = [
            "email" => "@gmail.com",
            "firstName" => fake::create()->firstName,
            "lastName" => fake::create()->lastName,
            "password" => fake::create()->password(),
            "pin" => fake::create()->randomNumber(4, true),
            "dateOfBirth" => "1970-01-01",
            "defaultZip" => fake::create()->randomNumber(6,true),
            "phoneNumber" => fake::create()->phoneNumber
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(422);
        $I->seeErrorMessage([
            "field" => "email",
            "message" => "Email is not a valid email address."]);
    }

    public function sendPostDoubleDomainEmailError(ApiTester $I)
    {
        $data = [
            "email" => "email.@domain@.com",
            "firstName" => fake::create()->firstName,
            "lastName" => fake::create()->lastName,
            "password" => fake::create()->password(),
            "pin" => fake::create()->randomNumber(4, true),
            "dateOfBirth" => "1970-01-01",
            "defaultZip" => fake::create()->randomNumber(6,true),
            "phoneNumber" => fake::create()->phoneNumber
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(422);
        $I->seeErrorMessage([
            "field" => "email",
            "message" => "Email is not a valid email address."]);
    }

    public function sendPostDoubleDogEmailError(ApiTester $I)
    {
        $data = [
            "email" => "@@",
            "firstName" => fake::create()->firstName,
            "lastName" => fake::create()->lastName,
            "password" => fake::create()->password(),
            "pin" => fake::create()->randomNumber(4, true),
            "dateOfBirth" => "1970-01-01",
            "defaultZip" => fake::create()->randomNumber(6,true),
            "phoneNumber" => fake::create()->phoneNumber
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(422);
        $I->seeErrorMessage([
            "field" => "email",
            "message" => "Email is not a valid email address."]);
    }

    public function sendPostPasswordError(ApiTester $I)
    {
        $data = [
            "email" => "test1312@example.com",
            "firstName" => "John",
            "lastName" => "Travolta",
            "password" => "%ty*<yWwR",
            "pin" => "1010",
            "dateOfBirth" => "1970-01-01",
            "defaultZip" => "622854",
            "phoneNumber" => "(651) 514-8975 x1340"
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(422);
        $I->seeErrorMessage([
            "field" => "password",
            "message" => "Password too weak, it must contains letters(upper and lower cased), digits and special chars"]);
    }

    public function sendPostCreateUserZipError(ApiTester $I)
    {
        $data = [
            "email" => "test1312@example.com",
            "firstName" => "John",
            "lastName" => "Travolta",
            "password" => "1aB#Cd18",
            "pin" => "1010",
            "dateOfBirth" => "1970-01-01",
            "defaultZip" => 612321233,
            "phoneNumber" => "+1011111111"
        ];
        $I->sendPOST($this->route, $data);
        $I->seeResponseCodeIs(422);
        $I->seeErrorMessage([
            "field" => "defaultZip",
            "message" => "Default Zip should contain at most 6 characters."]);
    }


    //-------------------------Get User by Id-------------------//

    /**
     * @param ApiTester $I
     * @before signInByPassword
     */
    public function sendGetUserByID30(ApiTester $I)
    {
        $this->userID = 30;
        $this->setRoute('/'.$this->userID);

        $data = [
            'email' => 'yurii.lobas+e769b642eaa052d122fe4e6359f83f79@gmail.com',
            'firstName' => 'Jalon',
            'lastName' => 'Braun',
            'phoneNumber' => '+8653057446',
            'dateOfBirth' => '2000-01-09',
            'defaultZip' => '266453',
        ];
        $I->sendGET($this->route, $data);
        $I->seeResponseCodeIs(200);
        foreach ($data as $item) {
            $I->seeResponseContains($item);
        }
    }

    //------------------Sing In By Password----------------------------//

    public function sendPostSignInByPassword(ApiTester $I)
    {
        $user = $I->getUserData('user.txt');
        var_dump($user);
        $I->loginAs($user['email'], $user['password']);
        $I->seeResponseCodeIs(200);
    }


    //---------------------------Sign In By Pin-------------------------------//

    public function sendPostSignInByPin(ApiTester $I)
    {
        $user = $I->getUserDataByPin('user.txt');
        var_dump($user);
//        $I->loginAs($user['email'], $user['password']);
        $I->loginPin($user['userID'], $user['pin']);
        $I->seeResponseCodeIs(200);
    }



    //------------------------Send Post Confirm email-------------------------//

    public function sendPostConfirmEmail(ApiTester $I)
    {
        $user = $I->getUserDataByPin('user.txt');
        var_dump($user);
        $I->loginAs($user['userID'], $user['password']);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $this->setRoute('/'.$this->userID[0].'/confirm-email');
        $I->sendPOST($this->route,
            ["code" => 1759]);
    }


    public function sendGetConfirmEmail(ApiTester $I)
    {
        $I->seeMethodNotAllowed();
    }

    //------------------------Send Post Confirm Phone-------------------------//

    public function sendPostConfirmPhone(ApiTester $I)
    {
        $user = $I->getUserDataByPin('user.txt');
        $I->loginAs($user['userID'], $user['password']);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $this->setRoute('/'.$this->userID[0].'/confirm-email');
        $I->sendPOST($this->route,
            ["code" => 3352]);
    }


    //---------------------Send Post Re-send Confirm Email-----------------------//

    public function sendPostReSendConfirmEmail(ApiTester $I)
    {
        $user = $I->getUserDataByPin('user.txt');
        $I->loginAs($user['userID'], $user['password']);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $this->setRoute('/'.$this->userID[0].'/confirm-email');
        $I->sendPOST($this->route);
        $I->seeResponseContains(["result" => [true]]);
    }

    //--------------------Send Post Re-send Confirm Phone-------------------------//

    public function sendPostReSendConfirmPhone(ApiTester $I)
    {
        $user = $I->getUserDataByPin('user.txt');
        $I->loginAs($user['userID'], $user['password']);
        $this->userID = $I->grabDataFromResponseByJsonPath('$.id');
        $this->setRoute('/'.$this->userID[0].'/confirm-phone');
        $I->sendPOST($this->route);
        $I->seeResponseContains(["result" => [true]]);
    }


    //-------------------- Current User Info -------------------------//

    public function sendGetCurrentUserInfo(ApiTester $I)
    {
        $user = $I->getUserData('user.txt');
        $I->loginAs($user['email'], $user['password']);
        $I->sendGet('/users/me');
        $I->seeResponseCodeIs(200);
    }

    //----------------------- Password Strength------------------------//

    public function sendGetPasswordStrength(ApiTester $I)
    {
        $user = $I->getUserData('user.txt');
        $I->loginAs($user['email'], $user['password']);
        $I->sendGet('/users/login/password-strength');
        $I->seeResponseCodeIs(200);
    }

    //-----------------------Set Random Password-------------------------------//

    public function sendPostSetRandomPassword(ApiTester $I)
    {
        $user = $I->getUserData('user.txt');
        $I->loginAs($user['email'], $user['password']);
        $I->sendPOST("/users/set-random", [
                "email" => $user['email']
            ]);
        $I->seeResponseCodeIs(200);
    }

    //---------------------Reset password by Email------------------------//

    public function sendPostResetPasswordByEmail(ApiTester $I)
    {
        $user = $I->getUserData('user.txt');
        $I->loginAs($user['email'], $user['password']);
        $I->sendPOST("/users/reset/by-email", [
            "email" => $user['email']
        ]);
        $I->seeResponseCodeIs(200);
    }

    //---------------------Reset password by Phone------------------------//

    public function sendPostResetPasswordByPhone(ApiTester $I)
    {
        $user = $I->getUserData('user.txt');
        $I->loginAs($user['email'], $user['password']);
        $I->sendPOST("/users/reset/by-phone", [
            "phoneNumber" => $user['phoneNumber']
        ]);
        $I->seeResponseCodeIs(200);
    }

    //------------------------Set New Password----------------------//

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

    //-----------------Validate Code-----------------------------/

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
