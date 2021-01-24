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

    private function buildSelectStatement(array $columns, string $table, SearchCriteriaInterface $searchCriteria): \PDOStatement
    {
        $gluedColumns = implode(', ', $columns);
        $gluedConditions = '';
        $paramsToBind = [];

        $filterGroupApplied = false;

        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {

            if ($filterGroupApplied) {
                $gluedConditions .= " {$filterGroup->getConcatenation()} (";
            }

            $filterApplied = false;

            foreach ($filterGroup->getFilters() as $filter) {
                if ($filterApplied) {
                    $gluedConditions .= " {$filter->getConcatenation()} ";
                }
                $parameter = ":{$filter->getField()}";
                $gluedConditions .= "{$filter->getField()} {$filter->getConditionType()} $parameter";
                $filterApplied = true;

                $paramsToBind[] = [
                    'parameter' => $parameter,
                    'value' => $filter->getValue(),
                    'dataType' => $this->convertToDataType($filter->getValue())
                ];
            }
        }

        $query = "SELECT $gluedColumns FROM \"$table\"";

        if (strlen($gluedConditions) > 0) {
            $query .= "WHERE $gluedConditions";
        }

        $statement = $this->pdo->prepare($query);

        foreach ($paramsToBind as $bind) {
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

    public function insert(array $columns, string $table)
    {
        $paramsToBind = [];
        $convertToSnakeCase = new ConvertToSnakeCase();

        foreach ($columns as $column => $value) {
            if(!$value) {
                unset($columns[$column]);
                continue;
            }

            $paramsToBind[] = [
                'parameter' => ":$column",
                'value' => $value,
                'dataType' => $this->convertToDataType($value)
            ];
        }

        $columns = implode(
            ',',
            array_map(
                function ($column) use ($convertToSnakeCase) {
                    return $column ? $convertToSnakeCase->execute($column) : $column;
                },
                array_keys($columns)
            )
        );

        $gluedParameters = implode(',', array_column($paramsToBind, 'parameter'));
        $statement = $this->pdo->prepare("INSERT INTO \"$table\" ($columns) VALUES ($gluedParameters)");

        foreach ($paramsToBind as $bind) {
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