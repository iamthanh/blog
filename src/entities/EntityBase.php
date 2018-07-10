<?php

namespace Entities;

class EntityBase {

    /**
     * This function will convert a given array to an object
     *
     * @param array $array
     * @return $this|bool
     */
    public function convertArrayToObject(array $array) {
        if (!empty($array)) {
            foreach ($array as $key=>$value) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }

            return $this;
        }

        return false;
    }

}