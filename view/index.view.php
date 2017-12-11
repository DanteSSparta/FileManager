<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/style.css" >
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>File Manager</title>
</head>
<body>
<div class="path">
    <div class="break-word">
        <a href="?p="><i class="fa fa-home" title="E:Xampp/htdocs/FileManager/File"></i></a> 
        <?= $fm->showFullPath();?>
    </div>
</div>
<form method="POST" action="">
    <table>
        <tbody>
            <tr>
                <th>Имя</th>
                <th style="width: 12%;">Размер</th>
                <th style="width: 15%;">Обновлен</th>
            </tr>
            <?php
            $files = $fm->getFiles($_SESSION['current_path']);
            $fm->showFoldersAndFile($files);
            ?>
        </tbody>
    </table>
</form>
</body>
</html>