<?php
declare (strict_types=1);
interface DiskObject {
    function getSize() : int;
}
class File implements DiskObject {
    /**@var string*/ private $name;
    /**@var int*/ private $size;
    function __construct(string $name, int $size) {
        $this->name = $name;
        $this->size = $size;
    }
    function getSize(): int {
        return $this->size;
    }
    //....
}
class Directory1 implements DiskObject {
    /** @var DiskObject[] */ public $children = [];
    function getSize(): int {
        $sum = 0;
        foreach($this->children as $do)
            $sum += $do->getSize();
        return $sum;
    }
}
function printSize(DiskObject $do) : void {
    printf("The size is %d\n", $do->getSize());
}
$d1 = new Directory1();
$d1->children[] = new File("f1", 50);
$d1->children[] = new File("f2", 30);
$d2 = new Directory1();
$d2->children[] = $d1;
$d2->children[] = new File("f1", 100);
printSize($d2);
