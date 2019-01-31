<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Api extends \Codeception\Module
{
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
