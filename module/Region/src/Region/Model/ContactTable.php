<?php
namespace Region\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;


class ContactTable extends AbstractTableGateway
{
    // Table name in database
    protected $table ='contact';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Contact());
        $this->initialize();
    }

    public function fetchEntry($filter)
    {
        if (!$filter['ContactId'] && !$filter['ContactPhone'] && !$filter['ContactMail']) return null;

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
        return $this->delete(array('ContactId' => $id));
    }

    public function save(Contact $region)
    {
        $data = array(
            'ContactId' => (int)$region->_contactId,
            'ContactPhone' => $region->_contactPhone,
            'ContactMail' => $region->_contactMail,
        );

        if ($data['ContactId'] == 0) {
            $this->insert($data);
        } elseif ($this->fetchEntry($data['ContactId'])) {
            $this->update($data,array('Contact' => $data['ContactId']));
            $result = array('code' => 'SUCCESS_UPDATE', 'id' => $data['ContactId'], 'messages' => array());
        } else {
            //$result = array('code' => 'FAILURE_NOT_UNIQUE', 'id' => $data['RegionId'], 'messages' => array($e->getMessage()));
            throw new \Exception('Form id does not exist');
         }

        return $result;
    }
}