function doDB()
{
    global $conn3;
 
    $conn3 = mysqli_connect('localhost','root','','php_project01');
    if(mysqli_connect_errno())
    {
        echo "数据库连接失败！".mysqli_connect_error()."<br>";
        exit();
    }
}
