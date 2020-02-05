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

        if(isset($_POST['export'])){

            $delimiter = ",";
            $numberCourseFilename = $_SESSION['NumCourseInResultStudent'];
            $nameCourseFilename = $_SESSION['NameCourseInResultStudent'];
            $GroupCourseFilename = $_SESSION['GroupCourseInResultStudent'];
            $TypeCourseFilename = $_SESSION['TypeResult'];

            $filename = $numberCourseFilename . "_" . $GroupCourseFilename . "_" . $TypeCourseFilename . ".csv";
            
            $f = fopen('php://output', 'w');

            fputs($f, $bom = ( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
            
            $fields = array('รหัสนิสิต', 'ชื่อนิสิต', 'สาขา', 'จำนวนที่เช็ค', 'ทันเวลา', 'สาย', 'คะแนนเข้าห้อง', 'คะแนนที่หัก', 'คะแนนพิเศษ');
            fputcsv($f, $fields, $delimiter);

            $dataResultStudent = $_SESSION["ResultStudentData"];
            for($x = 0;$x < count($dataResultStudent);$x+=1){
                $lineData = array($dataResultStudent[$x][0], $dataResultStudent[$x][1], $dataResultStudent[$x][2], $dataResultStudent[$x][3], $dataResultStudent[$x][4], $dataResultStudent[$x][5], $dataResultStudent[$x][6], $dataResultStudent[$x][7], $dataResultStudent[$x][8]);
                fputcsv($f, $lineData, $delimiter);
            }
            
            //fseek($f, 0);

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            fpassthru($f);
        }

?>
        