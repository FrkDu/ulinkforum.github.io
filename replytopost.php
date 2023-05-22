<?php
/**
 * Created by PhpStorm.
 */
 
include ('include3.php');
doDB();
 
if(!$_POST)
{
    if (!isset($_GET['post_id']))
    {
 
        header("location:topiclist.php");
        exit;
    }
 
    $post_id = mysqli_real_escape_string($conn3, $_GET['post_id']);
    $sql = "select ft.topic_id,ft.topic_title from forum_posts as fp LEFT JOIN forum_topics as ft ON fp.topic_id
      = ft.topic_id where fp.post_id=$post_id";
 
    $res = mysqli_query($conn3, $sql);
 
    if (mysqli_num_rows($res) < 1)
    {
        //header("location:topiclist.php");
        exit;
    }
    else
        {
        while ($topic_info = mysqli_fetch_array($res))
        {
            $topic_id = $topic_info['topic_id'];
            $topic_title = stripslashes($topic_info['topic_title']);
        }
 
        ?>
 
        <html>
        <head>
            <title>回复帖子</title>
        </head>
        <body>
        <h1>回复[<?php echo $topic_title; ?>]的帖子。</h1>
        <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
            <p><label for="post_owner">邮箱地址：</label>
                <input type="email" id="post_owner" name="post_owner" size="40" maxlength="150" required="required"></p>
            <p><label>回复内容：</label>
                <textarea id="post_text" name="post_text" rows="8" cols="50" required="required"></textarea></p>
            <input type="hidden" name="topic_id" id="topic_id" value="<?php echo $topic_id; ?>">
            <button type="submit" name="submit" value="submit">提交回复</button>
        </form>
        </body>
        </html>
 
        <?php
    }
 
    mysqli_free_result($res);
    mysqli_close($conn3);
}
else if($_POST)
{
    if((!$_POST['topic_id']) || (!$_POST['post_text']) || (!$_POST['post_owner']))
    {
        header("location:topiclist.php");
        exit;
    }
 
    $topic_id = mysqli_real_escape_string($conn3,$_POST['topic_id']);
    $post_text = mysqli_real_escape_string($conn3,$_POST['post_text']);
    $post_owner = mysqli_real_escape_string($conn3,$_POST['post_owner']);
 
    $add_post_sql = "insert into forum_posts(topic_id,post_text,post_create_time,post_owner)
      values('$topic_id','$post_text',now(),'$post_owner')";
 
    $add_post_res = mysqli_query($conn3,$add_post_sql) or die(mysqli_error($conn3));
 
    mysqli_close($conn3);
 
    header("location:showtopic.php?topic_id=$topic_id");
    exit;
}
 
?>
 
