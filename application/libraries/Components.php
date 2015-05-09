<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

use \Illuminate\Database\Capsule\Manager as DB;

class Components {
    public function grid($text, $limit, $page, $table, $columns_filter, $join){
		$resp = array();
		$columns = array();
		$headers = array();
		$join_tables = array();
		$join_fields = array();
		$result = "";
		$query = "";
		$query_join = "";
        $query_where = "";

		foreach ($columns_filter as $key => $value) {
			$columns[] = $value;
			$headers[] = $key;
		}

		foreach ($join as $key => $value) {
			$join_tables[] = $key;
			$join_fields[] = $value;
		}

        for ($i = 0; $i < count($join_tables) ; $i++) { 
        	$query_join .= ' inner join '.$join_tables[$i].' on '.$table.'.'.$join_fields[$i].' = '.$join_tables[$i].'.'.$join_fields[$i];
        }

        for ($i = 0; $i < count($columns) ; $i++) { 
        	$query_where .= $columns[$i]." like '%".$text."%'".($i == (count($columns) - 1) ? "" : " or ");
        }

		try {
            if($text != ''){
                $query = 'select count('.$columns[0].') as total from '.$table.$query_join.' where '.$query_where;
            	$total = DB::select($query);
            }else{
            	$query = 'select count('.$columns[0].') as total from '.$table;
                $total = DB::select($query);
            }

            $query = 'select '.implode(",", $columns).' from '.$table.$query_join.' where '.$query_where.' order by '.$columns[0].' asc limit '.$limit.' offset '.($page == 1 ? 0 : (($page - 1) * $limit));

            $result = DB::select($query);

            $resp = array(
                'total' => $total[0]['total']/$limit, 'headers' => $headers, 'columns' => $columns, 'data' => $result, 'msg' => 'Datos cargados'
            );
        } catch (Exception $e) {
            $resp = array(
                'total' => 0, 'headers' => $headers, 'columns' => $columns, 'data' => $result, 'msg' => $e->getMessage()
            );
        }

        return $resp;
	}
}