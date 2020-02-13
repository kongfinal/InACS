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

            $queryCourse = "SELECT * FROM `inacs_course` WHERE NameTeacher='".$_SESSION['Name']."' AND Number='$numberCourse' AND GroupCourse='$groupCourse' ";
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

            $queryCourse = "SELECT * FROM `inacs_course` WHERE NameTeacher='".$_SESSION['Name']."' AND Number='".$_SESSION["NumCourseInResultStudent"]."' AND GroupCourse='".$_SESSION["GroupCourseInResultStudent"]."' ";
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
            if($_SESSION["TypeResult"] == "All"){
                $fields = array('รหัสนิสิต', 'ชื่อนิสิต', 'สาขา', 'จำนวนที่เช็ค(บรรยาย)', 'ทันเวลา(บรรยาย)', 'สาย(บรรยาย)', 'ขาด(บรรยาย)', 'จำนวนที่เช็ค(ปฎิบัติ)', 'ทันเวลา(ปฎิบัติ)', 'สาย(ปฎิบัติ)', 'ขาด(ปฎิบัติ)', 'คะแนนเข้าห้อง', 'คะแนนที่หัก', 'คะแนนพิเศษ');
                fputcsv($f, $fields, $delimiter);

                for($x = 0;$x < count($dataResultStudent);$x+=1){

                    /*if($dataResultStudent[$x][3] != $dataResultStudent[$x][4]+$dataResultStudent[$x][5]+ $dataResultStudent[$x][6]){
                        echo "<script>";
                            echo "alert(\" โปรดกดปุ่มสิ้นสุดการเช็คชื่อของรายวิชานี้ในประเภท Lecture\");"; 
                            echo "window.history.back()";
                        echo "</script>";
                    }else if($dataResultStudent[$x][10] != $dataResultStudent[$x][11]+$dataResultStudent[$x][12]+ $dataResultStudent[$x][13]){
                        echo "<script>";
                            echo "alert(\" โปรดกดปุ่มสิ้นสุดการเช็คชื่อของรายวิชานี้ในประเภท Lab\");"; 
                            echo "window.history.back()";
                        echo "</script>";
                    }else{*/
                        $lineData = array($dataResultStudent[$x][0], $dataResultStudent[$x][1], $dataResultStudent[$x][2], $dataResultStudent[$x][3], $dataResultStudent[$x][4], $dataResultStudent[$x][5], $dataResultStudent[$x][6], $dataResultStudent[$x][10], $dataResultStudent[$x][11], $dataResultStudent[$x][12], $dataResultStudent[$x][13], $dataResultStudent[$x][7], $dataResultStudent[$x][8], $dataResultStudent[$x][9]);
                        fputcsv($f, $lineData, $delimiter);
                    /*}*/

                }
            }else{
                $fields = array('รหัสนิสิต', 'ชื่อนิสิต', 'สาขา', 'จำนวนที่เช็ค', 'ทันเวลา', 'สาย', 'ขาด','คะแนนเข้าห้อง', 'คะแนนที่หัก', 'คะแนนพิเศษ');
                fputcsv($f, $fields, $delimiter);

                for($x = 0;$x < count($dataResultStudent);$x+=1){

                    /*if($dataResultStudent[$x][3] != $dataResultStudent[$x][4]+$dataResultStudent[$x][5]+ $dataResultStudent[$x][6]){
                        echo "<script>";
                            echo "alert(\" โปรดกดปุ่มสิ้นสุดการเช็คชื่อของรายวิชานี้\");"; 
                            echo "window.history.back()";
                        echo "</script>";
                    }else{*/
                        $lineData = array($dataResultStudent[$x][0], $dataResultStudent[$x][1], $dataResultStudent[$x][2], $dataResultStudent[$x][3], $dataResultStudent[$x][4], $dataResultStudent[$x][5], $dataResultStudent[$x][6],$dataResultStudent[$x][7], $dataResultStudent[$x][8], $dataResultStudent[$x][9]);
                        fputcsv($f, $lineData, $delimiter);
                    /*}*/

                }
            }
            
            //fseek($f, 0);

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            fpassthru($f);
        }

?>
        