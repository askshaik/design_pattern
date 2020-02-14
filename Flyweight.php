<?php
declare (strict_types=1);
class Point1 {
    /**@var int*/ private $x;
    /**@var int*/ private $y;
    function __construct(int $x, int $y) {
        $this->x = $x;
        $this->y = $y;
    }
    public function getX(): int {
        return $this->x;
    }
    public function setX(int $x): void {
        $this->x = $x;
    }
    public function getY(): int {
        return $this->y;
    }
    public function setY(int $y): void {
        $this->y = $y;
    }
	function move(int $dx, int $dy) : void {
        $this->x += $dx;
        $this->y += $dy;
    }
	//The functions "hash" and "equals" can be added
}

class Point2 {
    /**@var int*/ private $x;
    /**@var int*/ private $y;
    function __construct(int $x, int $y) {
        $this->x = $x;
        $this->y = $y;
    }
    public function getX(): int {
        return $this->x;
    }
    public function getY(): int {
        return $this->y;
    }
	function move(int $dx, int $dy) : Point2 {
        return new Point2($this->x + $dx, $this->y + $dy);
    }
    //The functions "hash" and "equals" can be added
}
