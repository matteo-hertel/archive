<?php

namespace MH;

class MH_Config implements \JsonSerializable {

    public $override = false;
    private $config = false, $file = false, $update = false;

    public function __construct($configFile = false) {
        if (!$configFile):
            $configFile = __DIR__ . "/mh_config.json";
        endif;
        $this->file = $configFile;
        if (!file_exists($configFile)):
            $this->config = ["public" => [], "private" => []];
            return;
        else:
            $content = file_get_contents($configFile);
            $json = json_decode($content, true);

            if (!$content || !$json):
                $this->config = ["public" => [], "private" => []];
                return false;
            else:
                $this->config = $json;
            endif;
        endif;
    }

    public function __get($property) {
        if (strpos($property, "_") === 0):
            if (array_key_exists($property, $this->config["private"])):
                return $this->config["private"][$property];
            endif;
            return false;
        else:
            if (array_key_exists($property, $this->config["public"])):
                return $this->config["public"][$property];
            endif;
            return false;
        endif;
    }

    public function __set($property, $value) {
        if (strpos($property, "_") === 0):
            if ($this->override):
                $this->update = true;
                $this->config["private"][$property] = $value;
                return true;
            endif;
            return false;
        else:
            $this->update = true;
            $this->config["public"][$property] = $value;
            return true;
        endif;
    }

    public function __destruct() {
        if ($this->update):

            $file = @fopen($this->file, "w");
            if ($file !== false):
                fwrite($file, json_encode($this));
                fclose($file);
            endif;

        endif;
    }

    public function jsonSerialize() {
        return $this->config;
    }

}
