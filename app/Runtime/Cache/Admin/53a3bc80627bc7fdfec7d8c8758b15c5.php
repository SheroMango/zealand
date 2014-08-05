<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>后台管理</title>

<!--CSS BEGIN-->
<link href="__PUBLIC__/Home/css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="./public/js/plugin/fancybox/jquery.fancybox.css?v=2.1.4" />
<link href="__PUBLIC__/css/base.css"       rel="stylesheet" type="text/css">
<link href="__PUBLIC__/css/common.css"     rel="stylesheet" type="text/css">
<link href="__PUBLIC__/Home/css/page.css"  rel="stylesheet" type="text/css">
<link href="__PUBLIC__/jquery.ui/jquery-ui.css" rel="stylesheet" type="text/css">
<!--CSS END-->

<!--JS BEGIN-->
<script type="text/javascript" src="__PUBLIC__/js/jquery.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/base.js"></script> 
<script type="text/javascript" src="__PUBLIC__/js/common.js"></script>  
<script type="text/javascript" src="__PUBLIC__/Home/js/page.js"></script>
<script type="text/javascript" src="__PUBLIC__/jquery.ui/jquery-ui.js"></script>
<!--script type="text/javascript" src="http://code.jquery.com/qunit/qunit-1.14.0.js"></script-->
<!--JS BEGIN-->


</head>
<body>
<div class="content">


  <!--选项卡 BEGIN-->
  <div class="tabs">
    <ul>
      <li class="current"><a href="javascript:void(0)" class="current">菜单列表</a></li>
    </ul>
  </div>
  <!--END 选项卡-->

 <!--工具栏 BEGIN-->
  <div class="toolbar">
      <a href="<?php echo U('Admin/Menu/add');?>" class="btn"><span>添加菜单</span></a>
      <a href="<?php echo U('Admin/Menu/createMenu');?>" class="btn"><span>更新菜单</span></a>
  </div>
  <!--END工具栏 BEGIN-->

 <!--搜索 BEGIN-->
<div class="search">
    <form action="<?php echo U('Admin/Menu/ls');?>" method="post">
        <table width="100%">
            <td width="100">
              <input type="text" name="search" class="w300 mr10" placeholder="请输入名称进行查询" />
            </td>
            <td><input type="submit" value="搜 索" class="btn search-btn" /></td>
        </table>
    </form>
</div>
<!--END 搜索--> 

 
  <!--列表 BEGIN-->
  <div class="list">
      <form action="<?php echo U('Admin/Menu/del');?>" method="post" class="del-form">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th width="5%"><input type="checkbox" class="check-all" /></th>
            <th width="20%"><a href="<?php echo U('Admin/Menu/ls',array('sort'=>'name','type'=>$type));?>">名称</th>
            <th width="20%"><a href="<?php echo U('Admin/Menu/ls',array('sort'=>'type','type'=>$type));?>">类型</th>
            <th width="20%"><a href="<?php echo U('Admin/Menu/ls',array('sort'=>'value','type'=>$type));?>">值</th>
            <th width="20%"><a href="<?php echo U('Admin/Menu/ls',array('sort'=>'sort','type'=>$type));?>">排序</th>
            <th width="15%">操作</th>
          </tr>
        </thead>
        <tbody>
          <?php if(empty($list)): ?><tr>
              <td colspan="11" class="empty">暂无相关菜单</td>
            </tr>
          <?php else: ?>
          <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                <td><input type="checkbox" name="id[]" value="<?php echo ($vo["id"]); ?>"></td>
                <td><?php echo ($vo["name"]); ?></td>
                <td><?php echo ($vo["type"]); ?></td>
                <td><?php echo ($vo["value"]); ?></td>
                <td><?php echo ($vo["sort"]); ?></td>
                <td>
                    <a href="<?php echo U('Admin/Menu/edit',array('id'=>$vo[id]));?>" class="mr10">编辑</a>
                    <a href="<?php echo U('Admin/Menu/del',array('id'=>$vo[id]));?>">删除</a>
                </td>
              </tr>

            <?php if(!empty($vo['list'])): if(is_array($vo['list'])): $i = 0; $__LIST__ = $vo['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?><tr>
                <td><input type="checkbox" name="id[]" value="<?php echo ($voo["id"]); ?>"></td>
                <td>----<?php echo ($voo["name"]); ?></td>
                <td><?php echo ($voo["type"]); ?></td>
                <td><?php echo ($voo["value"]); ?></td>
                <td><?php echo ($voo["sort"]); ?></td>
                <td>
                    <a href="<?php echo U('Admin/Menu/edit',array('id'=>$voo[id]));?>" class="mr10">编辑</a>
                    <a href="<?php echo U('Admin/Menu/del',array('id'=>$voo[id]));?>">删除</a>
                </td>
              </tr><?php endforeach; endif; else: echo "" ;endif; endif; endforeach; endif; else: echo "" ;endif; endif; ?>
        </tbody>
      </table>
    </form>
  </div>
  <!--列表 END-->

  <!--工具栏 BEGIN-->
  <div class="toolbar">
    <a href="javascript:void(0)" class="btn del-btn"><span>删除</span></a>
    <div class="page right">
      <?php echo ($pages); ?>
    </div>
  </div>
  <!--END 工具栏-->

</div>
</body>
</html>