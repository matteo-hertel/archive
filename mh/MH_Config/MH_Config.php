<?php

/**
 * @brief The widget system will run under the MH namespace
 */

namespace MH;

/**
 * @class MH_Config
 * @brief Class built with the purpose to manage configuration options or settings easily.
 * the class will get a json file as input (or will create one for you) and all 
 * the two types of settings private and public are ket in internal private array
 * config, when the class is removed, if something has changed the class will 
 * use his innerithed jsonSerialize to serialize the updated version of the 
 * config and store it into the JSON file
 *
 * @copyright  Copyright (c) 2014 Matteo Hertel (info@matteohertel.com)
 * @license    MIT
 * @version    0.1
 * @author    Matteo Hertel <info@matteohertel.com>
 */
class MH_Config implements \JsonSerializable {

    /**
     * $override is public, the developer can choose if the private configs can be overwritten
     */
    public $override = false;

    /**
     * $config, $file, $update are used internally to alter the behavior of some functions
     */
    private $config = false, $file = false, $update = false;

    /**
     * Constructor
     * 
     * the constructor will get as input the FULL PATH of a JSON file, if no file
     * is provided the mh_config.json will be used, the class will try to get the 
     * content and parse the JSON if that operation is successfully the config array will be the 
     * unserialized JSON, if that operation fails the config array is initialized with the two keys
     * private and public.
     * 
     * @param string|boolean $configFile FULL PATH of a json file
     */
    public function __construct($configFile = false) {
        //if no file is provided use the fallback
        if (!$configFile):
            $configFile = __DIR__ . "/mh_config.json";
        endif;
        //set the internal property file to the right value
        $this->file = $configFile;
        //if the file does not exist or is not readable init the config to its empty state
        if (!is_readable($configFile)):
            $this->config = ["public" => [], "private" => []];
            return;
        else:
            //otherwise try to parse the content
            $content = file_get_contents($configFile);
            $json = json_decode($content, true);
            //if the content is empty or not valid init the config to its empty state
            if (!$content || !$json):
                $this->config = ["public" => [], "private" => []];
                return false;
            else:
                //otherwise set the config to the parsed json
                $this->config = $json;
            endif;
        endif;
    }

    /**
     * Getter
     * 
     * the getter will check the first character on the requested item, is it starts with and underscore
     * it will check the private index of the config object for the requested item and will return it, if the 
     * string does not starts with and underscore the public index will be used.
     * If the element is not found false is returned.
     * 
     * @param string $property automatically passed the requested item.
     * @return mixed the requested item or false if no element is found.
     */
    public function __get($property) {
        //check for underscore
        if (strpos($property, "_") === 0):
            //if the first carachter is an underscore use the private index
            if (array_key_exists($property, $this->config["private"])):
                //if it exists return the element
                return $this->config["private"][$property];
            endif;
            // return false otherwise
            return false;
        else:
            //if the string does not starts with and underscore use the public index
            if (array_key_exists($property, $this->config["public"])):
                //if it exists return the element
                return $this->config["public"][$property];
            endif;
            // return false otherwise
            return false;
        endif;
    }

    /**
     * Setter
     * 
     * the setter will use the same trick of the getter to check if the requested item is public or private:
     * if is private and the ovveride flag is false, the request will be ignored, if the flag is true the private item
     * will be created/overwritten
     * 
     * if the item is public will be overwritten/create with no further checks
     * 
     * if one or more items are changed the update flag will change to true and 
     * the destructor will save the changed over to the JSON file
     * 
     * @param string $property automatically passed the requested item.
     * @param string $value automatically passed the vaule of the new/updated item.
     * @return boolean true on success or false one or more checks fails.
     */
    public function __set($property, $value) {
        //if is private
        if (strpos($property, "_") === 0):
            //and the override is true
            if ($this->override):
                //change the update flag to true
                $this->update = true;
                //and set the value
                $this->config["private"][$property] = $value;
                return true;
            endif;
            // return false if the override is false
            return false;
        //if is public update the value and the flag
        else:
            $this->update = true;
            $this->config["public"][$property] = $value;
            return true;
        endif;
    }

    /**
     * Destructor
     * 
     * if something has changed on the config array and the update flag is true 
     * once the destructor is called it will serialize the config array and save 
     * it over to the JSON file.
     * 
     */
    public function __destruct() {
        //if the updatre flag is true
        if ($this->update):
            /**
             * open the JSON file
             * 
             * please note the @ operator used, if the file path is invalid or not accessible 
             * that will raise a warning, I don't want that because the JSON must be accessible
             */
            $file = @fopen($this->file, "w");
            //if the file is accessible write the content
            if ($file !== false):
                fwrite($file, json_encode($this));
                fclose($file);
            endif;

        endif;
    }

    /**
     * jsonSerialize
     * 
     * implement the jsonSerialize method to choose what will be serialized on the
     * json_encode function
     * 
     * @return array the config array.
     */
    public function jsonSerialize() {
        return $this->config;
    }

}
