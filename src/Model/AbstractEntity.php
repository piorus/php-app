<?php
declare(strict_types=1);

namespace Model;

class AbstractEntity implements EntityInterface
{
    public function __construct(array $data)
    {
        foreach($data as $key => $value) {
            if(property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function getId(): ?int
    {
        return null;
    }

    public function getValues(): array
    {
        $values = [];

        foreach($this as $key => $value) {
            $values[$key] = $value;
        }

        return $values;
    }
}