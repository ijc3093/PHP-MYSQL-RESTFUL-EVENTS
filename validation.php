<?php
/**
 * validate every input and sanitize it
 */
  
    class ValidatoR{
        static function numeric($value){
            if(strlen($value) == 0){
                return false;
            }
            return true;
        }
        static function validate($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    }