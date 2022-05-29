<?php


namespace app\core;


class Request
{
    public function getPath()
    {
        // get path
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        // take the string without ?
        $position = strpos($path, '?');

        if($position === false)
            return $path;

        return substr($path, 0, $position);

    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}