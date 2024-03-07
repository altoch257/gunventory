<?php
    require_once('includes/dbh.inc.php');
    
    // session_start();

    $postData = $statusMsg = '';

    // if (isset($_SESSION['user'])) {
    //     header("location: home.html");
    // }


    if (isset($_REQUEST['submit'])) {
        $postData = $_POST;
        $brand = filter_var($_REQUEST['brand'], FILTER_SANITIZE_STRING);
        $gunType = $_REQUEST['gunType'];
        $caliber = $_REQUEST['caliber'];
        $rounds = filter_var($_REQUEST['rounds'], FILTER_SANITIZE_STRING);
        $purchaseDate = filter_var($_REQUEST['purchaseDate'], FILTER_SANITIZE_STRING);
        $price = filter_var($_REQUEST['price'], FILTER_SANITIZE_STRING);
        $attachment = $_FILES['attachment']['name'];


        /* ********************************************
           ************* FIELD VALIDATION *************
           ******************************************** */
        if (empty($brand)) {
            $statusMsgs[0][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please enter manufacturer.<br>";
        }

        if ($gunType == "[Select Gun Type] *") {
            $statusMsgs[1][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please select gun type.<br>";
        }

        if ($caliber == "[Select Caliber] *") {
            $statusMsgs[2][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please select caliber.<br>";
        }

        if (empty($rounds)) {
            $statusMsgs[3][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please enter number of rounds.<br>";
        }

        if (empty($purchaseDate)) {
            $statusMsgs[4][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please enter Purchase Date.<br>";
        }

        if (empty($price)) {
            $statusMsgs[5][] = "<i class='mdi mdi-small mdi-alert-octagon mr-2'></i>Please enter purchase price.<br>";
        }

        if (!isset($statusMsgs)) {
            try {             
                $timestamp = new DateTime('now', new DateTimeZone('America/New_York'));
                $timestamp = $timestamp->format('Y-m-d H:i:s');

                if (!isset($subtract)) {
                    $subtract = 0;
                }

                // if file was uploaded, add full path so it can be saved to DB
                // also add timestamp to filename to ensure uniqueness
                if (!empty($attachment)) {
                    $path_parts = pathinfo($_FILES['attachment']['name']);
                    $attachment = './img/uploads/' . $path_parts['filename'] . "_" . time() . "." . $path_parts['extension'];
                }

                
                $sqlInsert = $db->prepare("INSERT INTO Ammunitions (Status, Manufacturer, GunTypeId, CaliberId, Rounds, PurchaseDate, Price, ImgURL, sTimestamp) VALUES ('A', :brand, :gtid, :cid, :rds, :pdate, :price, :url, :dt)");

                if ($sqlInsert->execute([':brand' => $brand, ':gtid' => $gunType, ':cid' => $caliber, ':rds' => $rounds, ':pdate' => $purchaseDate, ':price' => $price, ':url' => $attachment, ':dt' => $timestamp])) {
                    // Move attachment to uploads folder if there was one
                    if (!empty($attachment)) {
                        move_uploaded_file($_FILES['attachment']['tmp_name'], $attachment);
                    }

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
