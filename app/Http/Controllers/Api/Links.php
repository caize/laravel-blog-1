<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Request;
use App\Repository\LinksRepository;

class Links
{
    //
    protected $links;
    
    public function __construct(LinksRepository $links)
    {
        $this->links = $links;
    }
    
    /**
     * 
     * @description:获取友情连接信息
     * @author wuyanwen(2017年9月10日)
     * @param@param Request $request
     */
    public function getLinks(Request $request)
    {
        $params = $request->all();
        $offset = $params['page'] - 1;
        $limit  = $params['limit'];
        
        $where = [];
        
        if (isset($params['title']) && $params['title']) {
            $where[] = ['title', '=', $params['title']];
        }
        
        $data = $this->links->page($offset, $limit, $where);
        
        $_data = $data['data']->toArray();
        
        foreach ($_data as $key => $vo) {
            $_data[$key]['show'] = $vo['show'] == 1 ? '显示' : '不显示';
        }
        return [
            'code' => 0,
            'msg'  => '',
            'count' => $data['total'],
            'data'  => $_data,
        ];
    }
}