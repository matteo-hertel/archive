<?php
/*
 * mafiaMember
 * 
 * this class will provide all the method to performe various operation on a mafia member
 * 
 */
class MafiaMember extends Mafia {
    /*
     * init the member properties
     */
    private $boss = false,
            $active = false,
            $location = false,
            $free = false,
            $subordinates = array(),
            $age = false,
            $is_alive = false,
            $name = false,
            $origina_boss = false,
            $remove = array();
    /*
     * constructor
     * 
     * by passing an array if the key of the array is a valid property of the class
     * set the value to that property
     * 
     */
    public function __construct($data) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
    /*
     * magic toString
     * 
     * if an istance of the MafiaMember is echoed out return the name of the member
     * 
     */
    public function __toString() {
        return $this->name;
    }
    /*
     * return the subordinates of the current memebr
     */
    public function getSubordinates() {
        return $this->subordinates;
    }
    /*
     * reset the subordinates array to an emty array
     * 
     */
    public function emptySubordinates() {
        $this->subordinates = array();
    }
    /*
     * return the boss of the current member
     * 
     */
    public function getBoss() {
        return $this->boss;
    }
    /*
     * add a boss to the current member
     */
    public function addBoss($boss) {
        $this->boss = $boss;
        return $this;
    }
    /*
     * killed
     * 
     * the current member is killed all his subordinates will hide for a while
     * 
     */
    public function killed() {
        $this->is_alive = false;
        $this->active = false;
        $this->hideSubordinates($this->subordinates);
    }
    /*
     * recursively hide the subordinates when a boss is killed
     */
    private function hideSubordinates($subordinates) {

        if (!count($subordinates)) {
            return false;
        }
        foreach ($subordinates as $key => $member) {
            $member->hidden();
            $this->hideSubordinates($member->getSubordinates());
        }
    }
    /*
     * arrested
     * 
     * the current member is in jail, all his subordinates are assigned to the elder member 
     * at the same level of the current member, if there are no other member, the elder subortinate is
     * promoted
     */
    public function arrested() {
        $this->free = false;
        $this->location = "jail";
        $newBoss = $this->getNewBoss();
        if ($newBoss) {
            foreach ($this->getSubordinates() as $key => $member) {
                $member->original_boss = $this;
                $newBoss->addSubordinate($member);
            }
        } else {
            $newBoss = $this->promote();
            $newBoss->original_boss = $this;
            if (!$newBoss) {
                throw new Exception("There are no more bosses");
                return false;
            }
            foreach ($this->subordinates as $key => $member) {
                if ($member !== $newBoss) {
                    $newBoss->addSubordinate($member);
                }
            }
            $this->boss->addSubordinate($newBoss);
            $this->subordinates = array();
        }

        $this->subordinates = array();
    }
    /*
     * get the new boss for the subordinates
     */
    private function getNewBoss() {
        $level = $this->getBoss()->getSubordinates();
        $newBoss = 1;
        $age = 0;
        if (!count($level)) {
            return false;
        }
        foreach ($level as $key => $boss) {
            if ($boss !== $this && $boss->free !== false) {
                if ($boss->age > $age) {
                    $newBoss = $boss;
                    $age = $boss->age;
                    return $newBoss;
                }
            }
        }
        return false;
    }
    /*
     * if no newBoss is available, the elder subordinate will be promoted
     */ 
    private function promote() {
        $level = $this->getSubordinates();
        $newBoss = 1;
        $age = 0;
        if (!count($level)) {
            return false;
        }
        foreach ($level as $key => $boss) {
            if ($boss->age > $age && $boss->free !== false) {
                $newBoss = $boss;
                $age = $boss->age;
                return $newBoss;
            }
        }
        return false;
    }
    /*
     * the current member is release and will take his old place in the organisation with all his 
     * old subordinates
     */
    public function released($mafia) {
        $this->free = true;
        $this->location = "known";
        $this->restore($mafia);
        if (count($this->remove)) {
            foreach ($this->remove as $j => $r) {
                $this->removeSubordinate($r["boss"], $r["subordinates"]);
            }
        }
    }
    /*
     * restore the subordinates
     */
    private function restore($child) {

        if (!is_array($child)) {
            $child = $child->oganisation;
        }
        if (is_array($child)) {
            foreach ($child as $k => $v) {
                if ($v->original_boss === $this) {
                    $this->removeSubordinate($v->getBoss(), $v);
                    $this->addSubordinate($v);
                    $v->original_boss = false;
                }
                if (count($v->subordinates)) {
                    $this->restore($v->subordinates);
                }
            }
        }
    }
    /*
     * the current member is hidden
     */
    public function hidden() {
        $this->location = "undisclosed";
        $this->active = false;
    }
    /*
     * add subordinate to the current member
     */
    public function addSubordinate($subordinate) {
        if ($subordinate instanceof MafiaMember) {
            $this->subordinates[] = $subordinate->addBoss($this);
        }
        return $this;
    }

    /*__get
     * 
     * magic get to retrieve private properties
     */
    public function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

}
