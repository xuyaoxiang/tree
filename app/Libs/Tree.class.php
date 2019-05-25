<?php

namespace App\Libs;

class Tree
{
    private $data;//原始数据
    public $pid_key = 'pid';//父id的key
    public $id_key = 'id';//子id的key
    public $count = 0;

    //初始化数据
    function __construct(array $data, $pid_key = false, $id_key = false)
    {
        if ($pid_key) {
            $this->pid_key = $pid_key;
        }
        if ($id_key) {
            $this->id_key = $id_key;
        }
        $this->data = $data;
    }

    //生成树
    public function maketree($pid)
    {
        $tree = array();
        foreach ($this->data as $k => $v) {
            if ($v[$this->pid_key] == $pid) {
                $v['child'] = $this->maketree($v[$this->id_key]);
                $tree[] = $v;
            }
        }
        $this->tree = $tree;
        return $tree;
    }

    //提取节点
    public function findnode($tree, $id, $node = array())
    {
        foreach ($tree as $k => $v) {
            if ($v[$this->id_key] == $id) {
                $node[] = $v;
            }

            if (empty($v['child'])) {
                continue;
            }

            $node = $this->findnode($v['child'], $id, $node);
        }
        return $node;
    }

    //统计子节点的数量
    public function countnode($node, $count = -1)
    {
        foreach ($node as $v){
            $count++;
            if(!empty($v['child'])){
                $count=$this->countnode($v['child'], $count);
            }
        }
        return $count;
    }

    //查询子节点id
    public function selectaids($node,&$aid=array()){
        foreach ($node as $v){
                $aid[] = $v['aid'];
            if(!empty($v['child'])){
                $aid=$this->selectaids($v['child'],$aid);
            }
        }
        return $aid;
    }
}
