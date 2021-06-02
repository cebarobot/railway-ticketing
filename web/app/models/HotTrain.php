<?php
namespace app\models;

use foundation\Database;

class HotTrain {
    public $list;

    function __construct() {
        $sql = <<<SQLEOF
select
    trainNum, 
    count(*) as ticketCnt 
from ticketinfo 
group by trainNum
order by ticketCnt desc
limit 10;
SQLEOF;
        $this->list = Database::selectAll($sql);
    }
}