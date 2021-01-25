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

        $path = substr($path, 0, $position);
        return $path;

    }

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}