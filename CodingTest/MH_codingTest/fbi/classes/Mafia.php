<?php
/*
 * Main class Mafia
 * 
 * This class keep track of the entire organisations and performe some operation to it
 * 
 */ 
class Mafia {

    private $oganisation = array();

    /*
     * addBoss
     * 
     * if the member has no boss it means he/she's a boss, so add it to the organisation
     * 
     */
    public function addBoss($member) {
        if ($member instanceof MafiaMember) {
            $this->oganisation[] = $member;
            return $this;
        }
    }
    /*
     * printOrganisation
     * 
     * At any moment the structure of the organisation can be printed out
     * in a hierarchical list
     * 
     */
    public function printOrganisation($child = false) {
        if ($child === false) {
            $child = $this->oganisation;
        }

        if (is_array($child)) {
            echo "<ul>";
            foreach ($child as $k => $v) {
                if ($v->active === true) {
                    echo sprintf("<li>%s</li>", $v->name);
                }
                if (count($v->subordinates)) {
                    $this->printOrganisation($v->subordinates);
                }
            }
            echo "</ul>";
        }
    }
    /*
     * removeSubordinate
     * 
     * this function delete a subordinate from a boss
     * by rebuilding the subordinates array without the passed subordinates
     * 
     */
    public function removeSubordinate($boss, $sub) {
        $temp = $boss->getSubordinates();
        $boss->emptySubordinates();

        foreach ($temp as $key => $member) {
            if ($member !== $sub) {
                $boss->addSubordinate($member);
            }
        }
    }
    /*
     * __get
     * 
     * magic getter for coding speed porpuse
     * 
     */
    public function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

}

