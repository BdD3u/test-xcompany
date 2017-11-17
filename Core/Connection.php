<?php
namespace Core;

use PDO;
use PDOStatement;
use ErrorException;

class Connection
{
    /** @var  string $dsn */
    protected $dsn;
    /** @var  string $username */
    protected $username;
    /** @var  string $password */
    protected $password;
    /** @var  array $options */
    protected $options;
    /** @var PDO $dbh */
    protected $dbh;
    /** @var PDOStatement $sth */
    protected $sth;

    public function __construct(
        string $dsn,
        string $username,
        string $password,
        array $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]
    )
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->options = $options;
    }

    protected function connection(): PDO
    {
        if(empty($this->dbh)) {
            $this->dbh = new PDO($this->dsn, $this->username, $this->password, $this->options);
        }
        return $this->dbh;
    }

    public function disconnect(): self
    {
        unset($this->sth, $this->dbh);
        return $this;
    }

    public function execute(string $sql, array $params = []): bool
    {
        $res = false;
        $this->sth = $this->connection()->prepare($sql);
        if ($this->sth instanceof PDOStatement) {
            $res = $this->sth->execute($params);
        }
        return $res;
    }

    public function query(string $sql, array $params = [],
                                  array $fetchModeParams = ['mode' => PDO::FETCH_ASSOC]): PDOStatement {
        if(!$this->execute($sql, $params)) {
            throw new ErrorException('Couldn\'t execute sql');
        }

        if(!call_user_func_array(array($this->sth, 'setFetchMode'), $fetchModeParams)) {
            throw new ErrorException('Can\'t set fetch mode');
        }

        return $this->sth;
    }

    public function getLastInsertId()
    {
        return $this->dbh->lastInsertId();
    }
}