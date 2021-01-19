<?php
declare(strict_types=1);

class AbstractRepository implements RepositoryInterface
{
    /** @var \Database\AdapterInterface */
    private $adapter;
    /** @var string */
    private $tableName;
    /** @var string */
    private $modelClass;

    public function __construct(
        \Database\AdapterInterface $adapter,
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
        $data = $this->adapter->fetch(
            $columns,
            $this->tableName,
            ['id' => ['eq' => $id]],
            PDO::FETCH_ASSOC
        );

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

    public function getList(\Database\SearchCriteriaInterface $searchCriteria)
    {
        // TODO: Implement getList() method.
    }

    public function save(\Model\EntityInterface $entity)
    {
        // TODO: Implement save() method.
    }

    public function delete(\Model\EntityInterface $entity)
    {
        // TODO: Implement delete() method.
    }

    public function deleteById(int $id)
    {
        // TODO: Implement deleteById() method.
    }
}