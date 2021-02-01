<?php
declare(strict_types=1);

namespace Repository;

use Database\AdapterInterface;
use Database\Search\SearchCriteriaBuilder;
use Database\Search\SearchCriteriaInterface;
use Exception\EntityDoesNotExistException;
use Factory\EntityFactory;
use Model\EntityInterface;
use Service\ConvertArrayToCamelCase;

class AbstractRepository implements RepositoryInterface
{
    protected AdapterInterface $adapter;
    protected string $tableName;
    protected string $entityClass;
    protected array $cache = [];

    public function __construct(
        AdapterInterface $adapter,
        string $tableName = '',
        string $modelClass = ''
    )
    {
        $this->adapter = $adapter;
        $this->tableName = $tableName;
        $this->entityClass = $modelClass;
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
                    $this->entityClass,
                    $id,
                    $this->tableName
                )
            );
        }

        $this->cache[$id] = EntityFactory::create($this->entityClass, $data);

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
            $result[] = EntityFactory::create($this->entityClass, $row);
        }

        return $result;
    }

    public function save(EntityInterface $entity) : ?int
    {
        $id = $entity->getId();

        if($entity->getId()) {
            $builder = new SearchCriteriaBuilder();
            $this->adapter->update(
                $this->tableName,
                $builder->addFilter('id', $entity->getId())->build(),
                $entity->getValues());
        } else {
            $id = $this->adapter->insert($this->tableName, $entity->getValues());
        }

        return $id;
    }

    public function delete(EntityInterface $entity)
    {
        $this->deleteById($entity->getId());
    }

    public function deleteById(int $id)
    {
        $builder = new SearchCriteriaBuilder();
        $builder->addFilter('id', $id);

        $this->adapter->delete(
            $this->tableName,
            $builder->build()
        );
    }
}