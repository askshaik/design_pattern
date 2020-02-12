<?php
declare (strict_types=1);

class LineTracker {
    /** @var int */         static private $currentLine = 0;
    /** @var Decorator[] */ static private $headers = [];
    /** @var Decorator[] */ static private $footers = [];
    const LINES_PER_PAGE = 66;
	static function addHeaderAtStart(Decorator $d) : void {
        array_unshift(self::$headers, $d);
    }
	static function addFooterAtEnd(Decorator $d) : void {
        self::$footers[] = $d;
    }
	static function timeForHeader(Decorator $d) : bool {
		return (self::$currentLine < count(self::$headers) &&
                self::$headers[self::$currentLine] === $d);
	}
	static function timeForFooter(Decorator $d) : bool {
		$footer_number = self::LINES_PER_PAGE - self::$currentLine - 1;
		return ($footer_number < count(self::$footers) &&
                    self::$footers[$footer_number] === $d);
	}
    static function reset() : void {
        printf("----------End of Report---------\n");
        self::$currentLine = 0;
        self::$headers=[];
        self::$footers=[];
    }
    static function print(string $line) : void {
        printf ("%s\n", $line);
        if (++self::$currentLine < self::LINES_PER_PAGE)
            return;
        self::$currentLine = 0;
        printf("---New Page---\n");
    }
}

abstract class Report {
    abstract function nextLine() : ?string;
    final function printFull() : void {
        while (true) {
            $s = $this->nextLine();
            if ($s === null) break;
            LineTracker::print($s);
        }
		LineTracker::reset();
	}
}

class LineNumber extends Report {
    /** @var int */ private $max;
    /** @var int */ private $currentLine = 0;
    function __construct(int $max) {
        $this->max = $max;
    }
    function nextLine() : ?string {
		return (++$this->currentLine > $this->max) ? null : (string)$this->currentLine;
	}
}

class CharacterPr extends Report {
    /** @var int */ private $max;
    /** @var string */ private $c = 'a';
    function __construct(int $max) {
        $this->max = $max;
    }
    function nextLine() : ?string {
        $p = $this->c;
        $this->c = ($p === 'z')? 'a' : chr (ord($this->c) + 1);
        return  ($this->max-- > 0)? $p : null;
    }
}

abstract class Decorator extends Report {
    /** @var Report */ protected $r;
    function __construct(Report $r) {
        $this->r = $r;
    }
}
class Header1 extends Decorator {
    function __construct(Report $r) {
        parent::__construct($r);
        LineTracker::addHeaderAtStart($this);
    }
    function nextLine() : ?string {
		return LineTracker::timeForHeader($this) ? "Header 1" : $this->r->nextLine();
	}
}
class Header2 extends Decorator {
    function __construct(Report $r) {
        parent::__construct($r);
        LineTracker::addHeaderAtStart($this);
    }
    function nextLine() : ?string {
        return LineTracker::timeForHeader($this) ? "Header 2" : $this->r->nextLine();
    }
}
class Footer1 extends Decorator {
    function __construct(Report $r) {
        parent::__construct($r);
        LineTracker::addFooterAtEnd($this);
    }
    function nextLine() : ?string {
        return LineTracker::timeForFooter($this) ? "Footer 1" : $this->r->nextLine();
    }
}
class Footer2 extends Decorator {
    function __construct(Report $r) {
        parent::__construct($r);
        LineTracker::addFooterAtEnd($this);
    }
    function nextLine() : ?string {
        return LineTracker::timeForFooter($this) ? "Footer 2" : $this->r->nextLine();
    }
}

// $r = new LineNumber(500);
// $r = new Header1(new LineNumber(500));
// $r = new Header2(new Header1(new LineNumber(500)));
// $r = new CharacterPr(400);
// $r = new Footer1(new CharacterPr(400));
// $r = new Footer2(new Footer1(new CharacterPr(400)));
 $r = new Header1(new Header2(new Footer1(new Footer2(new CharacterPr(400)))));
$r->printFull();
