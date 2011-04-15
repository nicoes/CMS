<?php

class Zend_View_Helper_Error extends Zend_View_Helper_Abstract
{
    function error($message)  {
        return '<div class="error-message" style="background-color:red">'.$message.'</div>';
    }
}

?>