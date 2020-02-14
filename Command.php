<?php
declare (strict_types=1);

class Light {
    function on() : void {
        printf("Light on\n");
    }
    function off() : void {
        printf("Light off\n");
    }
}
class Fan {
    function fanOn() : void {
        printf("Fan on\n");
    }
    function fanOff() : void {
        printf("Fan off\n");
    }
}
interface Command {
    function execute() : void;
    function undo() : void;
}
class FanOn implements Command {
    /**@var Fan*/ private $fan;
    function __construct(Fan $f) {
        $this->fan = $f;
    }
    function execute() : void {
        $this->fan->fanOn();
    }
    function undo() : void {
        $this->fan->fanOff();
    }
}
class FanOff implements Command {
    /**@var Fan*/ private $fan;
    function __construct(Fan $f) {
        $this->fan = $f;
    }
    function execute() : void {
        $this->fan->fanOff();
    }
    function undo() : void {
        $this->fan->fanOn();
    }
}
class LightOn implements Command {
    /**@var Light*/ private $light;
    function __construct(Light $light) {
        $this->light = $light;
    }
    function execute() : void {
        $this->light->on();
    }
    function undo() : void {
        $this->light->off();
    }
}
class LightOff implements Command {
    /**@var Light*/ private $light;
    function __construct(Light $light) {
        $this->light = $light;
    }
    function execute() : void {
        $this->light->off();
    }
    function undo() : void {
        $this->light->on();
    }
}
class RemoteControl {
    /**@var Command[]*/ private $buttons;
    /**@var Light*/     private $light;
    /**@var Fan*/       private $fan;
    /**@var Command*/   private $last;
    function __construct() {
        $this->light = new Light();
        $this->fan = new Fan();
        $this->buttons = [ 1=>new LightOn($this->light), 2=>new LightOff($this->light),
                           3=>new FanOn($this->fan),     4=>new FanOff($this->fan)];
    }
    function buttonPressed(int $number) : void {
        $this->last = $this->buttons[$number];
        $this->last->execute();
    }
    function undo() : void {
        $this->last->undo();
    }
}
$rm = new RemoteControl();
$rm->buttonPressed(1);
$rm->buttonPressed(2);
$rm->undo();
