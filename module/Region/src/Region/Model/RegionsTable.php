<?php
namespace Region\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class RegionsTable extends AbstractTableGateway
{
    // Table name in database
    protected $table ='regions';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Region());
        $this->initialize();
    }

    public function fetchAll()
    {
        return $this->select();
    }

    public function delete($id)
    {
        $this->delete(array('RegionId' => $id));
    }

    public function getColumns(){
        return $this->getColumns();
    }
}