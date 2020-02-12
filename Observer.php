<?php
declare (strict_types=1);

interface Observer {
    function update(Observable $o) : void;
}
abstract class Observable {
    /** @var Observer[] */private $observers = [];
    function addObserver(Observer $o) : void {
        $this->observers[] = $o;
    }
    function notifyObservers() : void {
        foreach ($this->observers as $o)
            $o->update($this);
    }
}

class WeatherMeasurer extends Observable {
    function change() : void {
        $this->notifyObservers();
    }
    function getTemperature() : int {
        return 25;
    }
}

class MaxMinTemp implements Observer {
    /** @var WeatherMeasurer */ private $wm;
    function __construct(WeatherMeasurer $wm) {
        $this->wm = $wm;
        $wm->addObserver($this);
    }
    function update(Observable $o): void {
        printf("Temp changed to %d\n", $this->wm->getTemperature());
    }
}

class Forecaster implements Observer {
    /** @var WeatherMeasurer */ private $wm;
    function __construct(WeatherMeasurer $wm) {
        $this->wm = $wm;
        $wm->addObserver($this);
    }
    function update(Observable $o): void {
        printf("Forecast changed for temp %d\n", $this->wm->getTemperature());
    }
}

$wm = new WeatherMeasurer();
$m1 = new MaxMinTemp($wm);
$m2 = new Forecaster($wm);
$wm->change();
