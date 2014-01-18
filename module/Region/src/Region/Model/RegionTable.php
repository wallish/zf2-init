<?
namespace Region\Model;
 
/*use \Zend\Db\TableGateway\AbstractTableGateway;
use \Zend\Db\ResultSet\ResultSet;
use \Zend\Db\Adapter\Adapter;*/
 
 namespace Region\Model;
use Zend\Db\TableGateway\AbstractTableGateway,
    Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet;
class RegionTable extends AbstractTableGateway
{
    protected $table ='regions';
    protected $tableName ='regions';
 
    public function __construct(Adapter $dbAdapter)
    {
        $this->adapter = $dbAdapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Region());
        $this->initialize();
    }  

    public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function delete($id)
    {
        $this->delete(array('RegionId' => $id));
    }
}