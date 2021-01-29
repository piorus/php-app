<?php
declare(strict_types=1);

namespace Repository;

use Database\AdapterInterface;
use Database\Search\SearchCriteriaBuilder;
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
    /** @var array */
    protected $cache = [];

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
        if(isset($this->cache[$id])) {
            return $this->cache[$id];
        }

        $builder = new SearchCriteriaBuilder();
        $convertArrayToCamelCase = new ConvertArrayToCamelCase();
        $data = $convertArrayToCamelCase->execute(
            [
                $this->adapter->fetch(
                    ['*'],
                    $this->tableName,
                    $builder->addFilter('id', $id)->build()
                )
            ]
        );
        $data = current($data);

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

        $this->cache[$id] = new $this->modelClass($data);

        return $this->cache[$id];
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
        if($entity->getId()) {
            $builder = new SearchCriteriaBuilder();
            $this->adapter->update(
                $this->tableName,
                $builder->addFilter('id', $entity->getId())->build(),
                $entity->getValues());
        } else {
            $this->adapter->insert($this->tableName, $entity->getValues());
        }
    }

    public function delete(EntityInterface $entity)
    {
        // TODO: Implement delete() method.
    }

    public function deleteById(int $id)
    {
        $builder = new SearchCriteriaBuilder();

        $this->adapter->delete(
            $this->tableName,
            $builder->addFilter('id', $id)->build()
        );
    }
}