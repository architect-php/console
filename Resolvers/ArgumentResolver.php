<?php
/**
 * app
 * User: Damien Rose <br0kenb1nary@users.noreply.github.com>
 * Date: 2017-08-03
 * Time: 11:02 AM
 */

namespace Architect\Console\Resolvers;

use Architect\Console\Definitions\ConsoleArgumentDefinition;
use Architect\Console\Input;
use Architect\Console\Output;
use Architect\Event\Emitter;
use Architect\Foundation\Collection;
use Architect\Foundation\PipeCollection;

class ArgumentResolver
{
    use Emitter {
        emit as public;
    }

    protected $commandArguments = [];

    public $bound = false;

    public function getCommandArguments()
    {
        return $this->commandArguments;
    }

    public function setCommandArguments( $commandArguments )
    {
        foreach ( new PipeCollection( $commandArguments ) as $argument ) {
            $this->commandArguments[] = new ConsoleArgumentDefinition( ...$argument );
        }
        return $this;
    }

    protected function missingRequiredArgument( $command )
    {
        Output::warning( "Missing required arguments(s) '$parameter' for $command\n" );
    }

    public function assembleArgumentBindings( Input &$input )
    {
        $collection = new Collection( ...$this->getCommandArguments() );
        foreach ( $collection as $argument ) {
            if ( ! $input->getArgument( $argument->name ) && $argument->required ) {
                $this->missingRequiredArgument( $argument->name );
                return;
            }
            if ( ! $input->getArgument( $argument->name ) && ! $argument->required ) {
                $input->addArgument( $argument->name, $argument->default );
            }
        }
        $this->bound = true;
    }
}