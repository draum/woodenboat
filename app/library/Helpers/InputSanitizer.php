<?php

namespace WBDB\Helpers;
/**
 * InputSanitizer
 *
 */
class InputSanitizer {

    /**
     * InputSanitizer::globalXssClean()
     * Recursive cleaning for Laravel's Input
     *
     * @return
     */
    public static function globalXssClean() {
        $sanitized = static::arrayStripTags(\Input::get());
        \Input::merge($sanitized);
    }

    /**
     * InputSanitizer::arrayStripTags()
     *
     * @param array $array
     * @return array $result
     */
    public static function arrayStripTags($array) {
        $result = array();

        foreach ($array as $key => $value) {
            // Don't allow tags on key either, maybe useful for dynamic forms.
            $key = strip_tags($key);

            // If the value is an array, we will just recurse back into the
            // function to keep stripping the tags out of the array,
            // otherwise we will set the stripped value.
            if (is_array($value)) {
                $result[$key] = static::arrayStripTags($value);
            } else {
                $result[$key] = trim(strip_tags($value));
            }
        }

        return $result;
    }

}
