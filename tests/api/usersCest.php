<?php 

use Faker\Factory as fake;

class usersCest
{
    public $route = '/users';
    public $userID;

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

    private function login(ApiTester $I)
    {
        $I->sendPOST('/users/login/by-password', [
            "identity" => "yurii.lobas+9f5a7d9a3f16a915346826c3cbed3e1a@gmail.com",
            "secret" => "[GqH\\Rf;?GDxlgX0"
        ]);
        $token = $I->grabDataFromResponseByJsonPath('$.token'); // [data : ['token': 21312321]]
        $I->amBearerAuthenticated($token[0]);

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
            "email" => 'yurii.lobas+'.fake::create()->md5.'@gmail.com', //safeEmail, domainName, null, '', @@, @gmail,com, 922.22.22.22@gmail.com
            "firstName" => fake::create()->firstName, //'
            "lastName" => fake::create()->lastName, // '', null, 'a', 'A', 'asd', 'asdasdasdasdasdasdasdasdasdasdasdasdasdasd'
            "password" => fake::create()->password, // '', null, 1, asd, 213123123123123123123123123123123123123123
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





    //----------------Get User by Id-------------------//

    /**
     * @param ApiTester $I
     * @before login
     */
    public function sendGetUserByID(ApiTester $I)
    {
        $this->userID = 25;
        $this->setRoute('/'.$this->userID);
        $I->sendGET($this->route);
        $I->seeResponseCodeIs(200);
        $userData = $I->getUserData('user.txt');
        var_dump($userData);
        foreach ($userData as $item) {
            $I->seeResponseContains($item);
        }
    }

    public function sendGetUser1(ApiTester $I)
    {
        $I->sendGET($this->route);
        $I->seeForbiddenErrorMessage(["message" => "Login Required"]);
    }



    //------------------Confirm email-------------------------//

    public function sendPostConfirmEmail(ApiTester $I)
    {
        $this->setRoute('/'.$this->userID.'/confirm-email');
        $I->sendPOST($this->route);
    }

    public function sendGetConfirmEmail(ApiTester $I)
    {
        $I->seeMethodNotAllowed();
    }













}
