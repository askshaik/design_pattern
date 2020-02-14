<?php
declare (strict_types=1);

abstract class Employee {
    /**@var string*/ public $name;
    function __construct(string $name) {
        $this->name = $name;
    }
    abstract function visit(EmployeeVisitor $ev): void;
}
class HourlyEmployee extends Employee {
    /**@var int*/ public $hours;
    function __construct(string $name, int $hours) {
        parent::__construct($name);
        $this->hours = $hours;
    }
    function visit(EmployeeVisitor $ev): void {
        $ev->visitHourly($this);
    }
}
class SalariedEmployee extends Employee {
    /**@var int*/ public $salary;
    function __construct(string $name, int $salary) {
        parent::__construct($name);
        $this->salary = $salary;
    }
    function visit(EmployeeVisitor $ev): void {
        $ev->visitSalaried($this);
    }
}
interface EmployeeVisitor {
    function visitHourly(HourlyEmployee $e) : void;
    function visitSalaried(SalariedEmployee $e) :void;
}

class EmployeeReportVisitor implements EmployeeVisitor {
    function printEmployees(iterable $all) : void {
        foreach ($all as $e)
            $e->visit($this);
    }
    function visitHourly(HourlyEmployee $e): void {
        printf("Hourly %s worked for %d hours\n", $e->name, $e->hours);
    }
    function visitSalaried(SalariedEmployee $e): void {
        printf("Salaried %s has salary %d\n", $e->name,$e->salary);
    }
}

$emps  = [ new HourlyEmployee('bob', 10), new SalariedEmployee('sam', 500)];
(new EmployeeReportVisitor())->printEmployees($emps);
