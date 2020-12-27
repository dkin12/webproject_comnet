<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="jquery/jquery.slidertron-0.1.js"></script>
<link rel ="stylesheet" href="/css/main.css">

<style>
img{
display: block;
margin-left: auto;
margin-right: auto;
}


.entry #board_box {width: 100%; height: 100%;}
.entry #board_box #board_list li {border-bottom: solid 1px #dddddd; }
.entry #board_box #board_list span { display: inline-block; text-align: center;}
.entry #board_box #board_list .col1 { width: 10%; }
.entry #board_box #board_list .col2 { width: 30%; text-align: left; }
.entry #board_box #board_list .col3 { width: 20%; }
.entry #board_box #board_list .col4 { width: 5%; }
.entry #board_box #board_list .col5 { width: 20%; }
.entry #board_box #board_list .col6 { width: 5%; }


iframe
{
  overflow-x:hidden;
  overflow-Y:hidden;
}

</style>

</head>

<body>
    <?php
        if(isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }

    //$conn = mysqli_connect("localhost", "root", "kje97kje", "board_schema");
    $conn = mysqli_connect("cs.cqwkirpcobml.ap-northeast-2.rds.amazonaws.com", "dbhost", "dbhost", "csdb");
    mysqli_query($conn, "set session character_set_connection=utf8;");
    mysqli_query($conn, "set session character_set_results=utf8;");
    mysqli_query($conn, "set session character_set_client=utf8;");

    // 조회수 기준으로 내림차순 정렬
    $sql = "SELECT * FROM board_table ORDER BY click_count DESC";
    $result = mysqli_query($conn, $sql);
    $total_instance = mysqli_num_rows($result);
    $scale = 5;         // 핫게는 5개!
    $number = 1;
    ?>
<hr />
<img src="/img/2.jpg" width="1020" alt="COMnet" />
<div id="page">
	<div id="page-bgtop">
<div id="sidebar">
			<ul>
				<li>
					<h2>퀴즈 랭킹</h2>

            <?php
                $sql1 = "SELECT name, point FROM members ORDER BY point DESC";

                $result1 = mysqli_query($conn, $sql1);
            ?>
            <table style="width:70%" class="table table-bordered">
            <tr>
                <td style="width:15%">랭킹</td>
                <td style="width:40%">이름</td>
                <td style="width:15%">Point</td>
            </tr>
            <?php
                //반복문을 이용하여 result 변수에 담긴 값을 row변수에 계속 담아서 row변수의 값을 테이블에 출력한다.
                for ($h = 0; $h<5; $h++) {
                    mysqli_data_seek($result1, $h);
                    $row1 = mysqli_fetch_array($result1)
            ?>
                <tr>
                    <td style="width:10%">
                        <?php
                            echo $h + 1;
                        ?>
                    </td>
                    <td style="width:10%">
                        <?php
                            echo $row1["name"];
                        ?>
                    </td>
                    <td style="width:10%">
                        <?php
                           echo $row1["point"];
                        ?>
                    </td>
                </tr>
            <?php
                }
            ?>
        </table>
				</li>
				<li>
					<h3>컴퓨터과학도를 위한 링크 </h3>
					<ul>
						<li><a href="https://www.acmicpc.net/" target="_blank">백준</a></li>
						<li><a href="https://programmers.co.kr/">프로그래머스</a></li>
						<li><a href="https://www.inflearn.com/">인프런</a></li>
						<li><a href="https://opentutorials.org/course/1/">생활 코딩</a></li>

					</ul>
				</li>
        <li>
          <div class="post">
				<h2 class="title"><a href="#">그림판</a></h2>
				<div class="entry">
                    <iframe id="draw" src="./draw/index.html" width="30%" height="30%" frameborder="0" allowTransparency="true"></iframe>
				</div>
			</div>
        </li>

			</ul>
		</div>
		<div id="content">
			<div class="post">
				<h2 class="title"><a href="#">떠오르는 게시물</a></h2>
				<div class="entry">
                <div id="board_box">
                        <ul id="board_list">
                            <li>
                                <span class="col1">번호</span>
                                <span class="col2">제목</span>
                                <span class="col3">닉네임</span>
                                <span class="col4">첨부</span>
                                <span class="col5">작성일</span>
                                <span class="col6">조회</span>
                            </li>
<?php



    for ($i = 0; $i < $scale; $i++) {
        mysqli_data_seek($result, $i);  //result에서 $i번째 instance를 선택
        $row = mysqli_fetch_array($result); // result에서 instance 1개씩 리턴

        $idx = $row["idx"];
        $board_title = $row["board_title"];
        $username = $row["username"];
        $id = $row["id"];
        $create_date = $row["create_date"];
        $click_count = $row["click_count"];

        if($row["file_name"]) { // 첨부 파일이 있으면 이미지 띄우기
            $file_image = "<img src='./board/file.gif' alt='' />";
        }  else {
            $file_image = " ";
        }
?>
                            <li>
                                <span class="col1"><?php echo $number?></span>
                                <span class="col2">
                                    <a href="board/board_read.php?idx=<?php echo $idx ?>&page=<?php echo $page?>">
                                        <?php echo $board_title?>
                                    </a>
                                </span>
                                <span class="col3"><?php echo $username?></span>
                                <span class="col4"><?php echo $file_image?></span>
                                <span class="col5"><?php echo $create_date?></span>
                                <span class="col6"><?php echo $click_count?></span>
                            </li>
<?php
    $number++;
    }
    mysqli_close($conn);
?>
                        </ul>
                    </div>
				</div>
			</div>
			<div class="post">
				<h2 class="title"><a href="#">오늘의 뉴스</a></h2>
				<div class="entry">
					<iframe id="news_container" src="/news_body.php" width="700px" height="500px" frameborder="0" allowTransparency="true"></iframe>
				</div>
			</div>
          <div class="post">
				<h2 class="title"><a href="#">오늘의 일정</a></h2>
				<div class="entry">
                    <iframe id="calendar" src="/date.php" width="800px" height="600px" frameborder="0" allowTransparency="true"></iframe>
				</div>
			</div>
		</div>
		<!-- end #content -->
	<!-- end #page -->
</div>
<div style="clear:both;"></div>
</body>
