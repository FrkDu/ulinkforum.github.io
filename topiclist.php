<?php
/**
 * Created by PhpStorm.
 */
include_once ('include3.php');
doDB();
$get_topics_sql = "select topic_id,topic_title, DATE_FORMAT(topic_create_time,'%b %e %Y at %r') AS 
        fmt_topic_create_time,topic_owner from forum_topics order by topic_create_time desc";
$get_topics_res = mysqli_query($conn3,$get_topics_sql) or die(mysqli_error($conn3));
 
if(mysqli_num_rows($get_topics_res) < 1)
{
    $display_block = "<p><strong>没有相应的主题存在！</strong></p>";
}
else
{
    $display_block = <<< END_OF_TEXT
    <table>
        <tr>
            <th>主题题目</th>
            <th>回复数</th>
        </tr>
END_OF_TEXT;
 
    while($topic_info = mysqli_fetch_array($get_topics_res))
    {
        $topic_id = $topic_info['topic_id'];
        $topic_title = stripslashes($topic_info['topic_title']);
        $topic_create_time = $topic_info['fmt_topic_create_time'];
        $topic_owner = stripslashes($topic_info['topic_owner']);
 
        $get_num_posts_sql = "select count(post_id) as post_count from forum_posts where topic_id=$topic_id";
        $get_num_posts_res = mysqli_query($conn3,$get_num_posts_sql) or die(mysqli_error($conn3));
 
        while($posts_info = mysqli_fetch_array($get_num_posts_res))
        {
            $num_posts = $posts_info['post_count'];
        }
 
        $display_block .= <<< END_OF_TEXT
        <tr>
            <td><a href="showtopic.php?topic_id=$topic_id"><strong>$topic_title</strong></a><br>
            由 $topic_owner 于 $topic_create_time 创建的。</td>
            <td class="num_posts_col">$num_posts</td>
        </tr>
END_OF_TEXT;
 
    }
    mysqli_free_result($get_topics_res);
    mysqli_free_result($get_num_posts_res);
    mysqli_close($conn3);
    $display_block .= "</table>";
 
}
 
?>
 
<html>
<head>
    <title>简易论坛</title>
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
        }
 
        .num_posts_col
        {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>简易论坛</h1>
    <?php echo $display_block;?>
    <p>你也可以<a href="addtopic.php">新建一个主题</a>!</p>
</body>
</html>
