<?php
/**
 * app
 * User: Damien Rose <br0kenb1nary@users.noreply.github.com>
 * Date: 2017-08-03
 * Time: 6:50 PM
 */

namespace Architect\Console\Inquiry;

class InquiryAnswer
{
    protected $response;

    protected $resolved = false;

    public function __construct( $question, $response )
    {
        $this->response = $response;
    }

    public function on( string $response, $callback )
    {
        if ( $this->response === $response ) {
            $this->resolved = true;
            call_user_func( $callback );
            return $this;
        }
        return $this;
    }

    public function default( $response )
    {
        return $this->resolved ? : printf( "%s\n", $response );
    }
}