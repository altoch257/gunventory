<?php
    require_once('includes/dbh.inc.php');
    
    // session_start();

    $postData = $statusMsg = '';

    // if (isset($_SESSION['user'])) {
    //     header("location: home.html");
    // }


    if (isset($_REQUEST['submit'])) {
        $postData = $_POST;
        $firearm = $_REQUEST['firearm'];
        $maintenanceType = $_REQUEST['maintenanceType'];
        $date = filter_var($_REQUEST['date'], FILTER_SANITIZE_STRING);
        $details = htmlspecialchars($_REQUEST['details']);


        /* ********************************************
           ************* FIELD VALIDATION *************
           ******************************************** */
        if ($firearm == "[Select Firearm] *") {
            $statusMsgs[0][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please select firearm.<br>";
        }

        if ($maintenanceType == "[Select Type of Maintenance] *") {
            $statusMsgs[1][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please select maintenance type.<br>";
        }

        if (empty($date)) {
            $statusMsgs[2][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please enter Maintenance Date.<br>";
        }

        if (!isset($statusMsgs)) {
            try {             
                $timestamp = new DateTime('now', new DateTimeZone('America/New_York'));
                $timestamp = $timestamp->format('Y-m-d H:i:s');
                
                $sqlInsert = $db->prepare("INSERT INTO Maintenance (Status, FirearmId, MaintenanceTypeId, Date, Details, sTimestamp) VALUES ('A', :fid, :mid, :date, :details, :dt)");

                if ($sqlInsert->execute([':fid' => $firearm, ':mid' => $maintenanceType, ':date' => $date, ':details' => $details, ':dt' => $timestamp])) {
                    echo "<script>window.location = 'index.php';</script>";
                }
                else {
                    echo "Stay here!";
                }
            } 
            catch (PDOException $ex) {
                $pdoError = "Oops. An exception occurred and we were unable to save the record. Please check all the fields are populated correctly and try again.<br> $ex";
            }
        }
    }


?>
