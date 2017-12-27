<?php
namespace common\modules\link\daos;

use Yii;
/**
 * LinkDao class
 */
class LinkDao
{
    const LIST_LINK = "
        select link.result, sum(link.visitCount) as count
        from link
        where link.status = 10
        group by (link.result)
        limit :limit offset :offset";
    
    const TOTAL_LINK = "
        select count(altered_link.result) as total
        from (
            select link.result, sum(link.visitCount) as count
            from link
            where link.status = 10
            group by (link.result)
            ) altered_link
        ";
    
    public function total() : int {
        return Yii::$app->db
                ->createCommand(self::TOTAL_LINK)
                ->queryOne()['total'];
        
    }
    
    public function list(int $page, int $pageSize) : array {
        $offset = ($page - 1) * $pageSize;
        $results = Yii::$app->db
                ->createCommand(self::LIST_LINK)
                ->bindParam(':limit', $pageSize)
                ->bindParam(':offset', $offset)
                ->queryAll();
        return $results;
    
    }
}

