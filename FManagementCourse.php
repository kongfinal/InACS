<?php 
session_start();
        $term = $_SESSION["IDTerm"];

        if(isset($_POST['terms'])){
            $_SESSION["IDTerm"] = $_POST['terms'];
            $_SESSION["Pagination"] = 1;
            Header("Location: course-management.php");
        }

        if(isset($_POST['addCourseModal'])){
            $_SESSION['CheckOpenModalAdd'] = true;
            Header("Location: course-management.php");
        }

        if(isset($_POST['editCourseModal'])){
            
            include("condb.php");
            $_SESSION['IDEdit'] = $_POST['editCourseModal'];

            $IDEdit = $_POST['editCourseModal'];
            $queryCourseEdit = "SELECT * FROM `inacs_course` WHERE ID='$IDEdit'";
            $CourseEdit = mysqli_query($con,$queryCourseEdit);
            if(mysqli_num_rows($CourseEdit) == 1){
                while ($row = mysqli_fetch_assoc($CourseEdit)) {
                    $_SESSION["IDCourseEdit"] = $row['ID'];
                    $_SESSION["IDTermCourseEdit"] = $row['IDTerm'];
                    $_SESSION["NumberCourseEdit"] = $row['Number'];
                    $_SESSION["NameCourseEdit"] = $row['Name'];
                    $_SESSION["GroupCourseEdit"] = $row['GroupCourse'];
                    $_SESSION["TypeCourseEdit"] = $row['Type'];
                    $_SESSION["RoomCourseEdit"] = $row['Room'];
                    $_SESSION["TimelateCourseEdit"] = $row['TimeLate'];
                    $_SESSION["TimeStartCourseEdit"] = $row['TimeStart'];
                    $_SESSION["TimeEndCourseEdit"] = $row['TimeEnd'];
                    $_SESSION["DayCourseEdit"] = $row['Day'];
                    echo $row['Name'];
                }
            }
            $_SESSION['CheckOpenModalEdit'] = true;
            Header("Location: course-management.php");
        }

        if(isset($_POST['deleteCourseModal'])){
            $_SESSION['IDDelete'] = $_POST['deleteCourseModal'];
            $_SESSION['CheckOpenModalDelete'] = true;
            Header("Location: course-management.php");
        }

        if(isset($_POST['Pagination'])){ 
            if($_POST['Pagination'] == "«"){
                $_SESSION["Pagination"]-=1;
                Header("Location: course-management.php");
            }else if($_POST['Pagination'] == "»"){
                $_SESSION["Pagination"]+=1;
                Header("Location: course-management.php");
            }else{
                $_SESSION["Pagination"] = intval($_POST['Pagination']);
                Header("Location: course-management.php");
            }
        }









        if(isset($_POST['addCourse'])){
            if ((empty($_POST["NumCourse"]) or empty($_POST["NameCourse"]) or empty($_POST["GroupCourse"]) 
            or empty($_POST["TimeLateCourse"]))) {
                echo "<script>";
                    echo "alert(\" โปรดใส่ข้อมูลทั่วไปให้ครบ\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else{
                $timelate = trim(htmlspecialchars($_POST['TimeLateCourse']));
                $timelate = filter_var($timelate, FILTER_VALIDATE_INT);
                if ($timelate === false) {
                    echo "<script>";
                        echo "alert(\" โปรดใส่ข้อมูลเวลาที่มาสายเป็นจำนวนเต็ม\");"; 
                        echo "window.history.back()";
                    echo "</script>";
                }else{

                    if(! empty($_POST["CheckBoxType"])){
                        for($i=0;$i<count($_POST["CheckBoxType"]);$i++){
                            if(trim($_POST["CheckBoxType"][$i]) != ""){

                                $typeCourse = $_POST['CheckBoxType'][$i];
                                include("condb.php");
        
                                $numberCourse = $_POST['NumCourse'];
                                $nameCourse = $_POST['NameCourse'];
                                $groupCourse = $_POST['GroupCourse'];
                                $timeLateCourse = $_POST['TimeLateCourse'];
        
                                if($typeCourse=="Lecture"){


    
                                    if(! empty($_POST["CheckBoxMergeLac"])){


                                        if(empty($_POST["GroupCourseMergeLec"])) {
                                            echo "<script>";
                                                echo "alert(\" โปรดใส่ข้อมูลกลุ่มที่จะรวมของ Lecture\");"; 
                                                echo "window.history.back()";
                                            echo "</script>";
                                        }else{
                                            

                                            $searchSQL="SELECT * FROM inacs_course 
                                            WHERE IDTerm='$term' 
                                            AND Number='$numberCourse' 
                                            AND NameTeacher='".$_SESSION["Name"]."'
                                            AND Name='$nameCourse'
                                            AND GroupCourse='$groupCourse' 
                                            AND Type='$typeCourse' ";
                                            
                                            $result = mysqli_query($con,$searchSQL);

                                    
                                            
                                            if(mysqli_num_rows($result) == 0){

                                                $groupCourseMerge = $_POST['GroupCourseMergeLec'];

                                                $searchCourseMergeSQL="SELECT * FROM inacs_course 
                                                WHERE IDTerm='$term' 
                                                AND Number='$numberCourse' 
                                                AND NameTeacher='".$_SESSION["Name"]."'
                                                AND Name='$nameCourse'
                                                AND GroupCourse='$groupCourseMerge' 
                                                AND Type='$typeCourse' ";

                                                $resultCourseMerge = mysqli_query($con,$searchCourseMergeSQL);
                                                if(mysqli_num_rows($resultCourseMerge) == 1){
                                                    while ($row = mysqli_fetch_assoc($resultCourseMerge)) {
                                                        $courseID = $row['ID'];
                                                        $GroupCourseArray = explode("+", $row['GroupCourse']);
                                                        $GroupCourseNew = "";

                                                        array_push($GroupCourseArray,$groupCourse);
                                                        sort($GroupCourseArray);

                                                        for($x = 0;$x < count($GroupCourseArray);$x+=1){
                                                            if($x != count($GroupCourseArray)-1){
                                                                $GroupCourseNew = $GroupCourseNew."$GroupCourseArray[$x]+";
                                                            }else{
                                                                $GroupCourseNew = $GroupCourseNew."$GroupCourseArray[$x]";
                                                            }
                                                        }

                                                        $strSQL = "UPDATE inacs_course SET GroupCourse='$GroupCourseNew' 
                                                        WHERE ID='$courseID' ";
                                                        $objQuery = mysqli_query($con,$strSQL);
                                                        if($objQuery){
                                                            echo "<script>";
                                                                echo "alert(\" Merge Course Complete\");"; 
                                                                echo "window.history.back()";
                                                            echo "</script>";
                                                        }else{
                                                            echo "<script>";
                                                                echo "alert(\" Merge Course Error\");"; 
                                                                echo "window.history.back()";
                                                            echo "</script>";
                                                        }
                                                    }

                                                }else{
                                                    echo "<script>";
                                                    echo "alert(\" ข้อมูลรายวิชาที่จะรวมไม่มีในระบบ\");";
                                                    echo "window.history.back()";
                                                    echo "</script>";
                                                }

                                            }else{
                                                echo "<script>";
                                                echo "alert(\" ข้อมูลรายวิชาที่ใส่ซ้ำกับในระบบ\");"; 
                                                echo "window.history.back()";
                                                echo "</script>";
                                            }


                                        }


                                    }else{
                                        $checkDataTimeLec = array();
                                        array_push($checkDataTimeLec,$_POST["TimeCourseLec-1"]);
                                        array_push($checkDataTimeLec,$_POST["TimeCourseLec-2"]);
                                        sort($checkDataTimeLec);
    
                                        $time_days = array('08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00');
    
                                        $DurationTimeCourseLec1 = false;
                                        $DurationTimeCourseLec2 = false;
                                        for($x = 0; $x < count($time_days);$x+=1){
                                            if($time_days[$x] == $_POST["TimeCourseLec-1"]){
                                                $DurationTimeCourseLec1 = true;
                                            }else if($time_days[$x] == $_POST["TimeCourseLec-2"]){
                                                $DurationTimeCourseLec2 = true;
                                            }
                                        }
    
                                        $searchDaySQL="SELECT * FROM inacs_course WHERE IDTerm='$term' AND NameTeacher='".$_SESSION["Name"]."' AND Day='".$_POST['DayCourseLec']."' ";
                                        $resultDay = mysqli_query($con,$searchDaySQL);
                                        while ($row = mysqli_fetch_assoc($resultDay)) {
                                                for($x = 0; $x < count($time_days)-1;){
                                                    if($time_days[$x]==$row['TimeStart']){
                                                        $duration = 0;
                                                        for($z = 1; $time_days[$x+$z] != $row['TimeEnd']; $z+=1){
                                                            $time_days[$x+$z]="full";
                                                            $duration+=1;
                                                        }
                                                        $x+=$duration;
                                                    }else{
                                                        $x+=1;
                                                    }
                                                }
                                        }
    
                                        $TimeCourseLec1 = false;
                                        $TimeCourseLec2 = false;
                                        for($x = 0; $x < count($time_days);$x+=1){
                                            if($time_days[$x]==$_POST["TimeCourseLec-1"]){
                                                $TimeCourseLec1 = true;
                                            }else if($TimeCourseLec1){
                                                if($time_days[$x]==$_POST["TimeCourseLec-2"]){
                                                    $TimeCourseLec2 = true;
                                                }else if($time_days[$x] != "full"){
                                                    continue;
                                                }else{
                                                    break;
                                                }
                                            }
                                        }
    
    
    
                                        if (empty($_POST["RoomCourseLec"]) or empty($_POST["TimeCourseLec-1"]) or empty($_POST["TimeCourseLec-2"])) {
                                            echo "<script>";
                                                echo "alert(\" โปรดใส่ข้อมูลประเภท Lecture ให้ครบ\");"; 
                                                echo "window.history.back()";
                                            echo "</script>";
                                        }else if($checkDataTimeLec[0] != $_POST["TimeCourseLec-1"] && $checkDataTimeLec[1] != $_POST["TimeCourseLec-2"]){
                                            echo "<script>";
                                                echo "alert(\" เวลาเริ่มเรียน Lecture มากกว่าเวลาเลิกเรียน\");"; 
                                                echo "window.history.back()";
                                            echo "</script>";
                                        }else if($_POST["TimeCourseLec-1"] ==  $_POST["TimeCourseLec-2"]){
                                            echo "<script>";
                                                echo "alert(\" เวลาเริ่มเรียน Lecture เท่ากับเวลาเลิกเรียน\");"; 
                                                echo "window.history.back()";
                                            echo "</script>";
                                        }else if($DurationTimeCourseLec1 == false || $DurationTimeCourseLec2 == false){
                                            echo "<script>";
                                                echo "alert(\" เวลาเรียน Lecture มีนาที หรือ ไม่ได้อยู่ในช่วง 08:00-21:00 \");"; 
                                                echo "window.history.back()";
                                            echo "</script>";
                                        }else if($TimeCourseLec1 == false || $TimeCourseLec2 == false){
                                            echo "<script>";
                                                echo "alert(\" เวลาเรียน Lecture ทับกับเวลาเรียนของรายวิชาอื่นในระบบ\");"; 
                                                echo "window.history.back()";
                                            echo "</script>";
                                        }else{
                                            $roomCourse = $_POST['RoomCourseLec'];
                                            $TimeCourse1 = $_POST['TimeCourseLec-1'];
                                            $TimeCourse2 = $_POST['TimeCourseLec-2'];
                                            $dayCourse = $_POST['DayCourseLec'];
        
                                            $searchSQL="SELECT * FROM inacs_course 
                                            WHERE IDTerm='$term' 
                                            AND Number='".$numberCourse."' 
                                            AND NameTeacher='".$_SESSION["Name"]."'
                                            AND Name='".$nameCourse."' 
                                            AND GroupCourse='$groupCourse' 
                                            AND Type='".$typeCourse."' 
                                            ";
                                            $result = mysqli_query($con,$searchSQL);



                                            if(mysqli_num_rows($result) == 0){
                        
                                                $strSQL = "INSERT INTO inacs_course ";
                                                $strSQL .="(ID,NameTeacher,IDTerm,Number,Name,GroupCourse,Type,Room,TimeLate, TimeStart,TimeEnd,Day) ";
                                                $strSQL .="VALUES ";
                                                $strSQL .="(NULL,'".$_SESSION["Name"]."','$term','$numberCourse','".$nameCourse."','$groupCourse','".$typeCourse."','".$roomCourse."','$timeLateCourse','".$TimeCourse1."','".$TimeCourse2."','".$dayCourse."'
                                                        ) ";
                                                $objQuery = mysqli_query($con,$strSQL);
    
                                                if($objQuery){
    
                                                    $searchCourseSQL="SELECT * FROM inacs_course 
                                                    WHERE NameTeacher='".$_SESSION["Name"]."' 
                                                    AND IDTerm='$term' 
                                                    AND Number='$numberCourse' 
                                                    AND Name='$nameCourse' 
                                                    AND GroupCourse='$groupCourse' 
                                                    AND Type='$typeCourse'  ";
                                                    $resultCourse = mysqli_query($con,$searchCourseSQL);
                        
                                                    if(mysqli_num_rows($resultCourse)==1){
                        
                                                        while($row = mysqli_fetch_assoc($resultCourse)){
                                                            $_SESSION["IDCourseToCreateCheck"] = $row['ID'];
                                                        }
                        
                                                        $strSQL = "INSERT INTO inacs_check ";
                                                        $strSQL .="(ID,IDCourse,NumberCheck,LastStartCheckTime) ";
                                                        $strSQL .="VALUES ";
                                                        $strSQL .="(NULL,'".$_SESSION["IDCourseToCreateCheck"]."','1','' ) ";                 
                                                        $objQuery = mysqli_query($con,$strSQL);
                        
                                                        if($objQuery){
                                                            echo "<script>";
                                                                echo "alert(\" Add Course Complete\");"; 
                                                                echo "window.history.back()";
                                                            echo "</script>";
                                                        }
                                                    }
    
                                                }else{
                                                    echo "<script>";
                                                        echo "alert(\" Add Course Error\");"; 
                                                        echo "window.history.back()";
                                                    echo "</script>";
                                                }
                                                    
                                            }else{
                                                echo "<script>";
                                                    echo "alert(\" ข้อมูลรายวิชาที่ใส่ซ้ำกับในระบบ\");";
                                                    echo "window.history.back()";
                                                echo "</script>";
                                            }

                                        }
                                    }


                                    
                                }else{

                                    if(! empty($_POST["CheckBoxMergeLab"])){

                                        if(empty($_POST["GroupCourseMergeLab"])) {
                                            echo "<script>";
                                                echo "alert(\" โปรดใส่ข้อมูลกลุ่มที่จะรวมของ Lab\");"; 
                                                echo "window.history.back()";
                                            echo "</script>";
                                        }else{
                                            

                                            $searchSQL="SELECT * FROM inacs_course 
                                            WHERE IDTerm='$term' 
                                            AND Number='$numberCourse' 
                                            AND NameTeacher='".$_SESSION["Name"]."'
                                            AND Name='$nameCourse'
                                            AND GroupCourse='$groupCourse' 
                                            AND Type='$typeCourse' ";
                                            
                                            $result = mysqli_query($con,$searchSQL);


                                            if(mysqli_num_rows($result) == 0){

                                                $groupCourseMerge = $_POST['GroupCourseMergeLab'];

                                                $searchCourseMergeSQL="SELECT * FROM inacs_course 
                                                WHERE IDTerm='$term' 
                                                AND Number='$numberCourse' 
                                                AND NameTeacher='".$_SESSION["Name"]."'
                                                AND Name='$nameCourse'
                                                AND GroupCourse='$groupCourseMerge' 
                                                AND Type='$typeCourse' ";

                                                $resultCourseMerge = mysqli_query($con,$searchCourseMergeSQL);
                                                if(mysqli_num_rows($resultCourseMerge) == 1){
                                                    while ($row = mysqli_fetch_assoc($resultCourseMerge)) {
                                                        $courseID = $row['ID'];
                                                        $GroupCourseArray = explode("+", $row['GroupCourse']);
                                                        $GroupCourseNew = "";

                                                        array_push($GroupCourseArray,$groupCourse);
                                                        sort($GroupCourseArray);

                                                        for($x = 0;$x < count($GroupCourseArray);$x+=1){
                                                            if($x != count($GroupCourseArray)-1){
                                                                $GroupCourseNew = $GroupCourseNew."$GroupCourseArray[$x]+";
                                                            }else{
                                                                $GroupCourseNew = $GroupCourseNew."$GroupCourseArray[$x]";
                                                            }
                                                        }

                                                        $strSQL = "UPDATE inacs_course SET GroupCourse='$GroupCourseNew' 
                                                        WHERE ID='$courseID' ";
                                                        $objQuery = mysqli_query($con,$strSQL);
                                                        if($objQuery){
                                                            echo "<script>";
                                                                echo "alert(\" Merge Course Complete\");"; 
                                                                echo "window.history.back()";
                                                            echo "</script>";
                                                        }else{
                                                            echo "<script>";
                                                                echo "alert(\" Merge Course Error\");"; 
                                                                echo "window.history.back()";
                                                            echo "</script>";
                                                        }
                                                    }

                                                }else{
                                                    echo "<script>";
                                                    echo "alert(\" ข้อมูลรายวิชาที่จะรวมไม่มีในระบบ\");";
                                                    echo "window.history.back()";
                                                    echo "</script>";
                                                }

                                            }else{
                                                echo "<script>";
                                                echo "alert(\" ข้อมูลรายวิชาที่ใส่ซ้ำกับในระบบ\");"; 
                                                echo "window.history.back()";
                                                echo "</script>";
                                            }


                                        }

                                    }else{
                                        $checkDataTimeLab = array();
                                        array_push($checkDataTimeLab,$_POST["TimeCourseLab-1"]);
                                        array_push($checkDataTimeLab,$_POST["TimeCourseLab-2"]);
                                        sort($checkDataTimeLab);

                                        $time_days = array('08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00');

                                        $DurationTimeCourseLab1 = false;
                                        $DurationTimeCourseLab2 = false;
                                        for($x = 0; $x < count($time_days);$x+=1){
                                            if($time_days[$x] == $_POST["TimeCourseLab-1"]){
                                                $DurationTimeCourseLab1 = true;
                                            }else if($time_days[$x] == $_POST["TimeCourseLab-2"]){
                                                $DurationTimeCourseLab2 = true;
                                            }
                                        }

                                        $searchDaySQL="SELECT * FROM inacs_course WHERE IDTerm='$term' AND NameTeacher='".$_SESSION["Name"]."' AND Day='".$_POST['DayCourseLab']."' ";
                                        $resultDay = mysqli_query($con,$searchDaySQL);
                                        while ($row = mysqli_fetch_assoc($resultDay)) {
                                                for($x = 0; $x < count($time_days)-1;){
                                                    if($time_days[$x]==$row['TimeStart']){
                                                        $duration = 0;
                                                        for($z = 1; $time_days[$x+$z] != $row['TimeEnd']; $z+=1){
                                                            $time_days[$x+$z]="full";
                                                            $duration+=1;
                                                        }
                                                        $x+=$duration;
                                                    }else{
                                                        $x+=1;
                                                    }
                                                }
                                        }

                                        $TimeCourseLab1 = false;
                                        $TimeCourseLab2 = false;
                                        for($x = 0; $x < count($time_days);$x+=1){
                                            if($time_days[$x]==$_POST["TimeCourseLab-1"]){
                                                $TimeCourseLab1 = true;
                                            }else if($TimeCourseLab1){
                                                if($time_days[$x]==$_POST["TimeCourseLab-2"]){
                                                    $TimeCourseLab2 = true;
                                                }else if($time_days[$x] != "full"){
                                                    continue;
                                                }else{
                                                    break;
                                                }
                                            }
                                        }

                                        if (empty($_POST["RoomCourseLab"]) or empty($_POST["TimeCourseLab-1"]) or empty($_POST["TimeCourseLab-2"])) {
                                            echo "<script>";
                                                echo "alert(\" โปรดใส่ข้อมูลประเภท Lab ให้ครบ\");"; 
                                                echo "window.history.back()";
                                            echo "</script>";
                                        }else if($_POST["TimeCourseLab-1"] ==  $_POST["TimeCourseLab-2"]){
                                            echo "<script>";
                                                echo "alert(\" เวลาเริ่มเรียน Lab เท่ากับเวลาเลิกเรียน\");"; 
                                                echo "window.history.back()";
                                            echo "</script>";
                                        }else if($checkDataTimeLab[0] != $_POST["TimeCourseLab-1"] && $checkDataTimeLab[1] != $_POST["TimeCourseLab-2"]){
                                            echo "<script>";
                                                echo "alert(\" เวลาเริ่มเรียน Lab มากกว่าเวลาเลิกเรียน\");"; 
                                                echo "window.history.back()";
                                            echo "</script>";
                                        }else if($DurationTimeCourseLab1 == false || $DurationTimeCourseLab2 == false){
                                            echo "<script>";
                                                echo "alert(\" เวลาเรียน Lab มีนาที หรือ ไม่ได้อยู่ในช่วง 08:00-21:00\");"; 
                                                echo "window.history.back()";
                                            echo "</script>";
                                        }else if($TimeCourseLab1 == false || $TimeCourseLab2 == false){
                                            echo "<script>";
                                                echo "alert(\" เวลาเรียน Lab ทับกับเวลาเรียนของรายวิชาอื่นในระบบ\");"; 
                                                echo "window.history.back()";
                                            echo "</script>";
                                        }else{
                                            $roomCourse = $_POST['RoomCourseLab'];
                                            $TimeCourse1 = $_POST['TimeCourseLab-1'];
                                            $TimeCourse2 = $_POST['TimeCourseLab-2'];
                                            $dayCourse = $_POST['DayCourseLab'];
                                            $searchSQL="SELECT * FROM inacs_course 
        
                                            WHERE IDTerm='$term' 
                                            AND Number='".$numberCourse."' 
                                            AND NameTeacher='".$_SESSION["Name"]."'
                                            AND Name='".$nameCourse."' 
                                            AND GroupCourse='$groupCourse' 
                                            AND Type='".$typeCourse."' 
                                            ";
                                        $result = mysqli_query($con,$searchSQL);


                                            
                                        if(mysqli_num_rows($result) == 0){
                
                                            $strSQL = "INSERT INTO inacs_course ";
                                            $strSQL .="(ID,NameTeacher,IDTerm,Number,Name,GroupCourse,Type,Room,TimeLate, TimeStart,TimeEnd,Day) ";
                                            $strSQL .="VALUES ";
                                            $strSQL .="(NULL,'".$_SESSION["Name"]."','$term','$numberCourse','".$nameCourse."','$groupCourse','".$typeCourse."','".$roomCourse."','$timeLateCourse','".$TimeCourse1."','".$TimeCourse2."','".$dayCourse."'
                                                ) ";
                                            $objQuery = mysqli_query($con,$strSQL);

                                                if($objQuery){

                                                    $searchCourseSQL="SELECT * FROM inacs_course 
                                                    WHERE NameTeacher='".$_SESSION["Name"]."' 
                                                    AND IDTerm='$term' 
                                                    AND Number='$numberCourse' 
                                                    AND Name='$nameCourse' 
                                                    AND GroupCourse='$groupCourse' 
                                                    AND Type='$typeCourse'  ";
                                                    $resultCourse = mysqli_query($con,$searchCourseSQL);
                        
                                                    if(mysqli_num_rows($resultCourse)==1){
                        
                                                        while($row = mysqli_fetch_assoc($resultCourse)){
                                                            $_SESSION["IDCourseToCreateCheck"] = $row['ID'];
                                                        }
                        
                                                        $strSQL = "INSERT INTO inacs_check ";
                                                        $strSQL .="(ID,IDCourse,NumberCheck,LastStartCheckTime) ";
                                                        $strSQL .="VALUES ";
                                                        $strSQL .="(NULL,'".$_SESSION["IDCourseToCreateCheck"]."','1','' ) ";                 
                                                        $objQuery = mysqli_query($con,$strSQL);
                        
                                                        if($objQuery){
                                                            echo "<script>";
                                                                echo "alert(\" Add Course Complete\");"; 
                                                                echo "window.history.back()";
                                                            echo "</script>";
                                                        }
                                                    }

                                                }else{
                                                    echo "<script>";
                                                        echo "alert(\" Add Course Error\");"; 
                                                        echo "window.history.back()";
                                                    echo "</script>";
                                                }
                                            
                                            }else{
                                                echo "<script>";
                                                    echo "alert(\" ข้อมูลรายวิชาที่ใส่ซ้ำกับในระบบ\");"; 
                                                    echo "window.history.back()";
                                                echo "</script>";
                                            }
                                        }
                                    }

                                    
                                }
                            }
                        }
                    }else{
                        echo "<script>";
                            echo "alert(\" โปรดเลือกประเภทของรายวิชา\");"; 
                            echo "window.history.back()";
                        echo "</script>";
                    }


                }
            }
            
        }





        if(isset($_POST['editCourse'])){
            include("condb.php");

            $checkDataTime = array();
            array_push($checkDataTime,$_POST["TimeCourse-1"]);
            array_push($checkDataTime,$_POST["TimeCourse-2"]);
            sort($checkDataTime);


            $time_days = array('08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00');

            $DurationTimeCourse1 = false;
            $DurationTimeCourse2 = false;
            for($x = 0; $x < count($time_days);$x+=1){
                if($time_days[$x] == $_POST["TimeCourse-1"]){
                    $DurationTimeCourse1 = true;
                }else if($time_days[$x] == $_POST["TimeCourse-2"]){
                    $DurationTimeCourse2 = true;
                }
            }

            $searchDaySQL="SELECT * FROM inacs_course WHERE IDTerm='$term' AND NameTeacher='".$_SESSION["Name"]."' AND Day='".$_POST["DayCourse"]."' ";
            $resultDay = mysqli_query($con,$searchDaySQL);    
            
            $searchDayCheckSQL="SELECT * FROM inacs_course 
            WHERE IDTerm='$term' 
            AND Number='".$_POST["NumCourse"]."' 
            AND NameTeacher='".$_SESSION["Name"]."'
            AND Name='".$_POST["NameCourse"]."'
            AND GroupCourse='".$_POST["GroupCourse"]."'
            AND Type='".$_POST["TypeCourse"]."'
            ";
            $resultDayCheck = mysqli_query($con,$searchDayCheckSQL);  
            $dataDayCheck = mysqli_fetch_assoc($resultDayCheck);

            while ($row = mysqli_fetch_assoc($resultDay)) {
                for($x = 0; $x < count($time_days)-1;){
                    if($time_days[$x]==$row['TimeStart'] && $row['ID'] != $_SESSION['IDEdit'] ){
                        $duration = 0;
                        for($z = 1; $time_days[$x+$z] != $row['TimeEnd']; $z+=1){
                            $time_days[$x+$z]="full";
                            $duration+=1;
                        }
                        $x+=$duration;
                    }else{
                        $x+=1;
                    }
                }
            }

            $TimeCourse1 = false;
            $TimeCourse2 = false;
            for($x = 0; $x < count($time_days);$x+=1){
                if($time_days[$x]==$_POST["TimeCourse-1"]){
                    $TimeCourse1 = true;
                }else if($TimeCourse1){
                    if($time_days[$x]==$_POST["TimeCourse-2"]){
                        $TimeCourse2 = true;
                    }else if($time_days[$x] != "full"){
                        continue;
                    }else{
                        break;
                    }
                }
            }

            if ((empty($_POST["NumCourse"]) or empty($_POST["NameCourse"]) or empty($_POST["GroupCourse"]) 
            or empty($_POST["TimeLateCourse"]) or empty($_POST["RoomCourse"]) or empty($_POST["TimeCourse-1"])
            or empty($_POST["TimeCourse-2"]))) {
                echo "<script>";
                    echo "alert(\" โปรดใส่ข้อมูลรายวิชาให้ครบ\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else if($_POST["TimeCourse-1"] ==  $_POST["TimeCourse-2"]){
                echo "<script>";
                    echo "alert(\" เวลาเริ่มเรียนเท่ากับเวลาเลิกเรียน\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else if($checkDataTime[0] != $_POST["TimeCourse-1"] && $checkDataTime[1] != $_POST["TimeCourse-2"]){
                echo "<script>";
                    echo "alert(\" เวลาเริ่มเรียนมากกว่าเวลาเลิกเรียน\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else if($DurationTimeCourse1 == false || $DurationTimeCourse2 == false){
                echo "<script>";
                    echo "alert(\" เวลาเรียน มีนาที หรือ ไม่ได้อยู่ในช่วง 08:00-21:00\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else if($TimeCourse1 == false || $TimeCourse2 == false){
                echo "<script>";
                    echo "alert(\" เวลาเรียนทับกับเวลาเรียนของรายวิชาอื่นในระบบ\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else{
                $timelate = trim(htmlspecialchars($_POST['TimeLateCourse']));
                $timelate = filter_var($timelate, FILTER_VALIDATE_INT);
                if ($timelate === false) {
                    echo "<script>";
                    echo "alert(\" โปรดใส่ข้อมูลเวลาที่มาสายเป็นจำนวนเต็ม\");"; 
                    echo "window.history.back()";
                    echo "</script>";
                }else{
                    $searchSQL="SELECT * FROM inacs_course 
                    WHERE IDTerm='$term' 
                    AND Number='".$_POST["NumCourse"]."' 
                    AND NameTeacher='".$_SESSION["Name"]."'
                    AND Name='".$_POST["NameCourse"]."'
                    AND GroupCourse='".$_POST["GroupCourse"]."'
                    AND Type='".$_POST["TypeCourse"]."'
                    ";
                    
                    $result = mysqli_query($con,$searchSQL);
                    $DataCourseCheck = mysqli_fetch_assoc($result);



                    $searchNoGroupSQL="SELECT * FROM inacs_course 
                    WHERE IDTerm='$term' 
                    AND Number='".$_POST["NumCourse"]."' 
                    AND NameTeacher='".$_SESSION["Name"]."'
                    AND Name='".$_POST["NameCourse"]."'
                    AND GroupCourse='".$_POST["GroupCourse"]."' 
                    AND Type='".$_POST["TypeCourse"]."'
                    ";
                    
                    $resultNoGroup = mysqli_query($con,$searchNoGroupSQL);


                    
                    if((mysqli_num_rows($result) == 0) || (mysqli_num_rows($result) == 1 && $DataCourseCheck['ID'] == $_SESSION['IDEdit'])){

                        $strSQL = "UPDATE inacs_course SET Number='".$_POST["NumCourse"]."' 
                        , Name='".$_POST["NameCourse"]."'
                        , GroupCourse='".$_POST["GroupCourse"]."' 
                        , Type='".$_POST["TypeCourse"]."'
                        , Room='".$_POST["RoomCourse"]."' 
                        , TimeLate='".$_POST["TimeLateCourse"]."' 
                        , TimeStart='".$_POST["TimeCourse-1"]."'
                        , TimeEnd='".$_POST["TimeCourse-2"]."'
                        , Day='".$_POST["DayCourse"]."'
                        WHERE ID='".$_SESSION['IDEdit']."'";
                        $objQuery = mysqli_query($con,$strSQL);

                        if($objQuery){
                            echo "<script>";
                                echo "alert(\" Update Course Complete\");"; 
                                echo "window.history.back()";
                            echo "</script>";
                            
                        }else{
                            echo "<script>";
                                echo "alert(\" Update Course Error\");"; 
                                echo "window.history.back()";
                            echo "</script>";
                        }
                    }else{
                        echo "<script>";
                        echo "alert(\" ข้อมูลรายวิชาที่ใส่ซ้ำกับในระบบ\");"; 
                        echo "window.history.back()";
                        echo "</script>";
                    }
                }
            }
        }




        if(isset($_POST['deleteCourse'])){
            include("condb.php");
            $searchSQL="SELECT * FROM inacs_course WHERE ID='".$_SESSION['IDDelete']."' ";
            $result = mysqli_query($con,$searchSQL);

            if(mysqli_num_rows($result) == 1){

                $searchStrSQL="SELECT * FROM inacs_student WHERE IDCourse='".$_SESSION['IDDelete']."' ";
                $resultStrSQL = mysqli_query($con,$searchStrSQL);
                while($rowStudent = mysqli_fetch_array($resultStrSQL)){

                    $searchResultSQL="SELECT * FROM inacs_result WHERE IDStudent='$rowStudent[0]' ";
                    $resultResultSQL = mysqli_query($con,$searchResultSQL);
                    while($rowResult = mysqli_fetch_array($resultResultSQL)){
                        mysqli_query($con,"DELETE FROM inacs_result WHERE ID=$rowResult[0] ");
                    }

                    mysqli_query($con,"DELETE FROM inacs_student WHERE ID=$rowStudent[0] ");
                }

                $searchVacationSQL="SELECT * FROM inacs_vacation WHERE IDCourse='".$_SESSION['IDDelete']."' ";
                $resultVacationSQL = mysqli_query($con,$searchVacationSQL);
                while($rowVacation = mysqli_fetch_array($resultVacationSQL)){
                    mysqli_query($con,"DELETE FROM inacs_vacation WHERE ID=$rowVacation[0] ");
                }

                $searchCheckSQL="SELECT * FROM inacs_Check WHERE IDCourse='".$_SESSION['IDDelete']."' ";
                $resultChecktSQL = mysqli_query($con,$searchCheckSQL);
                while($rowCheck = mysqli_fetch_array($resultChecktSQL)){
                    mysqli_query($con,"DELETE FROM inacs_Check WHERE ID=$rowCheck[0] ");
                }

                $strSQL="DELETE FROM inacs_course WHERE ID='".$_SESSION['IDDelete']."' ";
                $objQuery = mysqli_query($con,$strSQL);

                $searchCountSQL="SELECT * FROM inacs_course WHERE NameTeacher='".$_SESSION["Name"]."' 
                AND IDTerm='$term'";
                $resultCount = mysqli_query($con,$searchCountSQL);

                if(fmod(mysqli_num_rows($resultCount),5) == 0 && mysqli_num_rows($resultCount) != 0){
                    $_SESSION["Pagination"]-=1;
                }

                if($objQuery){
                    echo "<script>";
                        echo "alert(\" Delete Course Complete\");"; 
                        echo "window.history.back()";
                    echo "</script>";
                    
                }else{
                    echo "<script>";
                        echo "alert(\" Delete Course Error\");"; 
                        echo "window.history.back()";
                    echo "</script>";
                }
            }else{
                echo "<script>";
                    echo "alert(\" Data Error\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }
        }






?>