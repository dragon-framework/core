# Database

- [Configuration](#configuration)
- [Constants](#constants)
- [Methods](#methods)

## Configuration {#configuration}

Create the `config/database.php` based on `config/database-dist.php`.

|Key|Type|Default|Description|
|--|--|--|--|
|`statement`|`string`|"main"|Name of the statement.|
|`driver`|`string`|"mysql"|Database engine.|
|`host`|`string`||The hostname on which the database server resides.|
|`port`|`integer`|3306|The port number where the database server is listening.|
|`dbname`|`string`||The name of the database.|
|`unix_socket`|`string`||The MySQL Unix socket (shouldn't be used with host or port).|
|`user`|`string`||The name of the database user.|
|`pass`|`string`||The password of the database user.|
|`charset`|`string`|"utf8"|The character set.|
|`prefix`|`string`||Table prefix for the statement.|
|`fetch_mode`|`string`||Activate security module.|

## Constants {#constants}

### Statements Constants

|Key|Type|Default|Path|
|--|--|--|--|
|`PARAM_STATEMENT`|`string`|"statement"|`\Dragon\Component\Database\Statements::PARAM_STATEMENT`|
|`PARAM_DRIVER`|`string`|"driver"|`\Dragon\Component\Database\Statements::PARAM_DRIVER`|
|`PARAM_HOST`|`string`|"host"|`\Dragon\Component\Database\Statements::PARAM_HOST`|
|`PARAM_PORT`|`string`|"port"|`\Dragon\Component\Database\Statements::PARAM_PORT`|
|`PARAM_DBNAME`|`string`|"dbname"|`\Dragon\Component\Database\Statements::PARAM_DBNAME`|
|`PARAM_USER`|`string`|"user"|`\Dragon\Component\Database\Statements::PARAM_USER`|
|`PARAM_PASS`|`string`|"pass"|`\Dragon\Component\Database\Statements::PARAM_PASS`|
|`PARAM_CHARSET`|`string`|"charset"|`\Dragon\Component\Database\Statements::PARAM_CHARSET`|
|`PARAM_PREFIX`|`string`|"prefix"|`\Dragon\Component\Database\Statements::PARAM_PREFIX`|
|`PARAM_FETCHMODE`|`string`|"fetchmode"|`\Dragon\Component\Database\Statements::PARAM_FETCHMODE`|


    const EQUAL             = "=";
    const GREATER_THAN      = ">";
    const LESS_THAN         = "<";
    const GREATER_OR_EQUAL  = ">=";
    const LESS_OR_EQUAL     = "<=";
    const NOT_EQUAL         = "<>";
    const NOT               = "!=";


    const FETCH_LAZY        = \PDO::FETCH_LAZY;
    const FETCH_ASSOC       = \PDO::FETCH_ASSOC;
    const FETCH_NAMED       = \PDO::FETCH_NAMED;
    const FETCH_NUM         = \PDO::FETCH_NUM;
    const FETCH_BOTH        = \PDO::FETCH_BOTH;
    const FETCH_OBJ         = \PDO::FETCH_OBJ;
    const FETCH_BOUND       = \PDO::FETCH_BOUND;
    const FETCH_COLUMN      = \PDO::FETCH_COLUMN;
    const FETCH_CLASS       = \PDO::FETCH_CLASS;
    const FETCH_INTO        = \PDO::FETCH_INTO;
    const FETCH_FUNC        = \PDO::FETCH_FUNC;
    const FETCH_GROUP       = \PDO::FETCH_GROUP;
    const FETCH_UNIQUE      = \PDO::FETCH_UNIQUE;
    const FETCH_KEY_PAIR    = \PDO::FETCH_KEY_PAIR;
    const FETCH_CLASSTYPE   = \PDO::FETCH_CLASSTYPE;
    const FETCH_SERIALIZE   = \PDO::FETCH_SERIALIZE;
    const FETCH_PROPS_LATE  = \PDO::FETCH_PROPS_LATE;

    const PARAM_BOOL        = \PDO::PARAM_BOOL; 
    const PARAM_LOB         = \PDO::PARAM_LOB; 
    const PARAM_INT         = \PDO::PARAM_INT; 
    const PARAM_NULL        = \PDO::PARAM_NULL; 
    const PARAM_STR         = \PDO::PARAM_STR; 
### Query Constants

|Key|Type|Default|Path|
|--|--|--|--|
|`RELATION_AND`|`string`|"AND"|`\Dragon\Component\Database\Query::RELATION_AND`|
|`RELATION_OR`|`string`|"OR"|`\Dragon\Component\Database\Query::RELATION_OR`|

## Methods {#methods}

### hasStatement()

Return true if database config has statement.  
Can be used to know if you have database.

`$database->hasStatement()`

### dbh()

Return the Database Handle for the `$statement`

`$database->dbh(string $statement)`

statement
: The statement name

### getStatement()

Return the statement parameters

`$database->getStatement(string $statement)`

statement
: The statement name








### find()

`$this->find(int $id[, ?array $columns=null)`
`$model->find(int $id[, ?array $columns=null)`

### findBy()

        // dump( $model->findBy(['id' => 2]));
        // dump( $model->findBy(['id' => 2], Query::RELATION_OR));
        // dump( $model->findBy([
        //     'id' => 2, 
        //     'title' => "test"
        // ]));
        // dump( $model->findBy([
        //     [
        //         'key'       => "id",
        //         'value'     => 2,
        //         'type'      => Query::PARAM_INT,
        //         'relation'  => Query::EQUAL,
        //     ],
        //     // 'truc'  => 42, 
        //     // 'title' => "test"
        // ]));
        // dump( $model->findBy(['id' => 2, 'title' => "test"], Query::RELATION_OR));
        // dump( $model->findBy(['id' => 2, 'title' => "test"], Query::RELATION_OR, ["title", "id"]));
        

## Query

### Where


### Order BY


$books = $this->findAll([
Query::ORDERBY => "title",
// Query::ORDERBY => ["title"],
// Query::ORDERBY => ["title" => Query::ORDERDIR_ASC],

### Limit