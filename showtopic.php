<?php
/**
 * Created by PhpStorm.
 */
 
include ('include3.php');
doDB();
 
if(!isset($_GET['topic_id']))
{
    header("location:topiclist.php");
    exit;
}
 
$topic_id = mysqli_real_escape_string($conn3,$_GET['topic_id']);
$topic_sql = "select topic_title from forum_topics where topic_id = $topic_id";
$topic_res = mysqli_query($conn3,$topic_sql) or die(mysqli_error($conn3));
 
if(mysqli_num_rows($topic_res) < 1)
{
    $display_block = "<p><strong>你选择的主题题目已不存在，请<a href='topiclist.php'>重新选择</a>！</strong></p>";
}
else
{
    while($topic_info = mysqli_fetch_array($topic_res))
    {
        $topic_title = stripslashes($topic_info['topic_title']);
    }
 
    $get_posts_sql = "select post_id,post_text, DATE_FORMAT(post_create_time,'%b %e %Y %r') as fmt_post_create_time,
        post_owner from forum_posts where topic_id=$topic_id order by post_create_time asc";
    $get_post_res = mysqli_query($conn3,$get_posts_sql) or die(mysqli_error($conn3));
 
    $display_block = <<< END_OF_TEXT
    <p>关于<stron>[$topic_title]</stron>的相关回复内容如下:</p>
    <table >
        <tr>
            <th>回复</th>
            <th>内容</th>
        </tr>
    
END_OF_TEXT;
 
    while($posts_info = mysqli_fetch_array($get_post_res))
    {
        $post_id = $posts_info['post_id'];
        $post_text =nl2br(stripslashes($posts_info['post_text']));
        $post_create_time  = $posts_info['fmt_post_create_time'];
        $post_owner = stripslashes($posts_info['post_owner']);
 
        $display_block .= <<< END_TEXT
        <tr>
            <td>回复人：$post_owner<br><br>
            创建时间：$post_create_time</td>
            <td>$post_text<br><br>
            <a href="replytopost.php?post_id=$post_id"><strong>回复该帖</strong></a></td>
        </tr>
END_TEXT;
 
    }
 
    mysqli_free_result($get_post_res);
    mysqli_free_result($topic_res);
    mysqli_close($conn3);
 
    $display_block .= "</table>";
}
 
?>
 
<html>
<head>
    <title>查看帖子</title>
    <style type="text/css">
        table
        {
            border: 1px solid black;
            border-collapse: collapse;
 
        }
 
        th
        {
            border: 1px solid black;
            padding: 6px;
            font-weight: bold;
            background-color: #cccccc;
        }
 
        td
        {
            border: 1px solid black;
            padding: 6px;
            vertical-align: top;
        }
 
 
    </style>
</head>
<body>
    <h1>查看帖子</h1>
    <?php echo $display_block;?>
</body>
</html>
