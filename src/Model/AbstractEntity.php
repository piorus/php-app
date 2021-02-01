<?php
declare(strict_types=1);

namespace Model;

/**
 * @method setId(int $id)
 */
class AbstractEntity implements EntityInterface
{
    const ENTITY = null;

    protected ?int $id = null;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $property = new \ReflectionProperty($this, $key);
                $this->$key = $this->convertType(
                    $property->getType()->getName(),
                    $value
                );
            }
        }
    }

    private function convertType(string $type, $value)
    {
        switch ($type) {
            case 'int':
                return (int) $value;
            case 'float':
                return (float) $value;
            default:
                return $value;
        }
    }

    public function __call(string $name, array $arguments)
    {
        $method = substr($name, 0, 3);
        $property = lcfirst(str_replace($method, '', $name));
        switch ($method) {
            case 'get':
                return $this->$property ?? null;
            case 'set':
                if(property_exists($this, $property)) {
                    $this->$property = $arguments[0];
                }
        }

        return null;
    }

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getValues(): array
    {
        $values = [];

        foreach ($this as $key => $value) {
            $values[$key] = $value;
        }

        return $values;
    }
}