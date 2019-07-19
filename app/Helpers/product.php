<?php

Class Product extends \Illuminate\Support\Collection
{
    public function __construct($items) {

        parent::__construct($items);
    }
}

function product( $data )
{
    if( isset( $data->_source ) )
    {
        $data = $data->_source;
    }

    return (new Product($data));
}