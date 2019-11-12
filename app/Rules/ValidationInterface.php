<?php


namespace App\Rules;


interface ValidationInterface
{
    public function validate($field, $value, $params, $fields);
}