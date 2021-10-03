<?php

function getRootPath()
{
    return realpath(__DIR__ . '/..');
}

function getDatabasePath()
{
    return getRootPath() . '/data/data.sqlite';
}

function getDsn()
{
    return 'sqlite:' . getDatabasePath();
}

function getPDO()
{
    return new PDO(getDsn());
}

function htmlEscape($html)
{
    return htmlspecialchars($html, ENT_HTML5, 'UTF-8');
}

function convertSqlDate($sqlDate)
{
    $date = DateTime::createFromFormat('Y-m-d', $sqlDate);
    return $date->format('d M Y');
}

function countCommentsForPost($postId)
{
    $pdo = getPDO();
    $sql = "
        SELECT
            count(*) c
        FROM
            comment
        WHERE
            post_id = :post_id
        ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        array('post_id' => $postId, )
    );
    return (int) $stmt->fetchColumn();
}

function getCommentsForPost($postId)
{
    $pdo = getPDO();
    $sql = "
        SELECT
            id, name, text, created_at, website
        FROM
            comment
        WHERE
            post_id = :post_id
        ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        array('post_id' => $postId, )
    );
 
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

