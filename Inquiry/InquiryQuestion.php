<?php
/**
 * app
 * User: Damien Rose <br0kenb1nary@users.noreply.github.com>
 * Date: 2017-08-03
 * Time: 6:50 PM
 */

namespace Architect\Console\Inquiry;

class InquiryQuestion
{
    protected $question, $answers;

    public function __construct( $question, $answers = 'yes | no' )
    {
        $this->question = $question;
        $this->answers  = $answers;
    }

    public static function ask( $question, $answers = 'yes | no' )
    {
        return ( new static( $question, $answers ) )->prompt( $question );
    }

    protected function prompt( $question )
    {
        $response = null;
        while ( $response == null ) {
            $response = readline( $question );
            return new InquiryAnswer( $question, $response );
        }
    }
}