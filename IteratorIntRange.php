<?php
declare (strict_types=1);
class IteratorIntRange implements iterator {
    /** @var int */ private $lower;
    /** @var int */ private $higher;
    /** @var int */ private $current;
    function __construct(int $lower, int $higher) {
        $this->current = $this->lower = $lower;
        $this->higher = $higher;
    }
    function hasNext(): bool {
        return $this->current <= $this->higher;
    }
    function next() :void {
        $this->current++;
    }
    public function current() : int{
        return $this->current;
    }
    public function key() {
        return $this->current - $this->lower;
    }
    public function valid() {
        return $this->hasNext();
    }
    public function rewind() {
        $this->current = $this->lower;
    }
}
$r=new IteratorIntRange(2,10);
foreach ($r as $v)
    printf("%d\n", $v);
