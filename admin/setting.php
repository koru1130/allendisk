<?php
/*
Allen Disk 1.6
Copyright (C) 2012~2016 Allen Chou
Author: Allen Chou ( http://allenchou.cc )
License: MIT License
*/
require_once dirname(dirname(__FILE__)).'/config.php';
if (!session_id()) {
    session_start();
}
if ($_SESSION['alogin']) {
    if (isset($_GET['set']) && $_GET['set'] == 'set') {
        $db->update('setting', array('value' => $_POST['sitename']), array('name' => 'sitename'));
        $db->ExecuteSQL(sprintf("UPDATE `setting` SET `value` = '%s' WHERE `setting`.`name` = 'sitetitle';", $db->databaseLink->real_escape_string($_POST['sitetitle'])));
        $db->update('setting', array('value' => $_POST['size']), array('name' => 'size'));
        $db->update('setting', array('value' => $_POST['url']), array('name' => 'url'));
        $db->update('setting', array('value' => $_POST['total']), array('name' => 'total'));
        $db->update('setting', array('value' => $_POST['admin']), array('name' => 'admin'));
        $db->update('setting', array('value' => $_POST['subtitle']), array('name' => 'subtitle'));

        if ($_POST['tos'] != 'true') {
            $tos = 'false';
        } else {
            $tos = 'true';
        }
        $db->update('setting', array('value' => $tos), array('name' => 'tos'));
        if ($_POST['why'] != 'true') {
            $why = 'false';
        } else {
            $why = 'true';
        }
        $db->update('setting', array('value' => $why), array('name' => 'why'));
        if ($_POST['reg'] != 'true') {
            $reg = 'false';
        } else {
            $reg = 'true';
        }
        $db->update('setting', array('value' => $reg), array('name' => 'reg'));
        header('location: setting.php?s=1');
    }
    ?>
<!DOCTYPE html>
<html>
<head>
<title>管理員介面 - <?php echo $config['sitename'];
    ?></title>
<link href="../css/bootstrap.min.css" rel="stylesheet">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<style>body{ background-color: #F8F8F8; }</style>
</head>
<body>
<div class="container">
    <h1 class="text-center"><?php echo $config['sitetitle'];
    ?> 管理介面</h1>
    <ul class="nav nav-tabs">
        <li><a href="index.php">管理介面首頁</a></li>
        <li class="active">
            <a href="#">設定</a>
        </li>
        <li><a href="newuser.php">新增使用者</a></li>
        <li><a href="manuser.php">管理使用者</a></li>
        <li><a href="../index.php">回到首頁</a></li>
        <li><a href="login.php">登出</a></li>
    </ul>
<?php if (isset($_GET['s']) && $_GET['s'] == '1') {
    echo '<div class="alert alert-success">設定修改完成</div>';
}
    ?>
<form method="post" action="?set=set">
<table class="table table-hover">
    <thead>
        <tr>
            <td>名稱</td>
            <td>值</td>
            <td>註解</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>網頁標題</td>
            <td><input type="text" value="<?php echo $config['sitename'];
    ?>" name="sitename" id="sitename" class="form-control" /></td>
            <td>顯示在&lt;title&gt;，所以別使用HTML Tag</td>
        </tr>
        <tr>
            <td>網頁名稱</td>
            <td><input type="text" value="<?php echo htmlspecialchars($config['sitetitle']);
    ?>" name="sitetitle" id="sitetitle" class="form-control" /></td>
            <td>可以利用&lt;img&gt;來顯示Logo</td>
        </tr>
        <tr>
            <td>上傳單檔大小限制</td>
            <td><input type="text" value="<?php echo $config['size'];
    ?>" name="size" id="size" class="form-control" /></td>
            <td>單一檔案上傳最大限制，單位為MB，1000MB = 1GB，必須 ≤ upload_max_filesize & post_max_size ， 0 代表無限</td>
        </tr>
        <tr>
            <td>使用者空間</td>
            <td><input type="text" value="<?php echo $config['total'];
    ?>" name="total" id="total" class="form-control" /></td>
            <td>單一使用者最大可用空間，單位為MB，1000MB = 1GB ， 0 代表無限</td>
        </tr>
        <tr>
            <td>網站網址</td>
            <td><input type="text" value="<?php echo $config['url'];
    ?>" name="url" id="url" class="form-control" /></td>
            <td>填入「首頁網址」而非管理員介面網址，記得加上" http(s):// "和網址最後的" / "</td>
        </tr>
        <tr>
            <td>標語</td>
            <td><input type="text" value="<?php echo $config['subtitle'];
    ?>" name="subtitle" id="subtitle" class="form-control" /></td>
            <td>顯示在首頁的標語</td>
        </tr>
        <tr>
            <td>啟用註冊功能</td>
            <td><input type="checkbox" <?php if ($config['reg']) {
    echo 'checked';
}
    ?> name="reg" id="reg" value="true" /></td>
            <td>允許使用者註冊帳號，個人用網路硬碟請勿勾選</td>
        </tr>
        <tr>
            <td>顯示「為何選用XXX」</td>
            <td><input type="checkbox" <?php if ($config['why']) {
    echo 'checked';
}
    ?> name="why" id="why" value="true" /></td>
            <td>內容請至why.php修改</td>
        </tr>
        <tr>
            <td>顯示「使用條款」</td>
            <td><input type="checkbox" <?php if ($config['tos']) {
    echo 'checked';
}
    ?> name="tos" id="tos" value="true" /></td>
            <td>單一使用者可以使用的空間</td>
        </tr>
        <tr>
            <td>管理員密碼</td>
            <td><input type="text" value="<?php $res = $db->select('setting', array('name' => 'admin'));
    echo $res[0]['value']?>" name="admin" id="admin" class="form-control" /></td>
            <td>到此介面的密碼</td>
        </tr>
    </tbody>
</table>
<input type="submit" value="送出" class="btn btn-primary">
</form>
</br>
</div>
<p class="text-center text-info">Proudly Powered by <a href="http://ad.allenchou.cc/">Allen Disk</a></p>
</body>
</html>
<?php

} else {
    header('location:login.php');
}
?>
