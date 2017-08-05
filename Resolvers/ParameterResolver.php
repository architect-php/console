<?php
/**
 * app
 * User: Damien Rose <br0kenb1nary@users.noreply.github.com>
 * Date: 2017-08-03
 * Time: 1:31 PM
 */

namespace Architect\Console\Resolvers;

use Architect\Console\Definitions\ConsoleParameterDefinition;
use Architect\Console\Input;
use Architect\Console\Output;
use Architect\Foundation\Collection;
use Architect\Foundation\PipeCollection;

class ParameterResolver
{
    protected $commandParameters = [];

    public $bound = false;

    public function getCommandParameters()
    {
        return $this->commandParameters;
    }

    public function setCommandParameters( $commandParameters )
    {

        foreach ( new PipeCollection( $commandParameters ) as $collection ) {
            $this->commandParameters[] = new ConsoleParameterDefinition( ...$collection );
        }
        return $this;
    }

    protected function missingRequiredParameter( $parameter, $command )
    {
        Output::warning( "Missing required parameter(s) '$parameter' for $command\n" );
    }

    public function assembleParameterBindings( Input &$input )
    {
        $collection = new Collection( ...$this->getCommandParameters() );
        foreach ( $collection as $parameter ) {
            if ( ! $input->getParameter( $parameter->position ) && $parameter->required ) {
                $this->missingRequiredParameter( $parameter->name, $input->getCommand() );
                return;
            } else {
                $input->setParameter( $parameter->name, $input->getParameter( $parameter->position ) );
            }
            if ( ! $input->getArgument( $parameter->name ) && ! $parameter->required ) {
                $input->setParameter( $parameter->name, $parameter->default );
            }
        }
        $this->bound = true;
    }
}