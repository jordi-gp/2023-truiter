<?php

    namespace App\Helpers;
    /**
    * Class FlashMessage
    * Aquesta classe llig i escriu directament en una variable de sessió
    * que serà un array, la clau serà $sessionKey  de forma que evitem
    * possible col·lisions.
    */
    class FlashMessage
    {
        /**
         * string
         */

        const SESSION_KEY = "flash-message";

        /**
         * obtenim el valor de l'array associat a la clau.
         * després de llegir-lo l'esborrem
         * si no existeix tornem el valor indicat per defecte.
         * @param string $key
         * @param null|array $defaultValue
         * @return null|string
         */
        public static function get(string $key, null|array $defaultValue = []):mixed
        {
            # Retorna el valor de la variable de sessió
            $key_value = $_SESSION[self::SESSION_KEY][$key] ?? $defaultValue;
            self::unset($key);
            return $key_value;
        }

        /**
         * @param string $key
         * @param $value
         */
        public static function set(string $key, $value)
        {
            $_SESSION[self::SESSION_KEY][$key] = $value;
        }

        /**
         * @param string $key
         */
        private static function unset(string $key)
        {
            unset($_SESSION[self::SESSION_KEY][$key]);
        }
    }