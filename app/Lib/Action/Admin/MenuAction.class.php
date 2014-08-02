<?php
/**
 * 菜单控制器
 */
class MenuAction extends HomeAction
{
    /**
     * get main menu list
     */
    public function get_main_list()
    {
        $list = D('Menu')->select();
        return $list;
    }

    /**
     * ls
     */
    public function ls()
    {
        //排序
        if(!empty($_GET['sort'])){
            if($_GET['type'] == '1'){
                $type = 'asc';
                $type_num = '0';
            }else{
                $type = 'desc';
                $type_num = '1';
            }
            $sort = $_GET['sort'].' '.$type;
            $this->assign('type', $type_num);
        }else{
            $sort = 'id desc';
            $this->assign('type', '1');
        }

        //搜索
        $map = array();
        if (IS_POST) {
           $search = $this->_post('search');
        }       
        if($search){
            $map['name'] = array('like',"%{$search}%");
        }

        $pid = $this->_get('pid');
        $pid = ($pid) ? $pid : '0';
        $map['pid'] = array('eq', $pid);

        //分页
        $count = D('Menu')->where($map)->count();
        $page = page($count);
        

        $list = D('Menu')->where($map)->order($sort)->limit($page->firstRow, $page->listRows)->select();
        //print_r(D('Article')->getLastSQL());

        $this->assign('list', $list);
        $this->assign('pages', $page->show());
        $this->assign('pid', $pid);
        $this->display();
    }

    /**
     * display add menu view
     */
    public function add()
    {
        $this->assign('mainList',$this->get_main_list());
        $this->display();
    }

    /**
     * add menu
     */
    public function doAdd()
    {
        $data = $_POST;
        $result = D('Menu')->add($data);
        if(!empty($result)){
            $this->success('添加成功');
        }else{
            $this->error('添加失败');
        }
    }

    /**
     * edit menu
     */
    public function edit()
    {
        $id = intval($_GET['id']);
        $info = D('Menu')->where('id='.$id)->find();
        $this->assign('info',$info);
        $this->assign('mainList',$this->get_main_list());
        $this->display();
    }

    /**
     * do edit
     */
    public function doEdit()
    {
        $data = $_POST;
        $result = D('Menu')->save($data);
        if(!empty($result)){
            $this->success('更新成功');
        }else{
            $this->error('更新失败');
        }
    }

    /**
     * del
     */
    
    public function del()
    {
        $delIds = array();
        $postIds = $this->_post('id');
        if (!empty($postIds)) {
            $delIds = $postIds;
        }
        $getId = intval($this->_get('id'));
        if (!empty($getId)) {
            $delIds[] = $getId;
        }

        if (empty($delIds)) {
            $this->error('请选择您要删除的菜单');
        }
        $map['id'] = $pmap['pid'] = array('in', $delIds);
        if(D('Menu')->where($map)->delete()){
            D('Menu')->where($pmap)->delete();
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

}
