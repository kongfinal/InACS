<?php 
session_start();
include('condb.php');
        $term = $_SESSION["IDTerm"];

        if(isset($_POST['terms'])){
            $_SESSION["IDTermResult"] = $_POST['terms'];
            $_SESSION["PaginationSelectResult"] = 1;
            Header("Location: select-course-results.php");
        }

        if(isset($_POST['Pagination'])){ 
            if($_POST['Pagination'] == "«"){
                $_SESSION["PaginationSelectResult"]-=1;
                Header("Location: select-course-results.php");
            }else if($_POST['Pagination'] == "»"){
                $_SESSION["PaginationSelectResult"]+=1;
                Header("Location: select-course-results.php");
            }else{
                $_SESSION["PaginationSelectResult"] = intval($_POST['Pagination']);
                Header("Location: select-course-results.php");
            }
        }

        if( isset($_GET['dataCourse']) ){
            $dataCourseArray = explode("/", $_GET['dataCourse']);

            $numberCourse = $dataCourseArray[0];

            $dataCourseGroupArray = explode(" ", $dataCourseArray[1]);

            $groupCourse = "";
            for($x = 0;$x < count($dataCourseGroupArray);$x+=1){
                $groupCourse = $groupCourse.$dataCourseGroupArray[$x];
                if($x < count($dataCourseGroupArray)-1){
                    $groupCourse = $groupCourse."+";
                }
            }

            $queryCourse = "SELECT * FROM `inacs_course` WHERE IDTerm='".$_SESSION["IDTermResult"]."' AND NameTeacher='".$_SESSION['Name']."' AND Number='$numberCourse' AND GroupCourse='$groupCourse' ";
            $CourseData = mysqli_query($con,$queryCourse);

                while ($row = mysqli_fetch_assoc($CourseData)) {
                    $_SESSION["NumCourseInResultStudent"] = $row['Number'];
                    $_SESSION["NameCourseInResultStudent"] = $row['Name'];
                    $_SESSION["GroupCourseInResultStudent"] = $row['GroupCourse'];
                }
                
            Header("Location: name-check-result.php");
            
        }

        if(isset($_POST['types'])){
            $_SESSION["TypeResult"] = $_POST['types'];
            Header("Location: name-check-result.php");
        }

        if(isset($_POST['addPhoneModal'])){
            $_SESSION['CheckOpenModalAddPhone'] = true;

            $queryCourse = "SELECT * FROM `inacs_course` WHERE IDTerm='".$_SESSION["IDTermResult"]."' AND NameTeacher='".$_SESSION['Name']."' AND Number='".$_SESSION["NumCourseInResultStudent"]."' AND GroupCourse='".$_SESSION["GroupCourseInResultStudent"]."' ";
            $CourseData = mysqli_query($con,$queryCourse);

            $dataCourseID = array();
            $dataPhoneNumber = array();
            $_SESSION["IDStudentOfPhone"] = array();
            while ($row = mysqli_fetch_assoc($CourseData)) {
                array_push($dataCourseID,$row['ID']);
            }

            for($x = 0;$x < count($dataCourseID);$x+=1){
                $IDCourse = $dataCourseID[$x];
                $numberStudent = $_POST['addPhoneModal'];
                $queryStudent = "SELECT * FROM `inacs_student` WHERE IDCourse='$IDCourse' AND Number='$numberStudent' ";
                $StudentData = mysqli_query($con,$queryStudent);
                while ($row = mysqli_fetch_assoc($StudentData)) {
                    array_push($dataPhoneNumber,$row['ParentalPhoneNumber']);
                    array_push($_SESSION["IDStudentOfPhone"],$row['ID']);
                }
            }

            if(count(array_unique($dataPhoneNumber))==1){
                $_SESSION['ParentalPhoneNumber'] = $dataPhoneNumber[0];
            }

            Header("Location: name-check-result.php");
        }

        if(isset($_POST['addParentalPhoneNumber'])){
            $ParentalPhoneNumber = $_POST['Phone'];
            if(strlen($ParentalPhoneNumber) != 10){
                echo "<script>";
                    echo "alert(\" โปรดใส่เบอร์โทรศัพท์สิบตัว\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else if (!filter_var(substr($ParentalPhoneNumber,1,10), FILTER_VALIDATE_INT)) { //substr ตัดเอาตัวแรกออกคิดแค่9ตัวหลัง
                echo "<script>";
                    echo "alert(\" ข้อมูลเบอร์โทรศัพท์ไม่ได้มีแต่ตัวเลข หรือ ตัวเลขต่ำแหน่งที่ 2 เป็น 0\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else if(substr($ParentalPhoneNumber,0,1) != "0"){
                echo "<script>";
                    echo "alert(\" ข้อมูลเบอร์โทรศัพท์ตัวแรกไม่ได้เป็น 0\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else{

                for($x = 0;$x < count($_SESSION["IDStudentOfPhone"]);$x+=1){
                    $strSQL = "UPDATE inacs_student SET ParentalPhoneNumber='$ParentalPhoneNumber' 
                    WHERE ID='".$_SESSION['IDStudentOfPhone'][$x]."'";
                    $objQuery = mysqli_query($con,$strSQL);
                }
                if($objQuery){
                    echo "<script>";
                        echo "alert(\" Update Parental Phone Number Complete\");"; 
                        echo "window.history.back()";
                    echo "</script>";
                    
                }else{
                    echo "<script>";
                        echo "alert(\" Update Parental Phone Number Error\");"; 
                    echo "</script>";
                }

            }
        }


        

        if(isset($_POST['export'])){

            $delimiter = ",";
            $numberCourseFilename = $_SESSION['NumCourseInResultStudent'];
            $nameCourseFilename = $_SESSION['NameCourseInResultStudent'];
            $GroupCourseFilename = $_SESSION['GroupCourseInResultStudent'];
            $TypeCourseFilename = $_SESSION['TypeResult'];

            $filename = $numberCourseFilename . "_" . $GroupCourseFilename . "_" . $TypeCourseFilename . ".csv";
            
            $f = fopen('php://output', 'w');

            fputs($f, $bom = ( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

            $dataResultStudent = $_SESSION["ResultStudentData"];

            $dateCreateCSV = date("j F Y").", ".date("H:i:s")." น.";
            $data = array('วัน-เวลาที่โหลดรายงาน',$dateCreateCSV,' ',' ',' ','หมายเหตุ','0 คือ ขาดเรียน');
            fputcsv($f, $data, $delimiter);

            $queryTerm = "SELECT * FROM `inacs_term` WHERE ID='".$_SESSION['IDTermResult']."' ";
            $termDate = mysqli_query($con,$queryTerm);
            if(mysqli_num_rows($termDate) == 1){
                while ($rowTermCSV = mysqli_fetch_assoc($termDate)) {

                    //$term = $rowTermCSV['Term']."/".$rowTermCSV['Year'];

                    $data = array('ปีการศึกษา',$rowTermCSV['Year'],'เทอม',$rowTermCSV['Term'],' ',' ','0.5 คือ มาสาย');
                    fputcsv($f, $data, $delimiter);
                }
            }

            $data = array('รหัสวิชา',$numberCourseFilename,' ',' ',' ',' ','1 คือ ทันเวลา');
            fputcsv($f, $data, $delimiter);

            $data = array('รายวิชา',$nameCourseFilename);
            fputcsv($f, $data, $delimiter);

            $data = array('กลุ่มเรียน',$GroupCourseFilename);
            fputcsv($f, $data, $delimiter);

            $data = array('ประเภท',$TypeCourseFilename);
            fputcsv($f, $data, $delimiter);

            $data = array('');
            fputcsv($f, $data, $delimiter);

            if($_SESSION["TypeResult"] == "All"){

                //Header 
                $fields = array('รหัสนิสิต', 'ชื่อนิสิต', 'สาขา');
                $queryCourseCSV = "SELECT * FROM `inacs_course` WHERE IDTerm='".$_SESSION["IDTermResult"]."' 
                AND NameTeacher='".$_SESSION['Name']."' 
                AND Number='$numberCourseFilename' 
                AND GroupCourse='$GroupCourseFilename'  ";
                $CourseCSVData = mysqli_query($con,$queryCourseCSV);
                if(mysqli_num_rows($CourseCSVData) > 0){
                    while ($rowCourseCSV = mysqli_fetch_assoc($CourseCSVData)) {

                        $IDCourse = $rowCourseCSV['ID'];
                        $queryCheckCSV = "SELECT * FROM `inacs_check` WHERE IDCourse='$IDCourse'  ";
                        $CheckCSVData = mysqli_query($con,$queryCheckCSV);
                        if(mysqli_num_rows($CheckCSVData) == 1){
                            while ($rowCheckCSV = mysqli_fetch_assoc($CheckCSVData)) {

                                $IDCheck = $rowCheckCSV['ID'];
                                $queryDetailCheckCSV = "SELECT * FROM `inacs_detail_check` WHERE IDCheck='$IDCheck'  ";
                                $DetailCheckCSVData = mysqli_query($con,$queryDetailCheckCSV);
                                if(mysqli_num_rows($DetailCheckCSVData) > 0){
                                    while ($rowDetailCheckCSV = mysqli_fetch_assoc($DetailCheckCSVData)) {

                                        $dataField = $rowDetailCheckCSV['DateCheck'].", ".$rowDetailCheckCSV['TimeCheck']." เช็คชื่อ กลุ่ม ".$GroupCourseFilename." ".$rowCourseCSV['Type']." ครั้งที่ ".$rowDetailCheckCSV['NumberCheck'];

                                        //echo $dataField . "<br>";

                                        array_push($fields,$dataField);
                                    }
                                }

                            }
                        }
                    }
                    fputcsv($f, $fields, $delimiter);
                }



                //Detail Student
                $DataScoreLec = array();
                $DataScoreLab = array();

                $queryCourseCSV = "SELECT * FROM `inacs_course` WHERE IDTerm='".$_SESSION["IDTermResult"]."' 
                AND NameTeacher='".$_SESSION['Name']."' 
                AND Number='$numberCourseFilename' 
                AND GroupCourse='$GroupCourseFilename'  ";
                $CourseCSVData = mysqli_query($con,$queryCourseCSV);
                if(mysqli_num_rows($CourseCSVData) > 0){
                    while ($rowCourseCSV = mysqli_fetch_assoc($CourseCSVData)) {

                        $IDCourse = $rowCourseCSV['ID'];
                        $queryStudentCSV = "SELECT * FROM `inacs_student` WHERE IDCourse='$IDCourse'  ";
                        $StudentCSVData = mysqli_query($con,$queryStudentCSV);
                        if(mysqli_num_rows($StudentCSVData) > 0){
                            while ($rowStudentCSV = mysqli_fetch_assoc($StudentCSVData)) {
    
                                $studentData = array($rowStudentCSV['Number'], $rowStudentCSV['Name'], $rowStudentCSV['Branch']);

                                $IDStudent = $rowStudentCSV['ID'];
                                $queryResultCSV = "SELECT * FROM `inacs_result` WHERE IDStudent='$IDStudent'  ";
                                $ResultCSVData = mysqli_query($con,$queryResultCSV);
                                if(mysqli_num_rows($ResultCSVData) == 1){
                                    while ($rowResultCSV = mysqli_fetch_assoc($ResultCSVData)) {

                                        $IDResult = $rowResultCSV['ID'];
                                        $queryDetailResultCSV = "SELECT * FROM `inacs_detail_result` WHERE IDResult='$IDResult'  ";
                                        $DetailResultCSVData = mysqli_query($con,$queryDetailResultCSV);
                                        if(mysqli_num_rows($DetailResultCSVData) > 0){
                                            while ($rowDetailResultCSV = mysqli_fetch_assoc($DetailResultCSVData)){
        
                                                array_push($studentData,$rowDetailResultCSV['ScoreResult']);

                                            }
                                        }

                                    }
                                }
                                //fputcsv($f, $studentData, $delimiter);
                                if($rowCourseCSV['Type'] == "Lecture"){
                                    array_push($DataScoreLec,$studentData);
                                }else{
                                    array_push($DataScoreLab,$studentData);
                                }

                            }
                        }

                    }
                }

                sort($DataScoreLec);
                sort($DataScoreLab);
                
                
                if(count($DataScoreLec) != 0){
                    for($x = 0;$x < count($DataScoreLec);$x+=1){
                        $lineData = array($DataScoreLec[$x][0],$DataScoreLec[$x][1],$DataScoreLec[$x][2]);
                        for($y = 3;$y < count($DataScoreLec[$x]);$y+=1){
                            array_push($lineData,$DataScoreLec[$x][$y]);
                        }
                        for($z = 0;$z < count($DataScoreLab);$z+=1){
                            if($DataScoreLec[$x][0] == $DataScoreLab[$z][0]){
                                for($y = 3;$y < count($DataScoreLab[$z]);$y+=1){
                                    array_push($lineData,$DataScoreLab[$z][$y]);
                                }
                            }
                        }
                        fputcsv($f, $lineData, $delimiter);
                    }
                }else{
                    for($x = 0;$x < count($DataScoreLab);$x+=1){
                        $lineData = array($DataScoreLab[$x][0],$DataScoreLab[$x][1],$DataScoreLab[$x][2]);
                        for($y = 3;$y < count($DataScoreLab[$x]);$y+=1){
                            array_push($lineData,$DataScoreLab[$x][$y]);
                        }
                        fputcsv($f, $lineData, $delimiter);
                    }
                }
                



            }else{

                //Header 
                $fields = array('รหัสนิสิต', 'ชื่อนิสิต', 'สาขา');
                $queryCourseCSV = "SELECT * FROM `inacs_course` WHERE IDTerm='".$_SESSION["IDTermResult"]."' 
                AND NameTeacher='".$_SESSION['Name']."' 
                AND Number='$numberCourseFilename' 
                AND GroupCourse='$GroupCourseFilename'  
                AND Type='".$_SESSION["TypeResult"]."' ";
                $CourseCSVData = mysqli_query($con,$queryCourseCSV);
                if(mysqli_num_rows($CourseCSVData) > 0){
                    while ($rowCourseCSV = mysqli_fetch_assoc($CourseCSVData)) {

                        $IDCourse = $rowCourseCSV['ID'];
                        $queryCheckCSV = "SELECT * FROM `inacs_check` WHERE IDCourse='$IDCourse'  ";
                        $CheckCSVData = mysqli_query($con,$queryCheckCSV);
                        if(mysqli_num_rows($CheckCSVData) == 1){
                            while ($rowCheckCSV = mysqli_fetch_assoc($CheckCSVData)) {

                                $IDCheck = $rowCheckCSV['ID'];
                                $queryDetailCheckCSV = "SELECT * FROM `inacs_detail_check` WHERE IDCheck='$IDCheck'  ";
                                $DetailCheckCSVData = mysqli_query($con,$queryDetailCheckCSV);
                                if(mysqli_num_rows($DetailCheckCSVData) > 0){
                                    while ($rowDetailCheckCSV = mysqli_fetch_assoc($DetailCheckCSVData)) {

                                        $dataField = $rowDetailCheckCSV['DateCheck'].", ".$rowDetailCheckCSV['TimeCheck']." เช็คชื่อ กลุ่ม ".$GroupCourseFilename." ".$rowCourseCSV['Type']." ครั้งที่ ".$rowDetailCheckCSV['NumberCheck'];

                                        //echo $dataField . "<br>";

                                        array_push($fields,$dataField);
                                    }
                                }

                            }
                        }
                    }
                    fputcsv($f, $fields, $delimiter);
                }


                //Detail Student
                $DataScore = array();

                $queryCourseCSV = "SELECT * FROM `inacs_course` WHERE IDTerm='".$_SESSION["IDTermResult"]."' 
                AND NameTeacher='".$_SESSION['Name']."' 
                AND Number='$numberCourseFilename' 
                AND GroupCourse='$GroupCourseFilename'  
                AND Type='".$_SESSION["TypeResult"]."' ";
                $CourseCSVData = mysqli_query($con,$queryCourseCSV);
                if(mysqli_num_rows($CourseCSVData) > 0){
                    while ($rowCourseCSV = mysqli_fetch_assoc($CourseCSVData)) {

                        $IDCourse = $rowCourseCSV['ID'];
                        $queryStudentCSV = "SELECT * FROM `inacs_student` WHERE IDCourse='$IDCourse'  ";
                        $StudentCSVData = mysqli_query($con,$queryStudentCSV);
                        if(mysqli_num_rows($StudentCSVData) > 0){
                            while ($rowStudentCSV = mysqli_fetch_assoc($StudentCSVData)) {

                                $studentData = array($rowStudentCSV['Number'], $rowStudentCSV['Name'], $rowStudentCSV['Branch']);

                                $IDStudent = $rowStudentCSV['ID'];
                                $queryResultCSV = "SELECT * FROM `inacs_result` WHERE IDStudent='$IDStudent'  ";
                                $ResultCSVData = mysqli_query($con,$queryResultCSV);
                                if(mysqli_num_rows($ResultCSVData) == 1){
                                    while ($rowResultCSV = mysqli_fetch_assoc($ResultCSVData)) {

                                        $IDResult = $rowResultCSV['ID'];
                                        $queryDetailResultCSV = "SELECT * FROM `inacs_detail_result` WHERE IDResult='$IDResult'  ";
                                        $DetailResultCSVData = mysqli_query($con,$queryDetailResultCSV);
                                        if(mysqli_num_rows($DetailResultCSVData) > 0){
                                            while ($rowDetailResultCSV = mysqli_fetch_assoc($DetailResultCSVData)){
        
                                                array_push($studentData,$rowDetailResultCSV['ScoreResult']);
                                                
                                            }
                                        }

                                    }
                                }
                                //fputcsv($f, $studentData, $delimiter);
                                array_push($DataScore,$studentData);
                            }
                        }

                    }
                }

                sort($DataScore);

                for($x = 0;$x < count($DataScore);$x+=1){
                    $lineData = array($DataScore[$x][0],$DataScore[$x][1],$DataScore[$x][2]);
                    for($y = 3;$y < count($DataScore[$x]);$y+=1){
                        array_push($lineData,$DataScore[$x][$y]);
                    }
                    fputcsv($f, $lineData, $delimiter);
                }

                /*$fields = array('รหัสนิสิต', 'ชื่อนิสิต', 'สาขา', 'จำนวนที่เช็ค', 'ทันเวลา', 'สาย', 'ขาด','คะแนนเข้าห้อง', 'คะแนนที่หัก', 'คะแนนพิเศษ');
                fputcsv($f, $fields, $delimiter);

                for($x = 0;$x < count($dataResultStudent);$x+=1){


                        $lineData = array($dataResultStudent[$x][0], $dataResultStudent[$x][1], $dataResultStudent[$x][2], $dataResultStudent[$x][3], $dataResultStudent[$x][4], $dataResultStudent[$x][5], $dataResultStudent[$x][6],$dataResultStudent[$x][7], $dataResultStudent[$x][8], $dataResultStudent[$x][9]);
                        fputcsv($f, $lineData, $delimiter);


                }*/
            }
            
            //fseek($f, 0);

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            fpassthru($f);
        }

?>
        