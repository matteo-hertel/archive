<?php

/*
 * Simple class to log in a user, far to be production ready for the test is just right
 */

class MH_login {
    /*
     * user and pass are usually stored in a DB but for now I'll use the hardcoded version
     */

    private $user = "demo@demo.com", $password = "demo", $cookie = "qwerty";

    /*
     * check the login and require the right page
     */

    public function __construct() {
        $this->login();
        if ($this->isLoggedIn()):
            require_once __DIR__ . '/../content.php';
        else:
            require_once 'login.php';
        endif;
    }

    /*
     * is the user logged in?
     */

    function isLoggedIn() {
        return isset($_SESSION[$this->cookie]);
    }

    /*
     * login function check the login and keetp track of the attempts
     */

    function login() {
        if (!$_POST):
            return;
        endif;
        $user = $filtered_time = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        if ($user === $this->user && $password === $this->password) {
            $_SESSION[$this->cookie] = true;
            unset($_SESSION["previuos_attempt"]);
        } else {
            if (!isset($_SESSION["previuos_attempt"])) {
                $_SESSION["previuos_attempt"] = 1;
            } else {
                $_SESSION["previuos_attempt"] = (int) $_SESSION["previuos_attempt"] + 1;
            }
        }
    }

}
