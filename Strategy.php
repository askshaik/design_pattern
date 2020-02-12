<?php
declare (strict_types=1);

interface Flyable {
    function fly() : void;
}
class FlyWithWings implements Flyable {
    function fly() : void {
        printf("Duck flying\n");
    }
}
class FlyNo implements Flyable {
    function fly() : void {
        printf("Duck stationary\n");
    }
}

interface Quackable {
    function speak() : void;
}
class QuackNormal implements Quackable {
    function speak() : void {
        printf("Duck quacking\n");
    }
}
class QuackSqueak implements Quackable {
    function speak() : void {
        printf("Duck squeaking\n");
    }
}
class QuackNone implements Quackable {
    function speak() : void {
        printf("Duck silent\n");
    }
}

abstract class Duck {
    /** @var Flyable */     private $flyingBehaviour;
    /** @var Quackable */   private $quackingBehaviour;
    function __construct(Flyable $flyingBehaviour, Quackable $quackingBehaviour) {
        $this->flyingBehaviour = $flyingBehaviour;
        $this->quackingBehaviour = $quackingBehaviour;
    }
    function swim() : void {
        printf("Duck swimming\n");
    }
    function display() : void {
        printf("Duck painted\n");
    }
    function fly() : void {
        $this->flyingBehaviour->fly();
    }
    function makeNoise() : void {
        $this->quackingBehaviour->speak();
    }
}

class DecoyDuck extends Duck {
    function __construct() {
        parent::__construct(new FlyNo(), new QuackNone());
    }
}

class RedHeadDuck extends Duck {
    function __construct() {
        parent::__construct(new FlyWithWings(), new QuackNormal());
    }
}

class WhiteSmallDuck extends Duck {
    function __construct() {
        parent::__construct(new FlyNo(), new QuackNormal());
    }
}

class RubberDuck extends Duck {
    function __construct() {
        parent::__construct(new FlyNo(), new QuackSqueak());
    }
}

function process (Duck $d) {
    $d->swim();
    $d->display();
    $d->fly();
    $d->makeNoise();
}
process(new DecoyDuck());

