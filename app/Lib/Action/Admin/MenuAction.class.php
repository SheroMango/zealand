<?php
/**
 * 菜单控制器
 */
class MenuAction extends HomeAction
{
    private function get_token(){
        $ch = curl_init();
        $appid = D('Setting')->where("skey='appid'")->getField('svalue');
        $appsecret = D('Setting')->where("skey='appsecrect'")->getField('svalue');

        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSTER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        return $result['access_token'];
    }


    public function createMenu(){

        //$token = $this->get_token();
        $ch = curl_init();
        $token = 'test';
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$token;
        $data = D('Menu')->where('pid=0')->order('sort desc')->select();
        foreach($data as $k=>$v){
            $subList = D('Menu')->where('pid='.$v['id'])->order('sort desc')->select();
            if(!empty($subList)){
                $list[$k]['name'] = urlencode($v['name']);
                foreach($subList as $k2=>$v2){
                    $newSubList[$k2]['type'] = $v2['type'];
                    $newSubList[$k2]['name'] = urlencode($v2['name']);
                    if($v2['type'] == 'view'){
                        $newSubList[$k2]['url'] = $v2['value'];
                    }else{
                        $newSubList[$k2]['key'] = urlencode($v2['value']);
                    }

                    $list[$k]['sub_button'] = $newSubList;
                }
            }else{
                $list[$k]['type'] = $v['type'];
                $list[$k]['name'] = urlencode($v['name']);
                if($v['type'] == 'view'){
                    $list[$k]['url'] = $v['value'];
                }else{
                    $list[$k]['key'] = urlencode($v['value']);
                }
            }

        }
        $list = urldecode(json_encode(array('button'=>$list)));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, 1);//发送一个post请求
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//post提交的数据包
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);//设置限制时间
        curl_setopt($ch, CURLOPT_HEADER, 0);//显示返回的header区域内容
        curl_setopt($ch, CURLOPT_RETURNTRANSTER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        if($result['errcode'] == '0'){
            $this->success('菜单更新成功');
        }else{
            $this->error('菜单更新失败');
        }
    }
    /**
     * get main menu list
     */
    public function get_main_list()
    {
        $list = D('Menu')->where('pid=0')->select();
        return $list;
    }

    /**
     * ls
     */
    public function ls()
    {
        $list = D('Menu')->where('pid=0')->order('sort desc')->select();
        foreach($list as $k=>$v){
            $list[$k]['list'] = D('Menu')->where('pid='.$v['id'])->order('sort desc')->select();
        }

        $this->assign('list', $list);
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
