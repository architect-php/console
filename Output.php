<?php
/**
 * app
 * User: Damien Rose <br0kenb1nary@users.noreply.github.com>
 * Date: 2017-08-03
 * Time: 3:53 PM
 */

namespace Architect\Console;

class Output
{
    public static function success( $message )
    {
        printf( "\033[0;" . LIGHT_GREEN . "m$message\t\t\033[0m\n" );
    }

    public static function info( $message )
    {
        printf( "\033[0;" . LIGHT_BLUE . "m$message\t\t\033[0m\n" );
    }

    public static function warning( $message )
    {
        printf( "\033[0;" . YELLOW . "m$message\t\t\033[0m\n" );
    }

    public static function error( $message )
    {
        printf( "\033[0;" . RED . "m$message\t\t\033[0m\n" );
    }
}