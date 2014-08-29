<?php

namespace WBDB\Helpers;


class QueryPagination
{
    public static function paginate($dbh, $query, $current_page, $rows_per_page = 5)
    {
        $start_offset = 0;

        $a_explode = explode("FROM", $query);
        if (sizeof($a_explode) != 2) {
            return false;
        }

        $query_last = $a_explode[1];

        $query = "SELECT count(*) AS totalrecords FROM $query_last";
        
        $db_result = $dbh->query($query)->fetch();        
        $total_records = $db_result['totalrecords'];
        
        if ($current_page > 1) {
            $start_offset = ($current_page - 1) * $rows_per_page;
        }
        
        return array('query' => " limit $start_offset, $rows_per_page ",
                     'currentpage' => $current_page, 
                     'totalpages' => ceil($total_records / $rows_per_page));
    }
}
