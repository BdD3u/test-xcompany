<?php
namespace Core;
/**
 * Только совсем базовая основа.
 * Class ActiveRecordAbstract
 * @package Core
 */
abstract class ActiveRecordAbstract
{
    public $id;
    /** @var  array $describeTable */
    protected static $describeTable;
    /** @var  array $oldFields */
    protected $oldFields;

    public function __construct() {
        static::setDescriptionTable();
    }

    public abstract static function getTableName(): string;

    public static function getDbConnection()
    {
        return Application::instance()->getDbConnection();
    }

    protected static function setDescriptionTable()
    {
        if (null === static::$describeTable) {
            $sql = 'SELECT * FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_NAME` = \'' . static::getTableName() . '\' AND `TABLE_SCHEMA` = (SELECT schema())';
            $sth = static::getDbConnection()->query($sql);
            while ($row = $sth->fetch()) {
                static::$describeTable[$row['COLUMN_NAME']] = $row;
            }
        }
    }

    public static function getDescriptionTable(): array
    {
        self::setDescriptionTable();
        return static::$describeTable;
    }

    protected static function populateFormDb(array $row)
    {
        $obRow = new static;
        $obRow->oldFields = $row;
        foreach ($row as $property => $value) {
            $obRow->$property = $value;
        }
        return $obRow;
    }

    public static function findAll(): array
    {
        $sql = 'SELECT * FROM ' . static::getTableName();
        $arResult = [];
        $sth = static::getDbConnection()->query($sql);
        while ($row = $sth->fetch()) {
            $arResult[] = static::populateFormDb($row);
        }
        return $arResult;
    }

    public static function getById(int $id): array
    {
        $sql = 'SELECT * FROM ' . static::getTableName() . ' WHERE id = :id';
        $arResult = [];
        $row  = static::getDbConnection()->query($sql, ['id' => $id])->fetch();
        if($row) {
            $arResult[] = static::populateFormDb($row);
        }
        return $arResult;
    }

    public function isNew(): bool
    {
        return !isset($this->oldFields['id']) || empty($this->oldFields['id']);
    }

    public function save(): bool {
        if($this->isNew()) {
            // INSERT
            $columns = '';
            $labelColumns = '';
            $values = [];
            foreach(static::$describeTable as $column => $arDescription) {
                if(isset($this->$column) && $column !== 'id') {
                    $columns .= $column . ',';
                    $labelColumns .= ':' . $column . ',';
                    $values[$column] = $this->$column;
                }
            }
            if($column && $labelColumns && $values) {
                $columns = substr($columns, 0, -1);
                $labelColumns = substr($labelColumns, 0, -1);
                $sql = 'INSERT INTO ' . static::getTableName() . '(' . $columns . ') VALUES(' . $labelColumns . ')';
            } else {
                throw new \ErrorException('Could not prepare params for insert sql');
            }
        } else {
            // UPDATE
            foreach(static::$describeTable as $column => $arDescription) {
                if(isset($this->$column) && $column !== 'id') {
                    $update = '`' . $column . '`=:' . $column . ',';
                    $params[$column] = $this->$column;
                }
            }
            if($update && $params) {
                $update = substr($update, 0, -1);
                $params['id'] = $this->oldFields['id'];
                $sql = 'UPDATE ' . static::getTableName() . 'SET ' . $update . 'WHERE `id`=:id';
            }
        }

        return static::getDbConnection()->execute($sql, $values);
    }

    public function delete()
    {
        if(!$this->isNew()) {
            $sql = 'DELETE FROM ' . static::getTableName() . ' WHERE `id`=:id';
            return static::getDbConnection()->execute($sql, ['id' => $this->oldFields['id']]);
        }
        throw new \ErrorException('You can not remove the object which is not saved.');
    }
}