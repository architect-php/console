<?php
/**
 * app
 * User: Damien Rose <br0kenb1nary@users.noreply.github.com>
 * Date: 2017-08-02
 * Time: 11:08 PM
 */

namespace Architect\Console;

use Architect\Event\Emitter;
use Architect\Interpreter\ArgumentParser;

class Repl
{
    use Emitter {
        emit as public;
    }

    protected $appName;

    public function __construct( $appName )
    {
        $this->appName = $appName;
        $this->registerEmitter();
    }

    public function clearTerminal()
    {
        return isWindowsOperatingSystem() ? system( 'clear' ) : system( 'cls' );
    }

    public function register( $response = null )
    {
        while ( $response === null ) {
            $this->emit( 'repl', new ArgumentParser( readline( $this->appName ) ) );
        }
    }
}