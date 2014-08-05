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

<div class="tabs">
    <ul>
        <li class="current"><a href="javascript:void(0)" class="current">文章信息</a></li>
    </ul>
</div>
<div class="edit">
    <form method="post" action="<?php echo U('Admin/Article/info');?>" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>" />
        <input type="hidden" name="pid" value="<?php echo ($pid); ?>">
        <dl>
            <dt>标题：</dt>
            <dd><input type="text" name="title" value="<?php echo ($info["title"]); ?>" class="w200" /></dd>
        </dl>
        <dl>
            <dt>封面：</dt>
            <dd><input type="file" name="pic"></dd>
            <?php if(!empty($info[cover])): ?><dd><img src="<?php echo (getpicpath($info[cover])); ?>" height="50px"></dd><?php endif; ?>
        </dl>
        <dl>
            <dt>描述：</dt>
            <dd><textarea name="intro" cols="80" rows="4"><?php echo ($info["intro"]); ?></textarea></dd>
        </dl>
        <dl>
            <dt>内容：</dt>
            <dd><textarea name="info" id="editor" cols="80" rows="4"><?php echo ($info["info"]); ?></textarea></dd>
        </dl>
        <dl>
            <dt>排序：</dt>
            <dd><input type="number" name="sort" value="<?php echo ($info["sort"]); ?>" class="w200" /></dd>
        </dl>
        <dl>
            <dt></dt>
            <dd><input type="submit" value="保 存" class="btn submit-btn" /></dd>
        </dl>
    </form>
</div>
</div>
</body>
</html>

<script type="text/javascript" src="__PUBLIC__/js/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/ueditor/ueditor.all.js"></script>
<script type="text/javascript">
UE.getEditor('editor');
</script>