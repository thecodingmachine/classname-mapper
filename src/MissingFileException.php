<?php


namespace Mouf\Composer;


use RuntimeException;

class MissingFileException extends RuntimeException
{
    public static function couldNotLoadFile(string $path)
    {
        return new self('Could not load file "'.$path.'"');
    }
}