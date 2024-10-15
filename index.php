<?php
spl_autoload_extensions(".php");
spl_autoload_register();

$DEBUG = true;

// ルートをロードします。
$routes = include('Routing/routes.php');

// リクエストURIを解析してパスだけ取得します。
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = ltrim($path, '/');
$segments = explode('/', $path);

// ルートにパスが存在するかチェックします。もしくはshare/のURLかどうかをチェック。
if (isset($routes[$path]) || ((isset($segments[0]) && $segments[0] === 'share') && isset($segments[1]))) {

    if (isset($routes[$path])) {
        $renderer = $routes[$path]();
    } else {
        $renderer = $routes['share/*']();
    }

    try {
        // ヘッダーを設定します。
        foreach($renderer->getFields() as $name => $value){
            $sanitized_value = strip_tags($value);

            if($sanitized_value && $sanitized_value == $value){
                header("{$name}: {$sanitized_value}");
            } else {
                http_response_code(500);
                if($DEBUG) print("Failed setting header - original: '$value', sanitized: '$sanitized_value'");
                exit;
            }

            print($renderer->getContent());
        }
    }
    catch (Exception $e) {
        http_response_code(500);
        print("Internal error, please contact the admin.<br>");
        if($DEBUG) print($e->getMessage());
    }

} else {
    // マッチするルートがない場合、404エラーを表示します。
    http_response_code(404);
    echo "404 Not Found: The requested route was not found on this server.";
}