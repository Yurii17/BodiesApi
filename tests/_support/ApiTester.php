<?php

use usersCest;
use authCest;
use sessionsCest;
use cardsCest;
use addressCest;
use locationsCest;
use workoutsCest;
use settingsCest;
use photoCest;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class ApiTester extends \Codeception\Actor
{
    use _generated\ApiTesterActions;

   /**
    * Define custom actions here
    */


   public function removeAuthToken()
   {
       $this->deleteHeader('Authorization');
   }

   public function seeMethodNotAllowed($message)
   {
       $this->seeResponseCodeIs(405);
       $this->seeResponseContainsJson($message);
   }


   public function seeForbiddenErrorMessage($message)
   {
       $this->seeResponseCodeIs(403);
       $this->seeResponseContainsJson($message);
   }

   public function seeErrorMessage($message)
   {
       $this->seeResponseCodeIs(422);
       $this->seeResponseContainsJson($message);
   }

    public function saveUser(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getUserData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'email' => $data[0],
            'firstName' => $data[1],
            'lastName' => $data[2],
            'password' => $data[3],
            'dataOfBirth' => $data[5],
            'defaultZip' => $data[6],
            'phoneNumber' => $data[7]
        ];
        return $user;
    }

    public function getUserDataByPin($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'email' => $data[0],
            'firstName' => $data[1],
            'lastName' => $data[2],
            'password' => $data[3],
            'pin' => $data[4],
            'dataOfBirth' => $data[5],
            'defaultZip' => $data[6],
            'phoneNumber' => $data[7]
        ];
        return $user;
    }

    public function loginAs($email, $secret)
    {
        $this->sendPOST('/users/login/by-password', [
            "identity" => $email,
            "secret" => $secret
        ]);
        $token = $this->grabDataFromResponseByJsonPath('$.token'); // [data : ['token': 21312321]]
        $this->amBearerAuthenticated($token[0]);
    }


    public function loginPin($email, $pin)
    {
        $this->sendPOST('/users/login/by-pin', [
            "identity" => $email,
            "secret" => $pin
        ]);
        $token = $this->grabDataFromResponseByJsonPath('$.token'); // [data : ['token': 21312321]]
        $this->amBearerAuthenticated($token[0]);
    }

}
