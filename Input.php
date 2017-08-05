<?php
/**
 * app
 * User: Damien Rose <br0kenb1nary@users.noreply.github.com>
 * Date: 2017-08-03
 * Time: 10:20 AM
 */

namespace Architect\Console;

class Input
{
    protected $command = '';

    protected $parameters = [];

    protected $arguments = [];

    protected $options = [];

    public function __construct() { }

    /**
     * @return string
     */
    public function getCommand() : string
    {
        return $this->command;
    }

    /**
     * @param string $command
     * @return Input
     */
    public function setCommand( string $command ) : Input
    {
        $this->command = $command;
        return $this;
    }

    /**
     * @return array
     */
    public function getParameters() : array
    {
        return $this->parameters;
    }

    public function getParameter( $offset )
    {
        if ( ! is_string( $offset ) ) {
            return isset( $this->parameters[ $offset ] ) ? $this->parameters[ $offset ] : false;
        }
        return isset( $this->parameters[ $offset ] ) ? $this->parameters[ $offset ] : false;
    }

    public function setParameter( $offset, $value, $position = false )
    {
        if ( $position ) {
            $key = $this->parameters[ $offset ];
            unset( $this->parameters[ $offset ] );
            $this->parameters[ $key ] = $value;
            return;
        } else {
            $this->parameters[ $offset ] = $value;
            return;
        }
    }

    /**
     * @param array $parameters
     * @return Input
     */
    public function setParameters( array $parameters ) : Input
    {
        $this->parameters = $parameters;
        return $this;
    }

    public function addParameter( $parameter )
    {
        $this->parameters[] = $parameter;
        return $this;
    }

    /**
     * @return array
     */
    public function getArguments() : array
    {
        return $this->arguments;
    }

    public function getArgument( $name )
    {
        return isset( $this->arguments[ $name ] ) ? $this->arguments[ $name ] : false;
    }

    /**
     * @param array $arguments
     * @return Input
     */
    public function setArguments( array $arguments ) : Input
    {
        $this->arguments = $arguments;
        return $this;
    }

    public function addArgument( $argument, $value = true )
    {
        $this->arguments[ $argument ] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions() : array
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return Input
     */
    public function setOptions( array $options ) : Input
    {
        $this->options = $options;
        return $this;
    }
}