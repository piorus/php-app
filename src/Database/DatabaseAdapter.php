<?php
declare(strict_types=1);

namespace Database;

use Database\Search\SearchCriteriaInterface;
use Exception\DatabaseException;
use Service\ConvertToSnakeCase;

class DatabaseAdapter implements AdapterInterface
{
    /** @var \PDO */
    private $pdo;

    public function __construct()
    {
        $dsnPrefix = DATABASE_DSN_PREFIX;
        $connectionDetails = [
            'host' => DATABASE_HOST,
            'port' => DATABASE_PORT,
            'dbname' => DATABASE_NAME,
            'user' => DATABASE_USERNAME,
            'password' => DATABASE_PASSWORD
        ];
        $dsn = "$dsnPrefix:";
        foreach ($connectionDetails as $key => $value) {
            $dsn .= "$key=$value;";
        }

        $this->pdo = new \PDO(
            $dsn,
            null,
            null,
            [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
        );
    }

    private function buildWhereClause(SearchCriteriaInterface $searchCriteria)
    {
        $params = [];
        $where = '';
        $filterGroupApplied = false;

        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {

            if ($filterGroupApplied) {
                $where .= " {$filterGroup->getConcatenation()} (";
            }

            $filterApplied = false;

            foreach ($filterGroup->getFilters() as $filter) {
                if ($filterApplied) {
                    $where .= " {$filter->getConcatenation()} ";
                }
                $parameter = ":{$filter->getField()}";
                $where .= "{$filter->getField()} {$filter->getConditionType()} $parameter";
                $filterApplied = true;

                $params[] = [
                    'parameter' => $parameter,
                    'value' => $filter->getValue(),
                    'dataType' => $this->convertToDataType($filter->getValue())
                ];
            }
        }

        return [
            'where' => $where,
            'params' => $params
        ];
    }

    private function buildSelectStatement(array $columns, string $table, SearchCriteriaInterface $searchCriteria): \PDOStatement
    {
        $gluedColumns = implode(', ', $columns);
        $conditions = $this->buildWhereClause($searchCriteria);

        $query = "SELECT $gluedColumns FROM \"$table\"";

        if (strlen($conditions['where']) > 0) {
            $query .= "WHERE {$conditions['where']}";
        }

        $statement = $this->pdo->prepare($query);

        foreach ($conditions['params'] as $bind) {
            $statement->bindParam($bind['parameter'], $bind['value'], $bind['dataType']);
        }

        $statement->execute();

        return $statement;
    }

    private function checkErrors(bool $hasResult)
    {
        if (!$hasResult && $this->pdo->errorCode() !== '00000') {
            throw new DatabaseException(implode(';', $this->pdo->errorInfo()));
        }
    }

    public function fetch(array $columns, string $table, SearchCriteriaInterface $searchCriteria, int $fetchStyle = \PDO::FETCH_ASSOC): ?array
    {
        $statement = $this->buildSelectStatement($columns, $table, $searchCriteria);
        $result = $statement->fetch($fetchStyle);
        $this->checkErrors((bool)$result);

        return $result !== false ? $result : null;
    }

    public function fetchAll(array $columns, string $table, SearchCriteriaInterface $searchCriteria, int $fetchStyle = \PDO::FETCH_ASSOC)
    {
        $statement = $this->buildSelectStatement($columns, $table, $searchCriteria);
        $result = $statement->fetchAll($fetchStyle);
        $this->checkErrors((bool)$result);

        return $result !== false ? $result : null;
    }

    private function prepareColumns(array $columns)
    {
        $params = [];
        $parsedColumns = [];
        $convertToSnakeCase = new ConvertToSnakeCase();

        foreach ($columns as $key => $value) {
            if (!$value) {
                unset($columns[$key]);
                continue;
            }

            $newKey = $convertToSnakeCase->execute($key);
            $parsedColumns[$newKey] = $value;

            $params[] = [
                'column' => $newKey,
                'parameter' => ":$newKey",
                'value' => $value,
                'dataType' => $this->convertToDataType($value)
            ];
        }

        return [
            'columns' => $parsedColumns,
            'params' => $params
        ];
    }

    public function insert(string $table, array $columns)
    {
        $columns = $this->prepareColumns($columns);
        $gluedColumns = implode(',', array_keys($columns['columns']));
        $gluedParameters = implode(',', array_column($columns['params'], 'parameter'));
        $statement = $this->pdo->prepare("INSERT INTO \"$table\" ($gluedColumns) VALUES ($gluedParameters)");

        foreach ($columns['params'] as $bind) {
            $statement->bindParam($bind['parameter'], $bind['value'], $bind['dataType']);
        }

        $statement->execute();
    }

    public function update(string $table, SearchCriteriaInterface $searchCriteria, array $columns)
    {
        $columns = $this->prepareColumns($columns);
        $setClauses = [];

        foreach($columns['params'] as $bind) {
            $setClauses[] = "{$bind['column']} = {$bind['parameter']}";
        }

        $setClause = implode(', ', $setClauses);
        $whereClause = $this->buildWhereClause($searchCriteria);
        $sql = "UPDATE \"$table\" SET $setClause";

        if($whereClause['where']) {
            $sql .= " WHERE {$whereClause['where']}";
        }

        $statement = $this->pdo->prepare($sql);

        foreach ($columns['params'] as $bind) {
            $statement->bindParam($bind['parameter'], $bind['value'], $bind['dataType']);
        }

        foreach ($whereClause['params'] as $bind) {
            $statement->bindParam($bind['parameter'], $bind['value'], $bind['dataType']);
        }

        $statement->execute();

    }

    public function delete(string $table, SearchCriteriaInterface $searchCriteria)
    {
        $whereClause = $this->buildWhereClause($searchCriteria);

        $query = "DELETE FROM \"$table\"";
        if ($whereClause['where']) {
            $query .= "WHERE {$whereClause['where']}";
        }

        $statement = $this->pdo->prepare($query);

        foreach ($whereClause['params'] as $bind) {
            $statement->bindParam($bind['parameter'], $bind['value'], $bind['dataType']);
        }

        $statement->execute();
    }

    private function convertToDataType($value)
    {
        if (is_bool($value)) {
            return \PDO::PARAM_BOOL;
        }

        if (is_integer($value)) {
            return \PDO::PARAM_INT;
        }

        if (is_double($value) || is_float($value)) {
            return \PDO::PARAM_INT;
        }

        return \PDO::PARAM_STR;
    }
}