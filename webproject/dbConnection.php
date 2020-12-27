<?php
$con = mysqli_connect("cs.cqwkirpcobml.ap-northeast-2.rds.amazonaws.com", "dbhost", "dbhost", "csdb");
    mysqli_query($con, "set session character_set_connection=utf8;");
    mysqli_query($con, "set session character_set_results=utf8;");
    mysqli_query($con, "set session character_set_client=utf8;");
?>