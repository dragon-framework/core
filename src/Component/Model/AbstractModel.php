<?php 
namespace Dragon\Component\Model;

class AbstractModel
{

	/** 
     * @var string $table Table name
     * */
	protected $table;

	/** 
     * @var int $primaryKey Primary key name, Default "id"
     * */
	protected $primaryKey = "id";

	// /** 
    //  * @var \PDO $dbh Connexion à la base de données 
    //  * */
    // protected $dbh;
    
    /**
     * @var array $db Databases connexions
     *
     * @var [type]
     */
    protected $db;
    

	public function __construct()
	{
		// $this->setTableFromClassName();
		// $this->dbh = ConnectionModel::getDbh();
	}
}