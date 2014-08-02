<?php
/**
 * 文章控制器
 */
class ArticleAction extends HomeAction
{

   

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
            $map['title'] = array('like',"%{$search}%");
        }

        $pid = $this->_get('pid');
        $pid = ($pid) ? $pid : '0';
        $map['pid'] = array('eq', $pid);

        //分页
        $count = D('Article')->where($map)->count();
        $page = page($count);
        

        $list = D('Article')->where($map)->order($sort)->limit($page->firstRow, $page->listRows)->select();
        //print_r(D('Article')->getLastSQL());

        $this->assign('list', $list);
        $this->assign('pages', $page->show());
        $this->assign('pid', $pid);
        $this->display();
    }

    /**
     * info
     */
    public function info()
    {
        $obj = D('Article');
        if(empty($_POST)){
            $id = $this->_get('id');
            if(!empty($id)){
                $info = $obj->where('id='.$id)->find();
                $pid = $info['pid'];
                $this->assign('info', $info);
            }else{
                $pid = $this->_get('pid');
            }
            $this->assign('pid', $pid);
            $this->display();
            exit;
        }
        $data = $this->_post();
        if(!empty($_FILES['pic']['name'])){
            $picList = uploadPic();
            if($picList['code'] != 'error'){
                $data['cover'] = $picList['pic']['savename'];
            }
        }
        $data['time_modify'] = time();
        if(empty($data['id'])){
            $obj->add($data);
            $data['time_add'] = time();
        }else{
            $obj->save($data);
        }
        $this->success('操作成功', U('Article/ls',array('pid'=>$data['pid'])));

        
    }
    
    public function del(){
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
            $this->error('请选择您要删除的文章');
        }
        $map['id'] = $pmap['pid'] = array('in', $delIds);
        if(D('Article')->where($map)->delete()){
            D('Article')->where($pmap)->delete();
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

}
