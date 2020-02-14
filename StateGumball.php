<?php
declare (strict_types=1);
abstract class State {
    /**@var GumballMachine*/ protected $g;
    function __construct(GumballMachine $g) {
        $this->g = $g;
    }
    function coinInserted() : State {
		return $this;
	}
	function leverTurned() : State {
		return $this;
	}
	function ejectPressed() : State {
		return $this;
	}
	function hasGumballs() : bool {
		return $this->g->hasGumballs();
	}
}
class NoQuaterState extends State {
    function __construct(GumballMachine $g) {
        parent::__construct($g);
    }
	function coinInserted() : State {
		return new HasQuaterState($this->g);
	}
}
class HasQuaterState extends State {
    function __construct(GumballMachine $g) {
        parent::__construct($g);
    }
	function coinInserted() : State {
        printf("Coin refund\n");
		return $this;
	}
	function leverTurned() : State {
        $this->g->dispenseGumball();
		return $this->hasGumballs()? new NoQuaterState($this->g) : new SoldOutState($this->g);
	}
	function ejectPressed() : State {
        printf("Coin refund\n");
		return new NoQuaterState($this->g);
	}
}
class SoldOutState extends State {
    function __construct(GumballMachine $g) {
        parent::__construct($g);
    }
	function coinInserted() : State {
        printf("Coin refund\n");
		return $this;
	}
}
class GumballMachine {
    /**@var int*/ private $gumballs;
    /**@var State*/ private $s;
    function __construct(int $gumballs) {
        $this->gumballs = $gumballs;
        $this->s = new NoQuaterState($this);
    }
	function coinInstered() : void {
        $this->s = $this->s->coinInserted();
	}
	function leverTurned() : void {
        $this->s = $this->s->leverTurned();
	}
	function ejectPressed() : void {
        $this->s = $this->s->ejectPressed();
	}
	function dispenseGumball() {
        printf("Gumball dispensed\n");
        $this->gumballs--;
    }
	function hasGumballs() : bool {
		return $this->gumballs > 0;
	}
}
$g = new GumballMachine(2);
$g->coinInstered();
$g->leverTurned();
$g->coinInstered();
$g->leverTurned();
$g->coinInstered();
$g->leverTurned();

