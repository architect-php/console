<?php
/**
 * app
 * User: Damien Rose <br0kenb1nary@users.noreply.github.com>
 * Date: 2017-08-02
 * Time: 11:08 PM
 */

namespace Architect\Console;

use Architect\Architect;
use Architect\Console\Resolvers\CommandResolver;
use Architect\Container\Container;
use Architect\Event\Emitter;
use Architect\Interpreter\ArgumentParser;
use RecursiveDirectoryIterator;

class Application extends Container
{
    use Emitter {
        on as public;
    }

    protected $appName, $appVersion;

    protected $commands = [];

    public function __construct( $appName = 'architect$ ', $appVersion = '' )
    {
        $this->appName    = $appName;
        $this->appVersion = $appVersion;
        $this->registerEmitter();
        $this->addCommands( Architect::framework( '/Foundation/Commands' ), '\Architect\Foundation\Commands\\' );
    }

    protected function addCommand( $instance )
    {
        $reflection                        = new \ReflectionClass( $instance );
        $concrete                          = $reflection->newInstanceWithoutConstructor();
        $this->commands[ $concrete->name ] = $concrete;
    }

    public function addCommands( $directory, $namespace = '\App\Console\Commands\\' )
    {
        foreach ( new RecursiveDirectoryIterator( $directory, RecursiveDirectoryIterator::SKIP_DOTS ) as $file ) {
            $this->addCommand( $namespace . basename( $file->getFileName(), '.php' ) );
        }
    }

    public function save( Input $input )
    {
//        $write = sprintf("Saving command %s\n",$input->getArgument( 'save'));
//        Output::info( $write);
//
//        $ask = readline('Do you want to run the command now?');
//        if($ask === 'yes' || $ask === 'y'){
//            Output::success( 'Starting command...');
//        }else{
//            Output::warning( 'Ok, hanging on to it for later...');
//        }
    }

    public function resolve( Input $input )
    {
        if ( $requiresSave = $input->getArgument( 'save' ) ) {
            $this->save( $input );
        }
        if ( array_key_exists( $input->getCommand(), $this->commands ) ) {
            $commandResolver = new CommandResolver( $this->commands[ $input->getCommand() ] );
            return $commandResolver->execute( $input );
        }
        return Output::warning( "No command exists for {$input->getCommand()}" );
    }

    public function run()
    {
        $this->on( 'repl', ( function ( ArgumentParser $argumentParser ) {
            $this->resolve( $argumentParser->parse() );
        } ), $this );
        $repl = new Repl( $this->appName );
        $repl->clearTerminal();
        $repl->register();
    }
}