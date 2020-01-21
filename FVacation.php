<?php 
session_start();
include('condb.php');

        if(isset($_POST['terms'])){
            $_SESSION["IDTermVacation"] = $_POST['terms'];
            $_SESSION["CheckTermVacation"] = true;

            $_SESSION["PaginationVacation"] = 1;
            Header("Location: vacation.php");
        }

        if(isset($_POST['courses'])){
            $_SESSION["IDCourseVacation"] = $_POST['courses'];
            
            $_SESSION["PaginationVacation"] = 1;
            Header("Location: vacation.php");
        }

        if(isset($_POST['Pagination'])){ 
            if($_POST['Pagination'] == "«"){
                $_SESSION["PaginationVacation"]-=1;
                Header("Location: vacation.php");
            }else if($_POST['Pagination'] == "»"){
                $_SESSION["PaginationVacation"]+=1;
                Header("Location: vacation.php");
            }else{
                $_SESSION["PaginationVacation"] = intval($_POST['Pagination']);
                Header("Location: vacation.php");
            }
        }

        if(isset($_POST['addVacationModal'])){
            $_SESSION['CheckOpenModalAddVacation'] = true;
            Header("Location: vacation.php");
        }

        if(isset($_POST['editVacationModal'])){
            $_SESSION['IDVacationEdit'] = $_POST['editVacationModal'];

            $IDEdit = $_POST['editVacationModal'];
            $queryacationEdit = "SELECT * FROM `inacs_vacation` WHERE ID='$IDEdit'";
            $VacationEdit = mysqli_query($con,$queryacationEdit);
            if(mysqli_num_rows($VacationEdit) == 1){
                while ($row = mysqli_fetch_assoc($VacationEdit)) {
                    $_SESSION["IDVacationEdit"] = $row['ID'];

                    $dataVacationDay =  explode("/", $row['NotificationDate']);
                    $_SESSION["NotificationDateVacationEdit"] = "$dataVacationDay[2]-$dataVacationDay[1]-$dataVacationDay[0]";

                    $_SESSION["DetailVacationEdit"] = $row['Detail'];

                    $dataVacationStartTime =  explode("/", $row['TimeStart']);
                    $_SESSION["TimeStartVacationEdit"] = "$dataVacationStartTime[2]-$dataVacationStartTime[1]-$dataVacationStartTime[0]";

                    $dataVacationEndTime =  explode("/", $row['TimeEnd']);
                    $_SESSION["TimeEndVacationEdit"] = "$dataVacationEndTime[2]-$dataVacationEndTime[1]-$dataVacationEndTime[0]";

                    $searchSQL="SELECT * FROM inacs_student WHERE ID='".$row['IDStudent']."'";
                    $result = mysqli_query($con,$searchSQL);

                    if(mysqli_num_rows($result) == 1){
                        while ($row = mysqli_fetch_assoc($result)) {
                            $_SESSION["NumStudentVacationEdit"] = $row['Number'];
                        }
                    }
                }
            }
            $_SESSION['CheckOpenModalEditVacation'] = true;
            Header("Location: vacation.php");
        }

        if(isset($_POST['deleteVacationModal'])){
            $_SESSION['IDVacationDelete'] = $_POST['deleteVacationModal'];
            $_SESSION['CheckOpenModalDeleteVacation'] = true;
            Header("Location: vacation.php");
        }

        if(isset($_POST['addVacation'])){

            $checkDataTime = array();
            array_push($checkDataTime,$_POST["VacationDays-1"]);
            array_push($checkDataTime,$_POST["VacationDays-2"]);
            sort($checkDataTime);

            if (empty($_POST["VacationDay"]) or empty($_POST["VacationNumStudent"]) or empty($_POST["VacationTextarea"]) or empty($_POST["VacationDays-1"]) or empty($_POST["VacationDays-2"])) {
                echo "<script>";
                    echo "alert(\" โปรดใส่ข้อมูลให้ครบ\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else if($checkDataTime[0] != $_POST["VacationDays-1"] && $checkDataTime[1] != $_POST["VacationDays-2"]){
                echo "<script>";
                    echo "alert(\" ข้อมูลวันที่ลาผิดพลาด\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else {
                $dataVacationDay =  explode("-", $_POST["VacationDay"]);
                $vacationDay = "$dataVacationDay[2]/$dataVacationDay[1]/$dataVacationDay[0]";

                $numberStudent = $_POST['VacationNumStudent'];
                $vacationDetail = $_POST['VacationTextarea'];

                $dataVacationStartTime=  explode("-", $_POST["VacationDays-1"]);
                $vacationStartTime = "$dataVacationStartTime[2]/$dataVacationStartTime[1]/$dataVacationStartTime[0]";

                $dataVacationEndTime=  explode("-", $_POST["VacationDays-2"]);
                $vacationEndTime = "$dataVacationEndTime[2]/$dataVacationEndTime[1]/$dataVacationEndTime[0]";


                $searchSQL="SELECT * FROM inacs_student 
                WHERE IDCourse='".$_SESSION["IDCourseVacation"]."' 
                AND Number='$numberStudent'
                 ";
                $result = mysqli_query($con,$searchSQL);

                if(mysqli_num_rows($result) == 1){

                    while ($row = mysqli_fetch_assoc($result)) {
                        $idStudent = $row['ID'];
                        $nameStudent = $_POST['Name'];
                    }
                    
                    $strSQL = "INSERT INTO inacs_vacation ";
                    $strSQL .="(ID,IDCourse,IDStudent,NotificationDate,Detail,TimeStart,TimeEnd) ";
                    $strSQL .="VALUES ";
                    $strSQL .="(NULL,'".$_SESSION["IDCourseVacation"]."','$idStudent','$vacationDay','$vacationDetail','$vacationStartTime','$vacationEndTime' ) ";

                    $objQuery = mysqli_query($con,$strSQL);
                        if($objQuery){
                            echo "<script>";
                                echo "alert(\" Add Vacation Complete\");"; 
                                echo "window.history.back()";
                            echo "</script>";
                        }else{
                            echo "<script>";
                                echo "alert(\" Add Vacation Error\");"; 
                                echo "window.history.back()";
                            echo "</script>";
                        }
                    
                }else{
                    echo "<script>";
                        echo "alert(\" ไม่มีนิสิตที่มีข้อมูลตรงกับข้อมูลนิสิตที่ใส่อยู่ในรายวิชานี้\");"; 
                        echo "window.history.back()";
                    echo "</script>";
                }
            }
          }

          if(isset($_POST['editVacation'])){

            $checkDataTime = array();
            array_push($checkDataTime,$_POST["VacationDays-1"]);
            array_push($checkDataTime,$_POST["VacationDays-2"]);
            sort($checkDataTime);

            if (empty($_POST["VacationDay"]) or empty($_POST["VacationNumStudent"]) or empty($_POST["VacationTextarea"]) or empty($_POST["VacationDays-1"]) or empty($_POST["VacationDays-2"])) {
                echo "<script>";
                    echo "alert(\" โปรดใส่ข้อมูลให้ครบ\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else if($checkDataTime[0] != $_POST["VacationDays-1"] && $checkDataTime[1] != $_POST["VacationDays-2"]){
                echo "<script>";
                    echo "alert(\" ข้อมูลวันที่ลาผิดพลาด\");"; 
                    echo "window.history.back()";
                echo "</script>";
            }else {
                $dataVacationDay =  explode("-", $_POST["VacationDay"]);
                $vacationDay = "$dataVacationDay[2]/$dataVacationDay[1]/$dataVacationDay[0]";

                $numberStudent = $_POST['VacationNumStudent'];
                $vacationDetail = $_POST['VacationTextarea'];

                $dataVacationStartTime=  explode("-", $_POST["VacationDays-1"]);
                $vacationStartTime = "$dataVacationStartTime[2]/$dataVacationStartTime[1]/$dataVacationStartTime[0]";

                $dataVacationEndTime=  explode("-", $_POST["VacationDays-2"]);
                $vacationEndTime = "$dataVacationEndTime[2]/$dataVacationEndTime[1]/$dataVacationEndTime[0]";


                $searchSQL="SELECT * FROM inacs_vacation WHERE ID='".$_SESSION['IDVacationEdit']."' ";
                $result = mysqli_query($con,$searchSQL);

                $searchStudentSQL="SELECT * FROM inacs_student 
                WHERE IDCourse='".$_SESSION["IDCourseVacation"]."' AND Number='$numberStudent' ";
                $resultStudent = mysqli_query($con,$searchStudentSQL);

                if(mysqli_num_rows($result) == 1 && mysqli_num_rows($resultStudent) == 1){

                    while ($row = mysqli_fetch_assoc($resultStudent)) {
                        $idStudent = $row['ID'];
                        $nameStudent = $_POST['Name'];
                    }
                    
                    $strSQL = "UPDATE inacs_vacation SET IDStudent='$idStudent' 
                    , NotificationDate='$vacationDay' 
                    , Detail='".$_POST["VacationTextarea"]."'
                    , TimeStart='$vacationStartTime'
                    , TimeEnd='$vacationEndTime'
                    WHERE ID='".$_SESSION['IDVacationEdit']."'";

                    $objQuery = mysqli_query($con,$strSQL);
                        if($objQuery){
                            echo "<script>";
                                echo "alert(\" Edit Vacation Complete\");"; 
                                echo "window.history.back()";
                            echo "</script>";
                        }else{
                            echo "<script>";
                                echo "alert(\" Edit Vacation Error\");"; 
                                echo "window.history.back()";
                            echo "</script>";
                        }
                    
                }else{
                    echo "<script>";
                        echo "alert(\" ไม่มีนิสิตที่มีข้อมูลตรงกับข้อมูลนิสิตที่ใส่อยู่ในรายวิชานี้\");"; 
                        echo "window.history.back()";
                    echo "</script>";
                }
            }
          }

          if(isset($_POST['deleteVacation'])){
            $searchSQL="SELECT * FROM inacs_vacation WHERE ID='".$_SESSION['IDVacationDelete']."' ";
            $result = mysqli_query($con,$searchSQL);
            if(mysqli_num_rows($result) == 1){
                $strSQL="DELETE FROM inacs_vacation WHERE ID='".$_SESSION['IDVacationDelete']."' ";
                $objQuery = mysqli_query($con,$strSQL);

                $searchCountSQL="SELECT * FROM inacs_vacation WHERE IDCourse='".$_SESSION["IDCourseVacation"]."' ";
                $resultCount = mysqli_query($con,$searchCountSQL);

                if(fmod(mysqli_num_rows($resultCount),5) == 0 && mysqli_num_rows($resultCount) != 0){
                    $_SESSION["PaginationVacation"]-=1;
                }

                if($objQuery){
                    echo "<script>";
                        echo "alert(\" Delete Vacation Complete\");"; 
                        echo "window.history.back()";
                    echo "</script>";
                    
                }else{
                    echo "<script>";
                        echo "alert(\" Delete Vacation Error\");"; 
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


        