<?php

require_once __DIR__ .'/../vendor/autoload.php';

//use Elasticsearch;
//use Findmyrice\Models\Users;
//use Findmyrice\Models\Profile;

class ElasticTask extends \Phalcon\CLI\Task
{
    /**
     * @param array $params
     * create Index
    */
    public function createIndexAction(array $params) {
        $arr = unserialize(base64_decode($params[0]));
        if(!empty($arr)){
            $client = new Elasticsearch\Client();
            $el_params = $this->_arrayElastic($arr);
            if(!empty($el_params)){
                $create_index = $client->index($el_params);
            }
        }
    }

    /**
     * @param array $params
     * delete Document
     */
    public function deleteDocumentAction(array $params) {
        $arr = unserialize(base64_decode($params[0]));
        if(!empty($arr) && count($arr) == 3) {
            $client = new Elasticsearch\Client();
            $deleteParams['index'] = $arr['index'];
            $deleteParams['type'] = $arr['type'];
            $deleteParams['id'] = $arr['id'];
            $retDelete = $client->delete($deleteParams);
        }
    }

    private function _arrayElastic(array $data){
        $el_params = array();
        $el_params['index'] = $data['index'];
        $el_params['type']  = $data['type'];
        $el_params['id']    = $data['id'];

        foreach($data as $key=>$val){
            if($key !='index' && $key != 'type' && $key != 'id'){
                $el_params['body'][$key] = $val;
            }
        }
        return $el_params;
    }
}