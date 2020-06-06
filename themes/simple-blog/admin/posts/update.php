<?php
require_once '../../lib/auth.php';
if (!login_check()) {
    header('location:../login.php');
}
require_once '../../lib/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    post_update($_POST);
    header('location:index.php');
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $post = post_find_by_id($id);
} else {
    header('location:index.php');
}
$categories = category_all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Post</title>
    <link rel="stylesheet" href="../../css/admin/posts/create.css">
</head>
<body>
<form action="update.php" method="post">
    <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
    <div>
        <label for="title">title: </label>
        <input type="text" name="title" id="title" value="<?php echo $post['title'] ?>">
    </div>
    <div>
        <label for="category_id">Category: </label>
        <select name="category_id" id="category_id">
            <option value="0">Select A Category</option>
            <?php
            $html = '';
            foreach ($categories as $category) {
                if ($category['id'] == $post['category_id']) {
                    $html .= "<option selected value='{$category['id']}'>{$category['name']}</option>";
                }else{
                    $html .= "<option value='{$category['id']}'>{$category['name']}</option>";
                }
            }
            echo $html;
            ?>
        </select>
    </div>
    <div>
        <label for="body">body: </label>
        <textarea name="body" id="body" rows="10"><?php echo $post['body'] ?></textarea>
    </div>
    <div>
        <label></label>
        <input type="submit" value="Update Post">
        <a href="index.php">Cancel</a>
    </div>
</form>
</body>
</html>
