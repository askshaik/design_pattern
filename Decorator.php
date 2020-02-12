<?php
declare (strict_types=1);

interface Beverage {
    function cost() : int;
    function dispense() : void;
}

class Tea implements Beverage {
    function cost() : int {
        return 10;
    }
    function dispense() : void {
        printf("Tea dispensed\n");
    }
}

class Coffee implements Beverage {
    function cost() : int {
        return 15;
    }
    function dispense() : void {
        printf("Coffee dispensed\n");
    }
}
abstract class CondimentDecorator implements Beverage {
    /** @var Beverage */ protected $b;
    function __construct(Beverage $b) {
        $this->b = $b;
    }
}
class Milk extends CondimentDecorator {
    public function __construct(Beverage $b) {
        parent::__construct($b);
    }
    function cost() : int {
        return 2 + $this->b->cost();
    }
    function dispense() : void {
        $this->b->dispense();
        printf("Milk dispensed\n");
    }
}
class Sugar extends CondimentDecorator {
    public function __construct(Beverage $b) {
        parent::__construct($b);
    }
    function cost() : int {
        return 1 + $this->b->cost();
    }
    function dispense() : void {
        printf("Sugar dispensed\n");
        $this->b->dispense();
    }
}

function printInfo(Beverage $b) {
    printf("The cost is %d\n", $b->cost());
    $b->dispense();
}
printInfo(new Sugar(new Milk(new Tea())));
