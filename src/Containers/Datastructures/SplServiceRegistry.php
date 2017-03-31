<?php
/**
 * v6.0.0-svn
 *
 * @author      Steeve Andrian Salim
 * @created     17/11/2016 07:48
 * @copyright   Copyright (c) 2016 Steeve Andrian Salim
 */

namespace O2System\Spl\Containers\Datastructures;


use O2System\Spl\Info\SplClassInfo;

class SplServiceRegistry extends SplClassInfo
{
    /**
     * Service Singleton Instance
     *
     * @var object
     */
    private $instance;

    public function __construct( $service )
    {
        if ( is_object( $service ) ) {
            $this->instance = $service;
            $service = get_class( $service );
        }

        parent::__construct( $service );
    }

    public function getClassName()
    {
        return get_class_name( $this->name );
    }

    public function &getInstance()
    {
        if ( empty( $this->instance ) ) {
            $this->instance = $this->newInstance( func_get_args() );
        }

        return $this->instance;
    }
}