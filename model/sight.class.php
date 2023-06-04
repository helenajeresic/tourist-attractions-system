<?php


class Sight
{
    private $id;
    private $name;
    private $desc;
    private $image;
    private $x_coord;
    private $y_coord;

    function __construct( $id, $name, $desc, $image, $x_coord, $y_coord )
	{
		$this->id = $id;
		$this->name = $name;
		$this->desc = $desc;
        $this->image = $image;
        $this->x_coord = $x_coord;
		$this->y_coord = $y_coord;
	}

    function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }

}