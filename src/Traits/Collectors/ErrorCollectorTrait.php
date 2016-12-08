<?php
/**
 * This file is part of the O2System PHP Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author         Steeve Andrian Salim
 * @copyright      Copyright (c) Steeve Andrian Salim
 */
// ------------------------------------------------------------------------

namespace O2System\Spl\Traits\Collectors;

// ------------------------------------------------------------------------

trait ErrorCollectorTrait
{
    private $errors = [ ];

    // ------------------------------------------------------------------------

    public function setErrors ( array $errors )
    {
        $this->errors = $errors;
    }

    // ------------------------------------------------------------------------

    public function addErrors ( array $errors )
    {
        foreach ( $errors as $error ) {
            $this->addError( $error[ 'code' ], $error[ 'message' ] );
        }
    }

    // ------------------------------------------------------------------------

    public function addError ( $code, $message )
    {
        $this->errors[ $code ] = $message;
    }
}