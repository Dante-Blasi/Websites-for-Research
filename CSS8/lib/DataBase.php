<?php
class DataBase
{

    const DB_DEBUG = false;

    public function __construct($dataBaseUser, $dataBaseName)
    {

        $this->pdo = null;

        include 'pass.php';

        $DataBasePassword = '';

        switch (substr($dataBaseUser, strpos($dataBaseUser, "_") + 1)) {
            case 'reader':
                $DataBasePassword = $dbReader;
                break;
            case 'writer':
                $DataBasePassword = $dbWriter;
                break;
        }

        $query = NULL;

        $dsn = 'mysql:host=webdb.uvm.edu;dbname=' . $dataBaseName;

        if (self::DB_DEBUG) {
            print '<p>' . $dataBaseUser . '</p>';
            print '<p>' . $DataBasePassword . '</p>';
            print '<p>' . $dsn . '</p>';
        }

        try {
            $this->pdo = new PDO($dsn, $dataBaseUser, $DataBasePassword);

            if (!$this->pdo) {
                if (self::DB_DEBUG) {
                    print PHP_EOL . '<!-- NOT Connected -->' . PHP_EOL;
                }
                $this->pdo = 0;
            } else {
                if (self::DB_DEBUG) {
                    print PHP_EOL . '<!-- Connected -->' . PHP_EOL;
                }
            }
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            if (self::DB_DEBUG) {
                print '<!-- Error Connecting : ' . $error_message . '-->' . PHP_EOL;
            }
        }

        return $this->pdo;
    }

    public function select($query, $values = '')
    {
        $statement = $this->pdo->prepare($query);

        if (is_array($values)) {
            $statement->execute($values);
        } else {
            $statement->execute();
        }

        $recordSet = $statement->fetchAll(PDO::FETCH_ASSOC);

        $statement->closeCursor();

        return $recordSet;
    }

    public function insert($query, $values = '')
    {
        $statement = $this->pdo->prepare($query);

        if (is_array($values)) {
            $insert = $statement->execute($values);
        } else {
            $insert = $statement->execute();
        }

        return $insert;
    }

    public function displaySql($sql, $values)
    {
        foreach ($values as $value) {
            $pos = strpos($sql, '?');
            if ($pos !== false) {
                $sql = substr_replace($sql, '"' . $value . '"', $pos, strlen('?'));
            }
        }
        return '<p>SQL: ' . $sql . '</p>';
    }
}
