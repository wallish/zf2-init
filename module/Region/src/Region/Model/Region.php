<?
namespace Region\Model;
use Zend\Db\ResultSet\Row;
class Region extends Row
{
    public $RegionId;
    public $RegionLabel;
    
    public function exchangeArray($data)
    {
        $this->RegionId = (isset($data['RegionId'])) ? $data['RegionId'] : null;
        $this->RegionLabel = (isset($data['RegionLabel'])) ? $data['RegionLabel'] : null;
    }
}