<?php
namespace MysqlGeneralLogColorizer;

class OutputLineWithColor
{

    const BLUE = "\033[0;94m";

    const RED = "\033[0;31m";

    const GREEN = "\033[0;32m";

    const GREY = "\033[0;97m";

    const RESET_COLOR = "\033[0m";

    public $text;

    public $color;

    function __construct($text, $color)
    {
        $this->color = $color;
        $this->text = $text;
    }

    function getText()
    {
        return $this->text;
    }

    function toString()
    {
        return $this->color . $this->text . self::RESET_COLOR;
    }
}
