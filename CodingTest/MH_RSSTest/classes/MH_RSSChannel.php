<?php

/**
 * MH_RSSChannel
 *
 * This class will create a virtual RSS channel and will provide a set of function with the goal
 * to have a ready-to-print RSS feed in JSON
 *
 * @category   RSS Utility
 * @copyright  Copyright (c) 2014 Matteo Hertel Htpp://matteohertel.com
 * @license    MIT
 * @version    0.0.1
 */
class MH_RSSChannel implements JsonSerializable {

    //init some useful vars
    private $children = [], $main_image, $time = false;

    //in the construct check if the feed is a valid object and call the create channel function
    function __construct($channel) {
        if (!$channel || !$channel instanceof SimpleXMLIterator):
            throw new Exception("The RSS Channel must be provided and must be an istance of SimpleXMLIterator", "0x01");
        endif;

        $this->createChannel($channel);
    }

    /**
     * createChannel
     * 
     * this function will create the virtual RSS channel with all the children
     *
     *
     * @param       obj $channel SimpleXMLIterator instance
     * @return      none
     * @category    RSS Utility
     * @copyright   Copyright (c) 2014 Matteo Hertel Htpp://matteohertel.com
     * @license     MIT
     */
    private function createChannel($channel) {
        /*
         * First of all get the main image, this image will be used as default image if the 
         * article has no images
         */
        if (isset($channel->image->url)):
            $this->main_image = (string) $channel->image->url;
        endif;
        /*
         * Since I need to provide a continuos feed I'll use the time params in the GET
         * to find the time of the last displayed article
         */
        if (array_key_exists("time", $_GET)):
            try {
                //never trust the user, filter the GET params
                $filtered_time = filter_input(INPUT_GET, 'time', FILTER_SANITIZE_NUMBER_INT);
                //using a DateTime object if the time is not valid will throw an error and the catch
                // will fire set the variable on false
                $this->time = DateTime::createFromFormat("U", $filtered_time)->format("U");
            } catch (Exception $exc) {
                //if the dateTime fails the time is false
                $this->time = false;
            }

        endif;
        /*
         * Loop through the children and create the virtual children
         * I'm using an RSS xml, this means that the names of the elements will never (hopefully) change
         * so rather than loop through every element to find the container of the artcile I can
         * safely use the "item" property
         */
        try {
            foreach ($channel->item as $key => $value):
                $this->createChildren($value);
            endforeach;
            /*
             * sort the children array and reset the keys to make it compatible
             * with a simple for loop
             */
            ksort($this->children);
            $this->children = array_values($this->children);
        } catch (Exception $exc) {
            throw new Exception("Invalid element in the create channel function", "0x02");
        }
    }

    /**
     * createChildren
     * 
     * this function will create the children array, sorted in alphabetical order
     * by title and perform a time check
     *
     *
     * @param       obj $channel SimpleXMLIterator instance
     * @return      none
     * @category    RSS Utility
     * @copyright   Copyright (c) 2014 Matteo Hertel Htpp://matteohertel.com
     * @license     MIT
     */
    private function createChildren($children) {
        /*
         * try/catch statement, will throw an exception if something goes wrong
         */
        try {
            //get the time object of the pubDate I'll use that to perfome the time check and
            // to add the timestamp to the object
            $time = new DateTime((string) $children->pubDate);
            // if the time is set perform the time check
            if ($this->time):
                /*
                 * if the time of the element is greater than the time passed
                 * via GET add the element to the children array
                 */
                if ($time->format("U") > $this->time):
                    /*
                     * here a simple and smart way to sort alphabetically the news feed:
                     * from the title I'll exctract the firs character, trasform it to lowercase
                     * get the ASCII value of that char and subtract 97, the value of a in ASCII is 97
                     * so if is a the value will be 0 and I'll use that as index of the array
                     */
                    $char = ord(strtolower(substr((string) $children->title, 0, 1))) - 97;
                    /*
                     * if the value just found is not in the children array already
                     * add an empty array
                     */
                    if (!array_key_exists($char, $this->children)):
                        $this->children[$char] = [];
                    endif;
                    /*
                     * than add as a new array the value requested and the timestamp
                     */
                    $this->children[$char][] = [
                        "title" => (string) $children->title,
                        "description" => (string) $children->description,
                        "link" => (string) $children->link,
                        "image" => isset($children->image) ? (string) $children->image : (string) $this->main_image,
                        "timestamp" => $time->format("U")
                    ];
                endif;
            else:
                /*
                 * here a simple and smart way to sort alphabetically the news feed:
                 * from the title I'll exctract the firs character, trasform it to lowercase
                 * get the ASCII value of that char and subtract 97, the value of a in ASCII is 97
                 * so if is a the value will be 0 and I'll use that as index of the array
                 */
                $char = ord(strtolower(substr((string) $children->title, 0, 1))) - 97;
                /*
                 * if the value just found is not in the children array already
                 * add an empty array
                 */
                if (!array_key_exists($char, $this->children)):
                    $this->children[$char] = [];
                endif;
                /*
                 * than add as a new array the value requested and the timestamp
                 */
                $this->children[$char][] = [
                    "title" => (string) $children->title,
                    "description" => (string) $children->description,
                    "link" => (string) $children->link,
                    "image" => isset($children->image) ? (string) $children->image : (string) $this->main_image,
                    "timestamp" => $time->format("U")
                ];
            endif;
        } catch (Exception $exc) {
            throw new Exception("Unknown error while parsing the children", "0x03");
        }
    }

    /*
     * This class implements the abstract class JsonSerializable, this means that
     * with the jsonSerialize I can choose what can be printed in a json_encode call
     * in this case I can call the json_encode on the instance of the class an print
     * only the children array!
     */

    public function jsonSerialize() {

        return ["children" => $this->children];
    }

}
