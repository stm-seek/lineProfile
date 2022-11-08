<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <!-- https://i.pinimg.com/564x/29/c1/37/29c1370e77372a49bfe5278990ce2829.jpg -->
</head>

<body>
    <?php
    require_once 'connect.php';
    ?>
    <div class="card">
        <div class="navigation">
            <div class="menu-toggle"></div>
            <ul class="menu">
                <li>
                    <a href="#">
                        <ion-icon name="person-outline"></ion-icon>ดูประวัติย้อนหลัง
                    </a>
                </li>
                <li>
                    <a href="#">
                        <ion-icon name="chatbox-outline"></ion-icon>ชำระค่าบริการ
                    </a>
                </li>
                <li>
                    <a href="#">
                        <ion-icon name="log-out-outline"></ion-icon>ออกจากระบบ
                    </a>
                </li>
            </ul>
        </div>
        <div class="img">
            <img id="img-profile">
        </div>
        <div class="infos">
            <div class="name">
                <h2 id="username"></h2>
                <h4 id="email"></h4>
            </div>

            <div class="panel-info">
                <div class="panel panel-1">
                    <h3 class="cal"></h3>
                    <span>แคลอรี่ต่อวัน</span>
                </div>
                <div class="panel panel-2">
                    <h3 class="bmr"></h3>
                    <span>ค่า BMR ที่ควรได้รับ</span>
                </div>
            </div>


            <div class="flex-wrapper">
                <div style="width: 35%;" class="single-chart">
                    <svg id="cal-persen" viewBox="0 0 36 36" class="circular-chart orange">
                        <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <?php
                        if (isset($_COOKIE["uid"])) {
                            $uid = $_COOKIE["uid"];

                            $sql = $conn->query("select  SUM(cal) AS sumCal, u.firstName, u.weight, u.height, u.lastname, u.level, u.age, u.rfid, p.name, p.protein, p.carbo, p.vitamin, p.fat, p.cal , p.sodium from products_line pl join products p ON p.id = pl.products_id join user u ON u.user_id = pl.user_id join parent pt ON pt.parentID = u.parent_parentID  WHERE line_user_id = '$uid'");

                            if ($sql) {
                                $result = $sql->fetchAll();

                                //BMR
                                $bmr = 66 + (13.7 * $result[0]['weight']) + (5 * $result[0]['height']) - (6.8 * $result[0]['age']);

                                $sum = ($result[0]['sumCal'] * 100) / $bmr;

                        ?>
                                <path class="circle" stroke-dasharray="<?= $sum ?>, 100" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />

                                <text x="18" y="20.35" class="percentage cal">0</text>
                        <?php
                            }
                        }
                        ?>
                    </svg>
                    <p>ค่า Cal / BMR</p>
                </div>

                <div style="width: 35%;" class="single-chart">
                    <svg viewBox="0 0 36 36" class="circular-chart green">
                        <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <?php
                        if (isset($_COOKIE["uid"])) {
                            $uid = $_COOKIE["uid"];

                            $sql = $conn->query("select  SUM(cal) AS sumCal, u.firstName, u.weight, u.height, u.lastname, u.level, u.age, u.rfid, p.name, p.protein, p.carbo, p.vitamin, p.fat, p.cal , p.sodium from products_line pl join products p ON p.id = pl.products_id join user u ON u.user_id = pl.user_id join parent pt ON pt.parentID = u.parent_parentID  WHERE line_user_id = '$uid'");

                            if ($sql) {
                                $result = $sql->fetchAll();

                                //BMR
                                $bmi = $result[0]['weight'] / (($result[0]['height'] / 100) ** 2);

                                $sum = ($bmi * 100) / 30;

                        ?>
                                <path class="circle" stroke-dasharray="<?= $sum ?>, 100" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />

                                <text x="18" y="20.35" class="percentage bmi">0</text>
                        <?php
                            }
                        }
                        ?>
                    </svg>
                    <p>ค่า BMI</p>
                </div>
            </div>

            <div class="warning">
                <h5 style="color: red;">*ระดับ BMI ต่ำกว่าเกณฑ์</h5>
            </div>


            <div class="userInfo">
                <div class="line"></div>
                <div class="title">
                    <h4>ข้อมูลส่วนตัวของนักเรียน</h4>
                    <p>ชื่อ : <strong id="child_name"></strong></p>
                    <p>อายุ : <strong id="age"></strong></p>
                    <p>ระดับชั้นปีที่ : <strong id="level"></strong></p>
                    <p>ส่วนสูง : <strong id="height"></strong></p>
                    <p>น้ำหนัก : <strong id="weight"></strong></p>
                </div>
            </div>

            <div class="links">
                <button class="view">ปิด</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://static.line-scdn.net/liff/edge/versions/2.9.0/sdk.js"></script>
    <script src="js.js"></script>

    <script>
        function runApp() {
            liff.getProfile().then(profile => {
                document.getElementById("username").innerHTML = `สวัสดีคุณ ${profile.displayName}`;
                document.getElementById("img-profile").src = profile.pictureUrl;
                document.getElementById("email").innerHTML = `@${liff.getDecodedIDToken().email}`;
                getData(profile.userId);

            }).catch(err => console.error(err));
        }

        liff.init({
            liffId: "1657403396-qbRA53Z7"
        }, () => {
            if (liff.isLoggedIn()) {
                runApp();
            } else {
                liff.login();
            }
        }, err => console.error(err.code, error.message));


        function getData(id) {
            $.ajax({
                type: 'POST',
                url: 'getData.php',
                data: {
                    user_id: id
                },
                dataType: 'json',
                success: function(res) {
                    let bmiresult = bmi(parseInt(res.height), parseInt(res.weight));
                    let bmii = bmiresult.toFixed(2);

                    let bmrresult = bmr_man(parseInt(res.height), parseInt(res.weight), parseInt(res.age));
                    let bmrr = bmrresult.toFixed();

                    let BMIpersen = ((parseInt(res.sumCal) * 100) / bmrr).toFixed(2);

                    $('#child_name').html(`${res.firstName} ${res.lastname}`);
                    $('#age').html(res.age + ' ปี');
                    $('#level').html(res.level);
                    $('#height').html(res.height + ' เซนติเมตร');
                    $('#weight').html(res.weight + ' กิโลกรัม');
                    $('.cal').html(res.sumCal);


                    $('.bmi').html(bmii);
                    $('.bmr').html(bmrr + ' Cal');

                    createCookie('uid', id, "1");

                    /* var horizontals = document.querySelectorAll('#cal-persen path');

                    for (var i = 0; i < horizontals.length; i++) {
                        var path = horizontals[i],
                            length = path.getTotalLength();

                        path.style.strokeDasharray = `${BMIpersen}, ${100}`;
                    } */


                    //console.log($('.cal-draw').stroke('dasharray'));
                }
            });
        }

        function bmi(height, weight) {
            return weight / ((height / 100) ** 2);
        }

        function bmr_man(height, weight, age) {
            return 66 + (13.7 * weight) + (5 * height) - (6.8 * age);
        }

        function createCookie(name, value, days) {
            var expires;
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            } else {
                expires = "";
            }
            document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
        }
    </script>
</body>

</html>