<?php 
namespace Dragon\Component\Model;

class AbstractModel
{
     const DEFAULT_FINDALL_OPTIONS = [
          'orderBy'  => '',
          'orderDir' => 'ASC',
          'limit'    => null,
          'offset'   => null
     ];

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
		$this->setTableFromClassName();
		// $this->dbh = ConnectionModel::getDbh();
     }
     
     private function setTableFromClassName()
     {
          $className = get_class($this);
          
          dump( $className );
     }



     public function find($id)
     {
          dump("Query Find ....");
     }

     public function findAll(array $options=self::DEFAULT_FINDALL_OPTIONS)
     {
          dump("Query Find All ....");
     }

     public function findBy()
     {
          dump("Query Find By ....");
     }

     public function search()
     {
          dump("Query Search ....");
     }

     public function delete()
     {
          dump("Query Delete ....");
     }

     public function insert()
     {
          dump("Query Insert ....");
     }

     public function update()
     {
          dump("Query Update ....");
     }
}