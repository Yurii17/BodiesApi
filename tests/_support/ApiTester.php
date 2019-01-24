<?php

//use usersCest;
//use authCest;
//use sessionsCest;
//use cardsCest;
//use addressCest;
//use locationsCest;
//use workoutsCest;
//use settingsCest;
//use photoCest;
use Faker\Factory as faker;
use bheller\ImagesGenerator\ImagesGeneratorProvider;

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

    public function saveUserActivity(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getUserActivityData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'name' => $data[0],
            'code' => $data[1],
            'status' => $data[2],
            'shortDesc' => $data[3],
            'fullDesc' => $data[4],
            'isCertRequired' => $data[5]
        ];
        return $user;
    }

    public function saveUserAddress(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getUserAddressData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'name' => $data[0],
            'address1' => $data[1],
            'address2' => $data[2],
            'postalCode' => $data[3],
            'city' => $data[4],
            'state' => $data[5],
            'lat' => $data[6],
            'lon' => $data[7],
            'status' => $data[8],
            'reviewId' => $data[9],
            'reviewState' => $data[10]
        ];
        return $user;
    }

    public function saveUserAmenities(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getUserAmenitiesData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'id' => $data[0],
            'createdAt' => $data[1],
            'modifiedAt' => $data[2],
            'expireAt' => $data[3],
            'status' => $data[4],
            'code' => $data[5],
            'name' => $data[6]
        ];
        return $user;
    }

    public function saveUserBilling(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getUserBillingData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'amount' => $data[0],
            'source' => $data[1]
        ];
        return $user;
    }

    public function saveUserRatings(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getUserRatingsData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'entityClass' => $data[0],
            'entityId' => $data[1],
            'value' => $data[2]
        ];
        return $user;
    }
    /**
     * @throws Exception
     */
    public function loginAs($email, $secret)
    {
        $this->sendPOST('/users/login/by-password', [
            "identity" => $email,
            "secret" => $secret
        ]);
        $token = $this->grabDataFromResponseByJsonPath('$.token'); // [data : ['token': 21312321]]
        $this->amBearerAuthenticated($token[0]);
    }
    /**
     * @throws Exception
     */
    public function loginPin($userID, $pin)
    {
        $this->sendPOST('/users/login/by-pin', [
            'identity' => $userID,
            'secret' => $pin
        ]);
        $token = $this->grabDataFromResponseByJsonPath('$.token');
        $this->amBearerAuthenticated($token[0]);
    }

    /**
     * @return array|bool
     */
    public function fileData($fileNum, $fileType = null)
    {
        $path = codecept_data_dir().'image';
        //Verify if folder is exist
        if(!is_dir($path)){
            if(!mkdir($path, 0700, TRUE)) {
                echo "Cannot create $path\n";
                return false;
            }
        }
        if(is_null($fileType)) {
            $fileType = 'png';
        }
        //folder preference for read\write
        @chmod($path, 0700);
        $generator = faker::create();
        $generator->addProvider(new ImagesGeneratorProvider(faker::create()));
        for ($i = 0; $i < $fileNum; $i++) {
            $generator->imageGenerator($path,
                faker::create()->numberBetween(128, 1024),
                faker::create()->numberBetween(1024, 128), $fileType,
                true,
                faker::create()->word,
                faker::create()->hexColor,
                faker::create()->hexColor
            );
        }
        $this->deleteHeader('Content-type');
        $rep = strlen($path.'/');
        $files = glob($path.'/'."*.png");
        $fileData = [];
        foreach ($files as $key) {
            $file = substr($key, $rep);
            array_push($fileData, $file);
        }
        return $fileData;
    }

    public function _afterSuite()
    {
        $path = codecept_data_dir() . 'image';
        if (!is_dir($path)) {
            echo "Cannot find $path\n";
            return false;
        } else {
            $rep = strlen($path . '/');
            $files = glob($path . '/' . "*.png");
            $fileData = [];
            foreach ($files as $key) {
                $file = substr($key, $rep);
                array_push($fileData, $file);
            }
            if (is_array($fileData)) {
                foreach ($fileData as $key) {
                    unlink(codecept_data_dir() . 'image/' . $key);
                }
            }
        }
    }
























}
