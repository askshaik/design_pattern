<?php
declare (strict_types=1);
use pht\{Thread, Runnable, HashTable};
class DiceProbablity implements Runnable {
    const SIMULATE_THROWS = 100000;
    const MAX_DICE_VALUE = 6;
    /**@var int[] */     private $valuesAccumulated;
    /**@var HashTable */ private $totalValues;
    function __construct(HashTable $totalValues) {
        $this->totalValues = $totalValues;
        $this->initializeValuesAccumulated();
    }
    private function initializeValuesAccumulated(): void {
        for ($i = 2; $i <= self::MAX_DICE_VALUE * 2; $i++)
            $this->valuesAccumulated[$i] = 0;
    }
    private static function diceThrow(): int {
        return mt_rand(1, self::MAX_DICE_VALUE);
    }
    private function throwTwoDices(): void {
        $this->valuesAccumulated[self::diceThrow() + self::diceThrow()]++;
    }
    private function updateTotals() {
        $this->totalValues->lock();
        foreach($this->valuesAccumulated as $dice=>$times)
            $this->totalValues[$dice] += $times;
        $this->totalValues->unlock();
    }
    public function run() {
        for ($i=0; $i<self::SIMULATE_THROWS; $i++)
            $this->throwTwoDices();
        $this->updateTotals();
    }
}
const MIN_DICE_VALUE_FOR_TWO_DICES = 2;
$totals = new HashTable();
for ($dice_value=MIN_DICE_VALUE_FOR_TWO_DICES; $dice_value <= DiceProbablity::MAX_DICE_VALUE * 2; $dice_value++)
    $totals[$dice_value] = 0;
const NO_OF_PROCESSOR_CORES = 4;
for ($i=0; $i<NO_OF_PROCESSOR_CORES; $i++) {
    $threads[$i] = new Thread();
    $threads[$i]->addClassTask(DiceProbablity::class, $totals);
    $threads[$i]->start();
}
for ($i=0; $i<NO_OF_PROCESSOR_CORES; $i++)
    $threads[$i]->join();
$total_throws = NO_OF_PROCESSOR_CORES * DiceProbablity::SIMULATE_THROWS;
for ($dice_value=MIN_DICE_VALUE_FOR_TWO_DICES; $dice_value <= DiceProbablity::MAX_DICE_VALUE * 2; $dice_value++)
    printf("The probability of %d is %f\n", $dice_value, $totals[$dice_value] / $total_throws);

