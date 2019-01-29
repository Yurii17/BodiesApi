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

    public function saveActivities(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getActivitiesData($file)
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

    public function saveRatings(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getRatingsData($file)
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

    public function saveUserActivities(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getUserActivitiesData($file)
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

    public function saveCoachActivity(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getCoachActivityData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'coachId' => $data[0],
            'activityId' => $data[1],
            'certificateId' => $data[3],
            'availableTo' => $data[4],
            'status' => $data[5]
        ];
        return $user;
    }

    public function saveCoaches(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getCoachesData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'userId' => $data[0],
            'description' => $data[1],
            'inHouse' => $data[3],
            'gender' => $data[4],
            'websiteName' => $data[5],
            'website' => $data[6],
            'twitter' => $data[7],
            'instagram' => $data[8],
            'linkedin' => $data[9],
            'facebook' => $data[10]
        ];
        return $user;
    }

    public function saveCoachSettings(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getCoachSettingsData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'gender' => $data[0],
            'age' => $data[1],
            'minRating' => $data[3],
            'minReviews' => $data[4],
            'userId' => $data[5]
        ];
        return $user;
    }

    public function saveConnections(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getConnectionsData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'entityClass' => $data[0],
            'entityId' => $data[1],
            'type' => $data[3],
            'value' => $data[4]
        ];
        return $user;
    }

    public function saveDocumentActivity(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getDocumentActivityData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'documentId' => $data[0],
            'activityId' => $data[1]
        ];
        return $user;
    }

    public function saveDocuments(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getDocumentsData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'name' => $data[0],
            'file' => $data[1],
            'startDate' => $data[2],
            'expDate' => $data[3],
            'provider' => $data[4],
            'number' => $data[5],
            'contactName' => $data[6],
            'contactPhone' => $data[7],
            'contactEmail' => $data[8],
            'type' => $data[9],
            'isComAccredited' => $data[10],
            'createdAt' => $data[11],
            'modifiedAt' => $data[12]
        ];
        return $user;
    }

    public function saveEquipments(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getEquipmentsData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'id' => $data[0],
            'code' => $data[1],
            'name' => $data[2],
            'createdAt' => $data[3],
            'modifiedAt' => $data[4],
            'expireAt' => $data[5],
            'status' => $data[6]
        ];
        return $user;
    }

    public function saveFavorites(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getFavoritesData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'entityClass' => $data[0],
            'entityID' => $data[1],
        ];
        return $user;
    }

    public function saveFeedbacks(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getFeedbacksData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'entityClass' => $data[0],
            'entityID' => $data[1],
            'title' => $data[2],
            'message' => $data[3]
        ];
        return $user;
    }

    public function saveHosts(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getHostsData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'userId' => $data[0],
            'addressId' => $data[1],
            'name' => $data[2],
            'description' => $data[3]
        ];
        return $user;
    }

    public function saveLocations(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getLocationsData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'addressId' =>  $data[0],
            'name' =>  $data[1],
            'description' =>  $data[2],
            'logo' =>  $data[3],
            'isLegalOwner' =>  $data[4],
            'type' =>  $data[5],
            'isParking' => $data[6],
            'size' =>  $data[7],
            'isBathroom' =>  $data[8],
            'isTowelService' => $data[9],
            'isShowers' =>  $data[10],
            'isInternet' =>  $data[11],
            'isFreeWifi' => $data[12]
        ];
        return $user;
    }

    public function saveMessages(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getMessagesData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'senderId' =>  $data[0],
            'recipientId' =>  $data[1],
            'subject' =>  $data[2],
            'category' =>  $data[3],
            'message' =>  $data[4]
        ];
        return $user;
    }

    public function saveNotifications(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getNotificationsData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'entityClass' =>  $data[0],
            'entityId' =>  $data[1],
            'category' =>  $data[2],
            'message' =>  $data[3],
            'userId' => $data[4]
        ];
        return $user;
    }

    public function saveProducts(Array $data, $file)
    {
        file_put_contents(codecept_data_dir($file), $data);
    }

    public function getProductsData($file)
    {
        $data = file_get_contents(codecept_data_dir($file));
        $data = explode(' ', $data);
        $user = [
            'sessionId' =>  $data[0],
            'workoutsQuantity' =>  $data[1],
            'price' =>  $data[2],
            'title' =>  $data[3]
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
