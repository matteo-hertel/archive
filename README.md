MH_Config
=========

[![Build Status](https://travis-ci.org/matteo-hertel/MH_Config.svg)](https://travis-ci.org/matteo-hertel/MH_Config)

Class built with the purpose to manage configuration options or settings easily, there are two types of configs: private and public and they have different behaviors.

Overview
---
The class has a specific lifecycle:

1. One or more instances are created:
    - if no config file is passed to the constructor the file mh_config.json will be used to get and save configs.
'''php
<pre>
$config = new \MH\MH_Config();
</pre>
    - if the FULL PATH of a config file is passed that file will be used to get and save configs.
'''php
<pre>
$config = new \MH\MH_Config(\__DIR__."/config.json");
</pre>
2. Value are retrieved or set (with magic setter and getter):
    * Set:
        - there is no limitation to set/overwrite public config
'''php
<pre>
$config->myPublicElement = "foo";
</pre>
        - to set/overwrite a private item the override flag must be set to true otherwise the set will be ignored
'''php
<pre>
//ignored
$config->_myPrivateElement = "bar";
//set as aspected
$config->override = true;
$config->_myPrivateElement = "bar";
</pre>
    * Get:
        - if the desidered item starts with an underscore the getter will look into the private array and return the value, if the item is not found, false is returned.
'''php
<pre>
echo $config->_myPrivateElement;
</pre>
        - for all the items that do not starts with an underscore the getter will look into the public array and return the chosen item, false is returned if the item is not found.
        '''php
        <pre>
        echo $config->myPublicElement;
        </pre>

3.The instance is destroyed:
    * when the instance is destroyed the magic __destruct is invoked, if something has changed inside the config from the original file it will reserialize and save the new changes over to the json file.
    
    
Feedback
---
I really need some feedback from you, this class was written to give me flexibility on my PHP applications but I really like to improve it, so if you have any idea or you spotted a bug, do a pull request or open an issue in the issue tracker, thanks!



