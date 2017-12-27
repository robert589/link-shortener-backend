<?php
namespace common\modules\link\daos;

use Yii;
/**
 * LinkDao class
 */
class LinkDao
{
    const LIST_LINK = "
        select *
        from link
        where link.status = 10
        group by (link.result)
        limit :limit offset :offset";
    
    public function list(int $page, int $pageSize) : array {
        
    }
}

