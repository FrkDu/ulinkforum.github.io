<html>
<head>
    <title>增加一个主题</title>
</head>
<body>
    <h1>增加一个主题</h1>
    <form method="post" action="to_addtopic.php">
        <p><label for="topic_owner">你的邮件地址:</label><br>
        <input type="email" id="topic_owner" name="topic_owner" size="40" maxlength="150"
 required="required"></p>
 
        <p><label for="topic_title">主题题目：</label><br>
        <input type="text" name="topic_title" id="topic_title" size="40" maxlength="150"
 required="required"></p>
 
        <p><label for="post_text">回复内容：</label><br>
        <textarea id="post_text" name="post_text" rows="8" cols="40"></textarea></p>
 
        <button type="submit" name="submit" value="submit">增加主题</button>
    </form>
</body>
</html>
