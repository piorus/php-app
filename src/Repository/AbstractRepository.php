<?php
declare(strict_types=1);

namespace Repository;

use Database\AdapterInterface;
use Database\Search\SearchCriteriaInterface;
use Exception\EntityDoesNotExistException;
use Model\EntityInterface;
use Service\ConvertArrayToCamelCase;
use Service\ConvertToCamelCase;

class AbstractRepository implements RepositoryInterface
{
    /** @var AdapterInterface */
    protected $adapter;
    /** @var string */
    protected $tableName;
    /** @var string */
    protected $modelClass;

    public function __construct(
        AdapterInterface $adapter,
        string $tableName = '',
        string $modelClass = ''
    )
    {
        $this->adapter = $adapter;
        $this->tableName = $tableName;
        $this->modelClass = $modelClass;
    }

    public function get(int $id, array $columns = ['*'])
    {
        //@TODO fix

//        $data = $this->adapter->fetch(
//            $columns,
//            $this->tableName,
//            ['id' => ['eq' => $id]],
//            \PDO::FETCH_ASSOC
//        );

        $data = null;

        if(empty($data)) {
            throw new EntityDoesNotExistException(
                sprintf(
                    '%s with id=%d does not exist in %s',
                    $this->modelClass,
                    $id,
                    $this->tableName
                )
            );
        }

        return new $this->modelClass($data);
    }

    /** @return EntityInterface[] */
    public function getList(SearchCriteriaInterface $searchCriteria) : array
    {
        $result = [];
        $convertArrayToCamelCase = new ConvertArrayToCamelCase();
        $rows = $convertArrayToCamelCase->execute(
            $this->adapter->fetchAll(
                ['*'],
                $this->tableName,
                $searchCriteria
            )
        );

        foreach($rows as $row) {
            $result[] = new $this->modelClass($row);
        }

        return $result;
    }

    public function save(EntityInterface $entity)
    {
        $this->adapter->insert($entity->getValues(), $this->tableName);
    }

    public function delete(EntityInterface $entity)
    {
        // TODO: Implement delete() method.
    }

    public function deleteById(int $id)
    {
        // TODO: Implement deleteById() method.
    }
}