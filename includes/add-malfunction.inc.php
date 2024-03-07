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
        $malfunctionType = $_REQUEST['malfunctionType'];
        $ammo = $_REQUEST['ammo'];
        $details = htmlspecialchars($_REQUEST['details']);
        $malfunctionDate = filter_var($_REQUEST['malfunctionDate'], FILTER_SANITIZE_STRING);
        
        
        /* ********************************************
           ************* FIELD VALIDATION *************
           ******************************************** */
        if ($firearm == "[Select Firearm] *") {
            $statusMsgs[0][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please select firearm.<br>";
        }

        if ($malfunctionType == "[Select Malfunction Type] *") {
            $statusMsgs[2][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please select type of malfunction.<br>";
        }
        
        if ($ammo == "[Select Ammo Used] *") {
            $statusMsgs[1][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please select ammo.<br>";
        }

        if (empty($malfunctionDate)) {
            $statusMsgs[5][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please enter Malfunction Date.<br>";
        }

        if (!isset($statusMsgs)) {
            try {             
                $timestamp = new DateTime('now', new DateTimeZone('America/New_York'));
                $timestamp = $timestamp->format('Y-m-d H:i:s');
                
                $sqlInsert = $db->prepare("INSERT INTO Malfunctions (Status, FirearmId, MalfunctionId, AmmoId, MalfunctionDate, Details, sTimestamp) VALUES ('A', :fid, :mid, :aid, :mdate, :details, :dt)");

                if ($sqlInsert->execute([':fid' => $firearm, ':mid' => $malfunctionType, ':aid' => $ammo, ':mdate' => $malfunctionDate, ':details' => $details, ':dt' => $timestamp])) {
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
