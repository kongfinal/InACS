<?php 
session_start();
include('condb.php');
        $term = $_SESSION["IDTerm"];

        if(isset($_POST['terms'])){
            $_SESSION["IDTermStudent"] = $_POST['terms'];
            $_SESSION["PaginationStudent"] = 1;
            $_SESSION["PaginationSelectStudent"] = 1;
            Header("Location: select-course-student.php");
        }


        if(isset($_POST['Pagination'])){ 
            if($_POST['Pagination'] == "«"){
                $_SESSION["PaginationSelectStudent"]-=1;
                Header("Location: select-course-student.php");
            }else if($_POST['Pagination'] == "»"){
                $_SESSION["PaginationSelectStudent"]+=1;
                Header("Location: select-course-student.php");
            }else{
                $_SESSION["PaginationSelectStudent"] = intval($_POST['Pagination']);
                Header("Location: select-course-student.php");
            }
        }

        if(isset($_POST['PaginationStudent'])){ 
            if($_POST['PaginationStudent'] == "«"){
                $_SESSION["PaginationStudent"]-=1;
                Header("Location: student-management.php");
            }else if($_POST['PaginationStudent'] == "»"){
                $_SESSION["PaginationStudent"]+=1;
                Header("Location: student-management.php");
            }else{
                $_SESSION["PaginationStudent"] = intval($_POST['PaginationStudent']);
                Header("Location: student-management.php");
            }
        }

        if( isset($_GET['idCourse']) ){
            $queryCourse = "SELECT * FROM `inacs_course` WHERE ID='".$_GET['idCourse']."' ";
            $CourseData = mysqli_query($con,$queryCourse);

            if(mysqli_num_rows($CourseData) == 1){
                while ($row = mysqli_fetch_assoc($CourseData)) {
                    $_SESSION["IDCourseInManaStudent"] = $_GET['idCourse'];
                    $_SESSION["NumCourseInManaStudent"] = $row['Number'];
                    $_SESSION["NameCourseInManaStudent"] = $row['Name'];
                    $_SESSION["GroupCourseInManaStudent"] = $row['GroupCourse'];
                    $_SESSION["TypeCourseInManaStudent"] = $row['Type'];
                }
            }

            Header("Location: student-management.php");
        }

        if(isset($_POST['addGroupStudentModal'])){
            $_SESSION['CheckOpenModalAddStudentGroup'] = true;
            Header("Location: student-management.php");
        }

        if(isset($_POST['addStudentModal'])){
            $_SESSION['CheckOpenModalAddStudent'] = true;
            Header("Location: student-management.php");
        }

        if(isset($_POST['deleteStudentModal'])){
            $_SESSION['IDStudentDelete'] = $_POST['deleteStudentModal'];
            $_SESSION['CheckOpenModalDeleteStudent'] = true;
            Header("Location: student-management.php");
        }

        if(isset($_POST['editStudentModal'])){
            $_SESSION['IDStudentEdit'] = $_POST['editStudentModal'];

            $IDEdit = $_POST['editStudentModal'];
            $queryStudentEdit = "SELECT * FROM `inacs_student` WHERE ID='$IDEdit'";
            $StudentEdit = mysqli_query($con,$queryStudentEdit);
            if(mysqli_num_rows($StudentEdit) == 1){
                while ($row = mysqli_fetch_assoc($StudentEdit)) {
                    $_SESSION["IDStudentEdit"] = $row['ID'];
                    $_SESSION["NumberStudentEdit"] = $row['Number'];
                    $_SESSION["NameStudentEdit"] = $row['Name'];
                    $_SESSION["BranchStudentEdit"] = $row['Branch'];
                    $_SESSION["ParentalPhoneNumberStudentEdit"] = $row['ParentalPhoneNumber'];
                }
            }
            $_SESSION['CheckOpenModalEditStudent'] = true;
            Header("Location: student-management.php");
        }


        if(isset($_POST['addGroupStudent'])){
            if(empty($_POST["dataStudent"])){
                echo "<script>";
                    echo "alert(\" โปรดใส่ข้อมูล\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }
            else{
                $array = explode("\r\n", $_POST["dataStudent"]);
                $student_array = array_unique($array);
                $strSQL = "";
                for($x = 0; $x < count($student_array); $x+=1){         
                    $dataStudent =  explode("	", $student_array[$x]);


                    if(! (empty($dataStudent[0]) || empty($dataStudent[1]) || empty($dataStudent[3]) )){
                        $searchSQL="SELECT * FROM inacs_student 
                        WHERE IDCourse='".$_SESSION["IDCourseInManaStudent"]."' 
                        AND Number='$dataStudent[0]' ";
    
                        $result = mysqli_query($con,$searchSQL);
                        if(mysqli_num_rows($result)==0){
    
                            $strSQL ="INSERT INTO inacs_student (ID,IDCourse,Number,Name,Branch,ParentalPhoneNumber,Status) VALUES 
                            (NULL,'".$_SESSION["IDCourseInManaStudent"]."','$dataStudent[0]','$dataStudent[1]','$dataStudent[3]',NULL,NULL );";
                            $objQuery = mysqli_query($con,$strSQL); 

                            $searchStudentSQL="SELECT * FROM inacs_student 
                            WHERE IDCourse='".$_SESSION["IDCourseInManaStudent"]."' 
                            AND Number='$dataStudent[0]' ";
                            $resultStudent = mysqli_query($con,$searchStudentSQL);

                            if(mysqli_num_rows($resultStudent)==1){

                                while($row = mysqli_fetch_assoc($resultStudent)){
                                    $_SESSION["IDStudentToCreateResult"] = $row['ID'];
                                }

                                $strSQL = "INSERT INTO inacs_result ";
                                $strSQL .="(ID,IDStudent,ScoreRoom,ScoreDeducted,ScoreExtra,NumberOnTime,NumberLate,NumberAbsent,LastCheckTime) ";
                                $strSQL .="VALUES ";
                                $strSQL .="(NULL,'".$_SESSION["IDStudentToCreateResult"]."','0','0','0','0','0','0','' ) ";
                                
                                $objResultQuery = mysqli_query($con,$strSQL);

                            }

                        }  
                    }                       
                }
                    if($objResultQuery){
                        echo "<script>";
                            echo "alert(\" Add Student Complete\");"; 
                            echo "window.history.back()";
                        echo "</script>";
                    }else{
                        echo "<script>";
                            echo "alert(\" Add Student Error\");";
                            echo "window.history.back()";
                        echo "</script>";
                    }
                               
            }
        }


        if(isset($_POST['addStudent'])){
            if (empty($_POST["NumStudent"]) or empty($_POST["NameStudent"]) or empty($_POST["BranchStudent"])) {
                echo "<script>";
                    echo "alert(\" โปรดใส่ข้อมูลให้ครบ\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else {
                $numberStudent = $_POST['NumStudent'];
                $nameStudent = $_POST['NameStudent'];
                $branchStudent = $_POST['BranchStudent'];
                

                $searchSQL="SELECT * FROM inacs_student 
                                WHERE IDCourse='".$_SESSION["IDCourseInManaStudent"]."' 
                                AND Number='$numberStudent'
                                 ";
                $result = mysqli_query($con,$searchSQL);
                if(mysqli_num_rows($result)==0){
                    
                    $strSQL = "INSERT INTO inacs_student ";
                    $strSQL .="(ID,IDCourse,Number,Name,Branch,ParentalPhoneNumber,Status) ";
                    $strSQL .="VALUES ";
                    $strSQL .="(NULL,'".$_SESSION["IDCourseInManaStudent"]."','$numberStudent','$nameStudent','$branchStudent',NULL,NULL ) ";
                    
                    $objQuery = mysqli_query($con,$strSQL);
                        if($objQuery){

                            $searchStudentSQL="SELECT * FROM inacs_student 
                            WHERE IDCourse='".$_SESSION["IDCourseInManaStudent"]."' 
                            AND Number='$numberStudent' ";
                            $resultStudent = mysqli_query($con,$searchStudentSQL);

                            if(mysqli_num_rows($resultStudent)==1){

                                while($row = mysqli_fetch_assoc($resultStudent)){
                                    $_SESSION["IDStudentToCreateResult"] = $row['ID'];
                                }

                                $strSQL = "INSERT INTO inacs_result ";
                                $strSQL .="(ID,IDStudent,ScoreRoom,ScoreDeducted,ScoreExtra,NumberOnTime,NumberLate,NumberAbsent,LastCheckTime) ";
                                $strSQL .="VALUES ";
                                $strSQL .="(NULL,'".$_SESSION["IDStudentToCreateResult"]."','0','0','0','0','0','0','' ) ";                 
                                $objQuery = mysqli_query($con,$strSQL);

                                if($objQuery){
                                    echo "<script>";
                                        echo "alert(\" Add Student Complete\");"; 
                                        echo "window.history.back()";
                                    echo "</script>";
                                }else{
                                    echo "<script>";
                                    echo "alert(\" Add Result Error\");"; 
                                    echo "window.history.back()";
                                    echo "</script>"; 
                                }
                            }
                        }else{
                            echo "<script>";
                                echo "alert(\" Add Student Error\");"; 
                                echo "window.history.back()";
                            echo "</script>";
                        }
                    
                }else{
                    echo "<script>";
                        echo "alert(\" ข้อมูลนิสิตที่ใส่ซ้ำกับในระบบ\");"; 
                        echo "window.history.back()";
                    echo "</script>";
                }
            }
        }

        if(isset($_POST['editStudent'])){
            if (empty($_POST["NumStudent"]) or empty($_POST["NameStudent"]) or empty($_POST["BranchStudent"])) {
                echo "<script>";
                    echo "alert(\" โปรดใส่ข้อมูลให้ครบ\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else {
                $numberStudent = $_POST['NumStudent'];
                $nameStudent = $_POST['NameStudent'];
                $branchStudent = $_POST['BranchStudent'];
                $phoneNumberStudent = $_POST['ParentalPhoneNumberStudent'];


                $checkPhoneNumber = false;
                if($phoneNumberStudent == null){
                    $checkPhoneNumber = true;
                }else{
                    if(strlen($phoneNumberStudent) != 10){
                        echo "<script>";
                            echo "alert(\" โปรดใส่เบอร์โทรศัพท์สิบตัว\");"; 
                            echo "window.history.back()";
                        echo "</script>";
                    }else if (!filter_var(substr($phoneNumberStudent,1,10), FILTER_VALIDATE_INT)) {
                        echo "<script>";
                            echo "alert(\" ข้อมูลเบอร์โทรศัพท์ไม่ได้มีแต่ตัวเลข หรือ ตัวเลขต่ำแหน่งที่ 2 เป็น 0\");"; 
                            echo "window.history.back()";
                        echo "</script>";
                    }else if(substr($phoneNumberStudent,0,1) != "0"){
                        echo "<script>";
                            echo "alert(\" ข้อมูลเบอร์โทรศัพท์ตัวแรกไม่ได้เป็น 0\");"; 
                            echo "window.history.back()";
                        echo "</script>";
                    }else{
                        $checkPhoneNumber = true;
                    }
                }



                if($checkPhoneNumber){
                    $searchSQL="SELECT * FROM inacs_student 
                    WHERE IDCourse='".$_SESSION["IDCourseInManaStudent"]."' 
                    AND Number='$numberStudent'
                     ";
                    $result = mysqli_query($con,$searchSQL);
                    $DataStudentCheck = mysqli_fetch_assoc($result);

                    if((mysqli_num_rows($result)==0) || (mysqli_num_rows($result) == 1 && $DataStudentCheck['ID'] == $_SESSION["IDStudentEdit"]) ){

                        $strSQL = "UPDATE inacs_student SET Number='".$_POST["NumStudent"]."' 
                        , Name='".$_POST["NameStudent"]."'
                        , Branch='".$_POST["BranchStudent"]."'
                        , ParentalPhoneNumber='".$_POST['ParentalPhoneNumberStudent']."'
                        WHERE ID='".$_SESSION['IDStudentEdit']."'";
                        
                        $objQuery = mysqli_query($con,$strSQL);
                        if($objQuery){
                            echo "<script>";
                                echo "alert(\" Update Student Complete\");"; 
                                echo "window.history.back()";
                            echo "</script>";
                            
                        }else{
                            echo "<script>";
                                echo "alert(\" Update Student Error\");"; 
                            echo "</script>";
                        }
                    }else{
                        echo "<script>";
                            echo "alert(\" ข้อมูลนิสิตที่ใส่ซ้ำกับในระบบ\");"; 
                            echo "window.history.back()";
                        echo "</script>";
                    }
                }




            }
        }

        if(isset($_POST['deleteStudent'])){
            $searchSQL="SELECT * FROM inacs_student WHERE ID='".$_SESSION['IDStudentDelete']."' ";
            $result = mysqli_query($con,$searchSQL);
            if(mysqli_num_rows($result) == 1){

                $searchVacationSQL="SELECT * FROM inacs_vacation WHERE IDStudent='".$_SESSION['IDStudentDelete']."' ";
                $resultVacationSQL = mysqli_query($con,$searchVacationSQL);
                while($rowVacation = mysqli_fetch_array($resultVacationSQL)){
                    mysqli_query($con,"DELETE FROM inacs_vacation WHERE ID=$rowVacation[0] ");
                }

                $searchMessageSQL="SELECT * FROM inacs_message WHERE IDStudent='".$_SESSION['IDStudentDelete']."' ";
                $resultMessageSQL = mysqli_query($con,$searchMessageSQL);
                while($rowMessage = mysqli_fetch_array($resultMessageSQL)){
                    mysqli_query($con,"DELETE FROM inacs_message WHERE ID=$rowMessage[0] ");
                }

                $searchResultSQL="SELECT * FROM inacs_result WHERE IDStudent='".$_SESSION['IDStudentDelete']."' ";
                $resultResultSQL = mysqli_query($con,$searchResultSQL);
                while($rowResult = mysqli_fetch_array($resultResultSQL)){
                    mysqli_query($con,"DELETE FROM inacs_result WHERE ID=$rowResult[0] ");
                }

                $strSQL="DELETE FROM inacs_student WHERE ID='".$_SESSION['IDStudentDelete']."' ";
                $objQuery = mysqli_query($con,$strSQL);

                $searchCountSQL="SELECT * FROM inacs_student WHERE IDCourse='".$_SESSION["IDCourseInManaStudent"]."' ";
                $resultCount = mysqli_query($con,$searchCountSQL);

                if(fmod(mysqli_num_rows($resultCount),8) == 0 && mysqli_num_rows($resultCount) != 0){
                    $_SESSION["PaginationStudent"]-=1;
                }

                if($objQuery){
                    echo "<script>";
                        echo "alert(\" Delete Student Complete\");"; 
                        echo "window.history.back()";
                    echo "</script>";
                    
                }else{
                    echo "<script>";
                        echo "alert(\" Delete Student Error\");"; 
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

    
        