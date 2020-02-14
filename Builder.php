<?php
declare (strict_types=1);

class C1 {
    /**@var int*/ private $a;
    /**@var int*/ private $b;
    /**@var int*/ private $c;
    function __construct(int $a, int $b, int $c) {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }
    //...
}
class C1Builder {
    /**@var int*/ private $a;
    /**@var int*/ private $b;
    /**@var int*/ private $c;
    function setA(int $a) : C1Builder{
        $this->a = $a;
        return $this;
    }
    function setB(int $b) : C1Builder{
        $this->b = $b;
        return $this;
    }
    function setC(int $c) : C1Builder{
        $this->c = $c;
        return $this;
    }
    function giveInstance() : C1 {
        if (!isset($this->a)) $this->a=5;
        if (!isset($this->b)) $this->b=6;
        if (!isset($this->c)) $this->c=50;
        return new C1($this->a, $this->b, $this->c);
    }
}

$o = (new C1Builder())->setA(20)->setC(10)->giveInstance();
var_dump($o);