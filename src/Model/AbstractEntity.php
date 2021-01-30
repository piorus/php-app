<?php
declare(strict_types=1);

namespace Model;

/**
 * @method int|null getId()
 */
class AbstractEntity implements EntityInterface
{
    const ENTITY = null;

    /** @var int */
    protected $id;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        $this->id = (int)$this->id;
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

    public function getValues(): array
    {
        $values = [];

        foreach ($this as $key => $value) {
            $values[$key] = $value;
        }

        return $values;
    }
}