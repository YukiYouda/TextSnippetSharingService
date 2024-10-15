<?php
namespace Helpers;

use Database\MySQLWrapper;
use DateTime;
use Exception;

class DatabaseHelper
{
    public static function storeSnippet(string $snippet, string $url, string $programing_language, string $sent_time, string $expiration_date): void {
        $db = new MySQLWrapper();

        try {
            // トランザクションの開始
            $db->begin_transaction();

            // クエリの準備
            $stmt = $db->prepare("INSERT INTO snippets (snippet, url, programing_language, sent_time, expiration_date) VALUES(?,?,?,?,?)");

            if(!$stmt){
                throw new Exception("Prepare failed: " . $db->error);
            }

            // パラメータのバインド
            $stmt->bind_param('sssss', $snippet, $url, $programing_language, $sent_time, $expiration_date);

            // クエリの実行
            if(!$stmt->execute()){
                throw new Exception("Execute failed: " . $stmt->error);
            }

            // コミット (成功時)
            $db->commit();
        } catch(Exception $e) {
            // エラー発生時のロールバック
            $db->rollback();
            echo "Transaction failed: " . $e->getMessage();
        }
    }

    public static function getSnippet(string $url): array {
        $db = new MySQLWrapper();

        $stmt = $db->prepare("SELECT * FROM snippets WHERE url = ?");
        $stmt->bind_param('s', $url);
        $stmt->execute();

        $result = $stmt->get_result();
        $snippet = $result->fetch_assoc();

        if (!$snippet) throw new Exception('Could not find a single part in database');

        return $snippet;
    }
}