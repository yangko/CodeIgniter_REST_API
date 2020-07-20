<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('pr'))
{

    /**

     * Returns nicely fomatted array

     * this can be used for debugging purposes

     *

     * @param  array $data

     * @return void

     */

    function pr($data, $ex = false)

    {

        echo "<pre>";

        print_r($data);

        echo "</pre>";

        if($ex)

        {

            exit;

        }

    }

}

 

if (! function_exists('vd'))

{

    /**

     * Returns nicely fomatted var_dump

     * this can be used for debugging purposes

     *

     * @param  mixed $data

     * @return void

     */

    function vd($data, $ex = false)

    {

        echo "<pre>";

        var_dump($data);

        echo "</pre>";

        if($ex)

        {

            exit;

        }

    }

}

 

if (! function_exists('validate_date'))

{

    /**

     * Validate if a string represents a valid Date or Time.

     *

     * @param  str $date

     * @param  bool $strict

     * @return mixed

     */

    function validate_date($date, $strict = true)

    {

        $dateTime = DateTime::createFromFormat('Y-m-d', $date);

        if ($strict)

        {

            $errors = DateTime::getLastErrors();

            if (!empty($errors['warning_count']))

            {

                return false;

            }

        }

        return $dateTime !== false;

    }

}

 