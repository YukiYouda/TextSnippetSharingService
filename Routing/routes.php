<?php

use Helpers\DatabaseHelper;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;

return [
    '' => function (): HTTPRenderer {
        return new HTMLRenderer('top');
    },
    'share' => function (): void {
        $snippet = $_POST['snippet'];
        $randomString = bin2hex(random_bytes(8));
        $programing_language = $_POST['language'];
        $sent_time = date('Y-m-d H:i:s');

        if ($_POST['expirationDate'] == '10minutes') {
            $expiration_date = date('Y-m-d H:i:s', strtotime('+10 minutes', strtotime($sent_time)));
        } else if ($_POST['expirationDate'] == '1hour') {
            $expiration_date = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($sent_time)));
        } else if ($_POST['expirationDate'] == '1day') {
            $expiration_date = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($sent_time)));
        } else if ($_POST['expirationDate'] == '1week') {
            $expiration_date = date('Y-m-d H:i:s', strtotime('+1 week', strtotime($sent_time)));
        } else if ($_POST['expirationDate'] == '2weeks') {
            $expiration_date = date('Y-m-d H:i:s', strtotime('+2 week', strtotime($sent_time)));
        } else if ($_POST['expirationDate'] == '1month') {
            $expiration_date = date('Y-m-d H:i:s', strtotime('+1 month', strtotime($sent_time)));
        } else if ($_POST['expirationDate'] == '6months') {
            $expiration_date = date('Y-m-d H:i:s', strtotime('+6 month', strtotime($sent_time)));
        } else if ($_POST['expirationDate'] == '1year') {
            $expiration_date = date('Y-m-d H:i:s', strtotime('+1 year', strtotime($sent_time)));
        }

        DatabaseHelper::storeSnippet($snippet, $randomString, $programing_language, $sent_time, $expiration_date);

        // ランダムなURLにリダイレクト
        header("Location: share/" . $randomString);
        exit();
    },
    'share/*' => function (): HTTPRenderer {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $paths = explode('/', $url);
        $id = $paths[2];

        $snippet = DatabaseHelper::getSnippet($id);

        // 現在の日時を取得
        $currentDate = new DateTime();

        // DBに保存されている有効期限を取得
        $expirationDate = new DateTime($snippet['expiration_date']);

        // 有効期限が切れている場合は404エラーにする
        if($currentDate > $expirationDate){
            http_response_code(404);
            echo "404 Not Found: The requested route was not found on this server.";
            exit();
        }

        return new HTMLRenderer('share', ['snippet' => $snippet]);
    }
];
