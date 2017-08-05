<?php
/**
 * app
 * User: Damien Rose <br0kenb1nary@users.noreply.github.com>
 * Date: 2017-08-03
 * Time: 11:37 AM
 */

namespace Architect\Console\Resolvers;

class CommandResolver
{
    public $name = '';

    public $concrete;

    public $instance;

    public function __construct( $command )
    {
        $this->instance = $this->fragment( $command );
        $this->name     = $this->instance->name;
        $this->concrete = $this->instance;
    }

    public function fragment( $command )
    {
        $reflection = new \ReflectionClass( $command );
        return $reflection->newInstanceWithoutConstructor();
    }

    public function resolveArguments( $input )
    {
        $argumentResolver = new ArgumentResolver();
        $argumentResolver->setCommandArguments( ( isset( $this->instance->arguments ) ) ? $this->instance->arguments : [] );
        $argumentResolver->assembleArgumentBindings( $input );
        if ( $argumentResolver->bound ) {
            return true;
        }
    }

    public function resolveParameters( $input )
    {
        $parameterResolver = new ParameterResolver();
        $parameterResolver->setCommandParameters( ( isset( $this->instance->parameters ) ) ? $this->instance->parameters : [] );
        $parameterResolver->assembleParameterBindings( $input );
        if ( $parameterResolver->bound ) {
            return true;
        }
    }

    public function execute( $input )
    {
        if ( $this->resolveArguments( $input ) && $this->resolveParameters( $input ) ) {
            $this->instance->execute( $input );
        }
    }
}