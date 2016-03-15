<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * 默认加载了数据库，和类库apiresult
 *
 */
class MY_Model extends CI_Model {
	
	protected $table;

	public function __construct() {
		parent::__construct();
		// 需要base url
        $this->load->database();
        // 初始化设置表名
        $this->setTable($this::TABLE_NAME);
	}

	// 这应该是类似埋点的东东吧，记录点东西
	function trackAction($type='',$content=''){
		log_message('info', 'DB track type = '.$type.', content = '.$content);
        // $data = array(
        //     'app_id' => $this->app_id,
        //     'username' => $this->session->userdata['username'],
        //     'ip_address' => $this->input->ip_address(),
        //     'action_type' => $type,
        //     'action_content' => $content,
        //     'action_time' => CURRENTTIME
        // );
        // $this->db->insert('cms_admin_action_track',$data);
        
        // if( rand(1,10) == 6 ){
        //     $limit_time = CURRENTTIME - 30*24*60*60;
        //     $this->db->delete('cms_admin_action_track',array('action_time <' => $limit_time ));
        // }
    }

	public function setTable($table)
    {
        $this->table = $table;
    }

    public function setWhere($getwhere)
    {
        if (is_array($getwhere)) {
            foreach ($getwhere as $key => $where) {
                if ($key == 'findinset') {
                    $this->db->where("1", "1 AND FIND_IN_SET($where)", FALSE);
                    continue;
                }
                if (is_array($where)) {
                    $this->db->where_in($key, $where);
                } else {
                    $this->db->where($key, $where);
                }
            }
        } else {
            $this->db->where($getwhere);
        }
    }

    public function addData($data, $table = '')
    {
        $table = $table == '' ? $this->table : $table;
        if ($data) {
            $this->trackAction($table,'insert data');
            $result = $this->db->insert($table, $data);
            if ($result === false) {
                return false;
            }
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function sava($data, $table = '')
    {
        $table = $table == '' ? $this->table : $table;
        $primary = $this->getPrimaryName($table);
        if (! empty($data[$primary])) {
            $datawhere = array(
                $primary => $data[$primary]
            );
            $this->editData($datawhere, $data, $table);
            return $data[$primary];
        } else {
            return $this->addData($data, $table);
        }
    }

    public function getPrimaryName($table = '')
    {
        $table = $table == '' ? $this->table : $table;
        $this->db->select("COLUMN_NAME");
        $this->db->where("TABLE_NAME", $table);
        $this->db->where("CONSTRAINT_NAME", 'PRIMARY');
        $query = $this->db->get("information_schema.KEY_COLUMN_USAGE");
        $primary = $query->result_array();
        if (! empty($primary[0]) && ! empty($primary[0]['COLUMN_NAME'])) {
            $key = $primary[0]['COLUMN_NAME'];
        } else {
            $key = false;
        }
        return $key;
    }

    public function addBatchData($data, $table = '')
    {
        $table = $table == '' ? $this->table : $table;
        if ($data) {
            $this->db->insert_batch($table, $data);
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function editData($datawhere, $data, $table = '')
    {
        $table = $table == '' ? $this->table : $table;
        $this->trackAction($table,'update id:'.json_encode($datawhere));
        if (! empty($datawhere)) {
            $this->db->where($datawhere);
        }
        return $this->db->update($table, $data);
    }

    public function delData($ids, $table = '', $idname = '')
    {
        $table = $table == '' ? $this->table : $table;
        $idname = $idname == '' ? 'id' : $idname;
        if (is_array($ids)) {
            $this->trackAction($table,'delete id:'.join($ids,','));
            $this->db->where_in($idname, $ids);
        } else {
            $this->trackAction($table,'delete id:'.$ids);
            $this->db->where($idname, $ids);
        }
        return $this->db->delete($table);
    }

    public function delAll($table = '') {
        $table = $table == '' ? $this->table : $table;
        return $this->db->delete($table);
    }

    /**
     * result array
     */
    public function getData($getwhere = '', $order = '', $pagenum = '0', $exnum = '0', $table = '')
    {
        $table = $table == '' ? $this->table : $table;
        if ($getwhere) {
            $this->setWhere($getwhere);
        }
        if ($order) {
            $this->db->order_by($order);
        }
        if ($pagenum > 0) {
            $this->db->limit($pagenum, $exnum);
        }
        $data = $this->db->get($table)->result_array();
        return $data;
    }

    public function getSingle($getwhere = '', $table = '')
    {
        $table = $table == '' ? $this->table : $table;
        if ($getwhere) {
            $this->setWhere($getwhere);
        }
        $row = $this->db->get($table)->row_array();
        return $row;
    }

    public function getDataNum($getwhere = '', $table = '')
    {
        $table = $table == '' ? $this->table : $table;
        if ($getwhere) {
            $this->setWhere($getwhere);
        }
        return $this->db->count_all_results($table);
    }

    public function setHits($id, $table = '')
    {
        $table = $table == '' ? $this->table : $table;
        $this->db->where('id', $id);
        $this->db->set('hits', 'hits+1', FALSE);
        $this->db->set('realhits', 'realhits+1', FALSE);
        return $this->db->update($table);
    }

    public function listOrder($ids, $res, $order = '', $table = '')
    {
        $table = $table == '' ? $this->table : $table;
        $num = count($ids);
        $data = array();
        for ($i = 0; $i < $num; $i ++) {
            $data[] = array(
                'id' => $ids[$i],
                'listorder' => $res[$i]
            );
        }
        $this->db->update_batch($table, $data, 'id');
        
        if ($num > 0) {
            $this->db->where_in('id', $ids);
            if ($order) {
                $this->db->order_by($order);
            }
            $data = $this->db->get($table)->result_array();
            return $data;
        }
        
        return array();
    }

    public function elements($data, $default = FALSE)
    {
        $return = array();
        $fields = $this->db->list_fields($this->table);
        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $return[$field] = $data[$field];
            } else {
                $return[$field] = $default;
            }
        }
        return $return;
    }
    
    
    
    /**
     * 
     * param pk_val 主键的值
     * 
     * return this model object
     */
    public function by_pk($pk_val) {
        $this->setWhere(array($this::PK => $pk_val));
        return $this;
    }
    
    /**
     * 过滤数据库的字段
     */
    public function filter_cols($data) {
        return array_filter_by_key($data, $this->INSERT_COLS);
    }
	
}


?>