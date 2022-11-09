<?php

/* our simple php ping function */

function ping($host,$port=80,$timeout=6)
{
        $fsock = fsockopen($host, $port, $errno, $errstr, $timeout);
        if ( ! $fsock )
        {
                return FALSE;
        }
        else
        {
                return TRUE;
        }
}
/* check if the host is up
        $host can also be an ip address */
$host = '200.27.233.248:443';
$up = ping($host);

/* optionally display either a red or green image to signify the server status */
echo '<img src="'.($up ? 'on' : 'off').'.jpg" alt="'.($up ? 'up' : 'down').'" />';

?>