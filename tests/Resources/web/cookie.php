<?php
foreach ($_COOKIE as $key => $value) {
    if($key == $_GET['name']){
        continue;
    }
    setcookie($key, '', 0);
}
setcookie($_GET['name'], $_GET['value'], ['expires'=> (int)$_GET['time'],'samesite' => $_GET['samesite'], 'secure' => (bool)$_GET['secure'], 'httponly' => (bool)$_GET['httponly']]);
?>
<!DOCTYPE html>
<html>

<head>
    <title>cookie page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <h1>cookie</h1>
</body>

</html>