<?php

namespace App\Traits;

/*
    if controllers catch an exception with an error code that isn't a http error code then replace the error code with 500
*/

trait CheckErrorCode
{
    public function checkErrorCode(int $errorCode)
    {
        $status_code = array("100", "101", "200", "201", "202", "203", "204", "205", "206", "300", "301", "302", "303", "304", "305", "306", "307", "400", "401", "402", "403", "404", "405", "406", "407", "408", "409", "410", "411", "412", "413", "414", "415", "416", "417", "422", "500", "501", "502", "503", "504", "505");

        return in_array($errorCode, $status_code) ? $errorCode : 500;
    }
}
