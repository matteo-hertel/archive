<?php

class MH_URL {

    private $_url;

    function __construct($url = false) {
        if ($url):
            $this->_url = $url;
        endif;
    }

    /**
     * Convert the given URL in a SEO friendly URL
     * 
     *
     * @param       string $url any url
     * @return      string SEO friendly URL
     * @category    Utility
     * @copyright   Copyright (c) 2014
     */
    public function seoFriendlyURL() {
        /*
         * first of all the URL should be lowercase
         */
        $this->_url = strtolower($this->_url);
        /*
         * Strip any unwanted characters, allowed characters:
         *  letters, numbers, underscores, colon, and forward slash
         */
        $this->_url = preg_replace("/[^a-z0-9_:\/\.\s-]/", "", $this->_url);
        /*
         * extra check clean multiple dashes or whitespaces
         */
        $this->_url = preg_replace("/[\s-]+/", " ", $this->_url);
        /*
         * Convert whitespaces to dash
         */
        $this->_url = preg_replace("/[\s]/", "-", $this->_url);

        return $this->_url;
    }

}
?>


