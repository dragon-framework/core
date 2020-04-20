# Database

- [Configuration](#configuration)
- [Constants](#constants)
- [Methods](#methods)
    <!-- - setStatementId(string $statementId)
    - setTable(string $name)
    - find(int $id, ?array $columns=null)
    - findBy(array $criterias, ?string $relation=self::RELATION_AND, ?array $columns=null)
    - findAll(?array $options=[], $single=false)
    - insert(array $data)
    - update(array $options)
    - lastId() -->

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

Constants "Param" contain names of parameter's key.

|Key|Type|Default|Path|
|--|--|--|--|
|`PARAM_STATEMENT`|`string`|"statement"|`\Dragon\Component\Database\Statements::PARAM_STATEMENT`|
|`PARAM_DRIVER`|`string`|"driver"|`\Dragon\Component\Database\Statements::PARAM_DRIVER`|
|`PARAM_HOST`|`string`|"host"|`\Dragon\Component\Database\Statements::PARAM_HOST`|
|`PARAM_PORT`|`string`|"port"|`\Dragon\Component\Database\Statements::PARAM_PORT`|
|`PARAM_DBNAME`|`string`|"dbname"|`\Dragon\Component\Database\Statements::PARAM_DBNAME`|
|`PARAM_UNIXSOCKET`|`string`|"unixsocket"|`\Dragon\Component\Database\Statements::PARAM_UNIXSOCKET`|
|`PARAM_USER`|`string`|"user"|`\Dragon\Component\Database\Statements::PARAM_USER`|
|`PARAM_PASS`|`string`|"pass"|`\Dragon\Component\Database\Statements::PARAM_PASS`|
|`PARAM_CHARSET`|`string`|"charset"|`\Dragon\Component\Database\Statements::PARAM_CHARSET`|
|`PARAM_PREFIX`|`string`|"prefix"|`\Dragon\Component\Database\Statements::PARAM_PREFIX`|
|`PARAM_FETCHMODE`|`string`|"fetchmode"|`\Dragon\Component\Database\Statements::PARAM_FETCHMODE`|

### Query Constants

#### Query Options Keys

|Key|Type|Default|Path|
|--|--|--|--|
|`DISTINCT`|`string`|"disctinct"|`\Dragon\Component\Database\Query::DISTINCT`|
|`CRITERIAS`|`string`|"criterias"|`\Dragon\Component\Database\Query::CRITERIAS`|
|`COLUMNS`|`string`|"columns"|`\Dragon\Component\Database\Query::COLUMNS`|
|`ORDERBY`|`string`|"orderBy"|`\Dragon\Component\Database\Query::ORDERBY`|
|`ORDERDIR_ASC`|`string`|"ASC"|`\Dragon\Component\Database\Query::ORDERDIR_ASC`|
|`ORDERDIR_DESC`|`string`|"DESC"|`\Dragon\Component\Database\Query::ORDERDIR_DESC`|
|`LIMIT`|`string`|"limit"|`\Dragon\Component\Database\Query::LIMIT`|
|`OFFSET`|`string`|"offset"|`\Dragon\Component\Database\Query::OFFSET`|
|`RELATION`|`string`|"relation"|`\Dragon\Component\Database\Query::RELATION`|

#### Operators

|Key|Type|Default|Path|
|--|--|--|--|
|`EQUAL`|`string`|"="|`\Dragon\Component\Database\Query::EQUAL`|
|`GREATER_THAN`|`string`|">"|`\Dragon\Component\Database\Query::GREATER_THAN`|
|`LESS_THAN`|`string`|"<"|`\Dragon\Component\Database\Query::LESS_THAN`|
|`GREATER_OR_EQUAL`|`string`|">="|`\Dragon\Component\Database\Query::GREATER_OR_EQUAL`|
|`LESS_OR_EQUAL`|`string`|"<="|`\Dragon\Component\Database\Query::LESS_OR_EQUAL`|
|`NOT_EQUAL`|`string`|"<>"|`\Dragon\Component\Database\Query::NOT_EQUAL`|
|`NOT`|`string`|"!="|`\Dragon\Component\Database\Query::NOT`|

#### Relation

|Key|Type|Default|Path|
|--|--|--|--|
|`RELATION_AND`|`string`|"AND"|`\Dragon\Component\Database\Query::RELATION_AND`|
|`RELATION_OR`|`string`|"OR"|`\Dragon\Component\Database\Query::RELATION_OR`|

#### Fetch mode

|Key|Type|Default|Path|
|--|--|--|--|
|`FETCH_LAZY`|`integer`|`PDO::FETCH_LAZY`|`\Dragon\Component\Database\Query::FETCH_LAZY`|
|`FETCH_ASSOC`|`integer`|`PDO::FETCH_ASSOC`|`\Dragon\Component\Database\Query::FETCH_ASSOC`|
|`FETCH_NAMED`|`integer`|`PDO::FETCH_NAMED`|`\Dragon\Component\Database\Query::FETCH_NAMED`|
|`FETCH_NUM`|`integer`|`PDO::FETCH_NUM`|`\Dragon\Component\Database\Query::FETCH_NUM`|
|`FETCH_BOTH`|`integer`|`PDO::FETCH_BOTH`|`\Dragon\Component\Database\Query::FETCH_BOTH`|
|`FETCH_OBJ`|`integer`|`PDO::FETCH_OBJ`|`\Dragon\Component\Database\Query::FETCH_OBJ`|
|`FETCH_BOUND`|`integer`|`PDO::FETCH_BOUND`|`\Dragon\Component\Database\Query::FETCH_BOUND`|
|`FETCH_COLUMN`|`integer`|`PDO::FETCH_COLUMN`|`\Dragon\Component\Database\Query::FETCH_COLUMN`|
|`FETCH_CLASS`|`integer`|`PDO::FETCH_CLASS`|`\Dragon\Component\Database\Query::FETCH_CLASS`|
|`FETCH_INTO`|`integer`|`PDO::FETCH_INTO`|`\Dragon\Component\Database\Query::FETCH_INTO`|
|`FETCH_FUNC`|`integer`|`PDO::FETCH_FUNC`|`\Dragon\Component\Database\Query::FETCH_FUNC`|
|`FETCH_GROUP`|`integer`|`PDO::FETCH_GROUP`|`\Dragon\Component\Database\Query::FETCH_GROUP`|
|`FETCH_UNIQUE`|`integer`|`PDO::FETCH_UNIQUE`|`\Dragon\Component\Database\Query::FETCH_UNIQUE`|
|`FETCH_KEY_PAIR`|`integer`|`PDO::FETCH_KEY_PAIR`|`\Dragon\Component\Database\Query::FETCH_KEY_PAIR`|
|`FETCH_CLASSTYPE`|`integer`|`PDO::FETCH_CLASSTYPE`|`\Dragon\Component\Database\Query::FETCH_CLASSTYPE`|
|`FETCH_SERIALIZE`|`integer`|`PDO::FETCH_SERIALIZE`|`\Dragon\Component\Database\Query::FETCH_SERIALIZE`|
|`FETCH_PROPS_LATE`|`integer`|`PDO::FETCH_PROPS_LATE`|`\Dragon\Component\Database\Query::FETCH_PROPS_LATE`|

#### Data type

|Key|Type|Default|Path|
|--|--|--|--|
|`PARAM_BOOL`|`integer`|`PDO::PARAM_BOOL`|`\Dragon\Component\Database\Query::PARAM_BOOL`|
|`PARAM_LOB`|`integer`|`PDO::PARAM_LOB`|`\Dragon\Component\Database\Query::PARAM_LOB`|
|`PARAM_INT`|`integer`|`PDO::PARAM_INT`|`\Dragon\Component\Database\Query::PARAM_INT`|
|`PARAM_NULL`|`integer`|`PDO::PARAM_NULL`|`\Dragon\Component\Database\Query::PARAM_NULL`|
|`PARAM_STR`|`integer`|`PDO::PARAM_STR`|`\Dragon\Component\Database\Query::PARAM_STR`|

## Methods {#methods}

### hasStatement()

Return true if database config has statement.  
Can be used to know if you have database.

`getApp()->database()->hasStatement()`

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