
<?php
require_once 'lib/common.php';
$pdo = getPDO();
$stmt = $pdo->query(
    'SELECT
        id, title, created_at, body
    FROM
        post
    ORDER BY
        created_at DESC'
);
if ($stmt === false)
{
    throw new Exception('There was a problem running this query');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require 'templates/title.php' ?>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <h2>
                <?php echo htmlEscape($row['title']) ?>
            </h2>
            <div>
                <?php echo convertSqlDate($row['created_at']) ?>
                (</php echo countCommentsForPost($row['id']) ?> comments)
            </div>
            <p>
                <?php echo htmlEscape($row['body']) ?>
            </p>
            <p>
                <a href="view-post.php?post_id=<?php echo $row['id'] ?>">Read more...</a>
            </p>
        <?php endwhile ?>
    </body>
</html>

