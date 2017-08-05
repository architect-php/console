<?php
/**
 * app
 * User: Damien Rose <br0kenb1nary@users.noreply.github.com>
 * Date: 2017-08-03
 * Time: 9:59 AM
 */

namespace Architect\Console\Definitions;

class ConsoleArgumentDefinition
{
    public $name = '';

    public $required = true;

    public $default = null;

    public function __construct( $name, $required = true, $default = false )
    {
        $this->name     = $name;
        $this->required = $required === 'required' ? true : false;
        $this->default  = $default;
    }
}