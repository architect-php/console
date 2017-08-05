<?php
/**
 * app
 * User: Damien Rose <br0kenb1nary@users.noreply.github.com>
 * Date: 2017-08-03
 * Time: 1:32 PM
 */

namespace Architect\Console\Definitions;

use Architect\Architect;
use Architect\Foundation\Bootstrap\FoundationBootstrap;

class ConsoleParameterDefinition
{
    public $name = '';

    public $required = true;

    public $default = null;

    public $position = 0;

    public function __construct( $name, $required = true, $default = false )
    {
        $this->name     = $name;
        $this->required = $required === 'required' ? true : false;
        $this->default  = $default;
        $this->position = Architect::$count + 1;
    }
}