<?php
namespace Region\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;


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

    public function fetchEntry($filter)
    {
        if (!$filter['RegionId'] && !$filter['RegionLabel']) return null;

        $rowset = $this->select($filter);
        $row = $rowset->current();

        if (!$row) {
            throw new \Exception("Could not find row $id");
        }

        return $row;
    }

      public function getData($array = null)
    {
        $select = new Select();
        $select->from($this->table);
        //$select->limit($limit);

        return new \Zend\Paginator\Paginator(
            new \Zend\Paginator\Adapter\DbSelect($select, $this->adapter, $this->resultSetPrototype)
        );
    }

    public function fetchEntries($filter = null)
    {
        return $this->select($filter);
    }

    public function delete2($id)
    {
        if (!$id) return null;
        return $this->delete(array('RegionId' => $id));
    }

    public function save(Region $region)
    {
        $data = array(
            'RegionId' => (int)$region->_regionId,
            'RegionLabel' => $region->_regionLabel,
            'RegionWeight' => $region->_regionWeight,
        );

        if ($data['RegionId'] == 0) {
            $this->insert($data);
        } elseif ($this->fetchEntry($data['RegionId'])) {
            $this->update($data,array('Region' => $data['RegionId']));
            $result = array('code' => 'SUCCESS_UPDATE', 'id' => $data['RegionId'], 'messages' => array());
        } else {
            //$result = array('code' => 'FAILURE_NOT_UNIQUE', 'id' => $data['RegionId'], 'messages' => array($e->getMessage()));
            throw new \Exception('Form id does not exist');
         }

        return $result;
    }
}