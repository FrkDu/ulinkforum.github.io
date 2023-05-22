<?php
/**
 * Created by PhpStorm.
 */
 
include ('include3.php');
doDB();
 
if((!$_POST['topic_owner']) || (!$_POST['topic_title']) || (!$_POST['post_text']))
{
    header("Location:addtopic.php");
    exit;
}
 
$topic_owner = mysqli_real_escape_string($conn3,$_POST['topic_owner']);
$topic_title = mysqli_real_escape_string($conn3,$_POST['topic_title']);
$post_text = mysqli_real_escape_string($conn3,$_POST['post_text']);
 
$add_topic_sql = "insert into forum_topics(topic_title,topic_create_time,topic_owner)
    values('$topic_title',now(),'$topic_owner')";
$add_topic_result = mysqli_query($conn3,$add_topic_sql);
 
$topic_id = mysqli_insert_id($conn3);
 
$add_post_sql = "insert into forum_posts(topic_id,post_text,post_create_time,post_owner)
    values('$topic_id','$post_text',now(),'$topic_owner')";
$add_post_result = mysqli_query($conn3,$add_post_sql);
 
mysqli_close($conn3);
 
$display_block = "<p><strong>".$_POST['topic_title']."</strong>已创建成功！</p>";
?>
<html>
<head>
    <title>增加新主题</title>
</head>
<body>
    <h1>增加新主题</h1>
    <?php echo $display_block;?>
</body>
</html>
