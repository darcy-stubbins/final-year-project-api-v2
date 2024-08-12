<?php
//class that will route incoming traffic

namespace Classes;

use Models\Pattern;
use Models\User;

class Router
{
    public array $route;
    public array $formData;
    public static array $routeMap = [
        'user' => User::class,
        'pattern' => Pattern::class
    ];

    public function __construct(string $route, array $formData = [])
    {
        //assigning variables 
        $this->route = $this->constructURLArray($route);
        $this->formData = $formData;
        $this->processURLArray();

    }

    /**
     * Summary of constructURLArray
     * turn URL endpoint into array 
     * @param string $route
     * @return array|null
     */
    public function constructURLArray(string $route): array|null
    {
        $route = ltrim($route, '/');
        return explode('/', $route);
    }

    /**
     * Summary of getResponse
     * return json object 
     * @return string
     */
    public function getResponse(): string
    {
        return json_encode([]);
    }

    public function processURLArray()
    {
        $object = new self::$routeMap[$this->route[0]]();
        $function = lcfirst(str_replace('-', '', ucwords($this->route[1], '-'))); //changes the url to match the functions 
        $objectId = $this->route[2] ?? null;
        if ($objectId) {
            echo $object->$function($objectId, $this->formData);
        } else {
            echo $object->$function($this->formData);
        }

    }
}