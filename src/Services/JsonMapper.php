<?php

namespace PHPAlchemist\Services;

class JsonMapper
{

    public function map(string $json, string $class) : object
    {

        if (!$this->validateJson($json)) {
            throw new \Exception('Invalid JSON');
        }

        $newObject = new $class();
        if (is_callable([$newObject, 'hydrate'])) {
            $newObject->hydrateFromJson($json);

            return $newObject;
        }

        $jsonDecodedData = json_decode($json, true);
        foreach ($jsonDecodedData as $key => $value) {
            if (!property_exists($newObject, $key)) {
                continue;
            }

            if (is_callable([$newObject, 'set' . ucfirst($key)])) {
                $newObject->{'set' . ucfirst($key)}($value);
            } elseif (property_exists($newObject, $key)) {
                $newObject->{$key} = $value;
            }
        }

        return $newObject;
    }

    protected function validateJson(string $json) : bool
    {
        if (!is_string($json) || strpos($json, '{') !== 0) {
            return false;
        }

        $validation = json_encode(json_decode($json, true));
        if ($validation !== $json) {

            return false;
        }

        return true;
    }

}