<?php
declare (strict_types=1);

class Product {
    /**@var int */    public $color;
    /**@var int */    public $price;
    /**@var int */    public $size;
    function __construct(int $color, int $price, int $size) {
        $this->color = $color;
        $this->price = $price;
        $this->size = $size;
    }
    function __toString() {
        return sprintf("color=%d price=%d size=%d\n", $this->color, $this->price, $this->size);
    }
}
class ProductFinder {
    /**@var Product[]*/ public $all = [];
    function belowPriceAvoidingAColor(int $price, int $color) : array {
        $r = [];
        foreach ($this->all as $p)
            if ($p->price < $price && $p->color !== $color)
                $r[] = $p;
        return $r;
    }
    function selectBy(Spec $s) : array {
        $r = [];
        foreach ($this->all as $p)
            if ($s->isSatisfiedBy($p))
                $r[] = $p;
        return $r;
    }
}
interface Spec {
    function isSatisfiedBy(Product $p) : bool;
}
class BelowPrice implements Spec {
    /**@var int*/ private $price;
    function __construct(int $price) {
        $this->price = $price;
    }
    function isSatisfiedBy(Product $p): bool {
        return $p->price < $this->price;
    }
}
class ColorSpec implements Spec {
    /**@var int*/ private $color;
    function __construct(int $color) {
        $this->color = $color;
    }
    function isSatisfiedBy(Product $p): bool {
        return $p->color === $this->color;
    }
}
class NotSpec implements Spec {
    /**@var Spec*/ private $s;
    function __construct(Spec $s) {
        $this->s = $s;
    }
    function isSatisfiedBy(Product $p): bool {
        return !($this->s->isSatisfiedBy($p));
    }
}
class AndSpec implements Spec {
    /**@var Spec*/ private $s1;
    /**@var Spec*/ private $s2;
    function __construct(Spec $s1, Spec $s2) {
        $this->s1 = $s1;
        $this->s2 = $s2;
    }
    function isSatisfiedBy(Product $p): bool {
        return $this->s1->isSatisfiedBy($p) && $this->s2->isSatisfiedBy($p);
    }
}
function print_all_products(array $ps) : void {
    $i = 0;
    foreach ($ps as $p)
        printf("%d %s\n", ++$i, $p);
}
$pf = new ProductFinder();
$pf->all[] = new Product(10, 100, 3);
$pf->all[] = new Product(11, 500, 3);
$pf->all[] = new Product(12, 400, 3);
print_all_products($pf->belowPriceAvoidingAColor(450, 12)); //Without Interpreter pattern
print_all_products($pf->selectBy(new AndSpec(             //With Interpreter pattern
                    new BelowPrice(450),new NotSpec(new ColorSpec(12)))));
