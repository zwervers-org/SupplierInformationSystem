<?php

// errors weergeven
ini_set('display_errors',0); // 1 == aan , 0 == uit
error_reporting(E_ALL | E_STRICT);

# sql debug
define('DEBUG_MODE',false);  // true == aan, false == uit

# functie voor sql debug
    function showSQLError($sql,$error,$text='Error')
    {
        if (DEBUG_MODE)
        {
            return  '<div id=error><pre>Error:'.$error.'<br />'.$sql.'</pre></div>';
        }
        else
        {
            return '<div id=error>'.$text.'</div>';
        }
    }  
?>