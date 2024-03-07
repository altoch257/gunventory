<?php
    $envFlag = "T";
    
    if ($envFlag == "P") {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/AppSettings.php';
    }
    else {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/Gunventory/AppSettings.php';
    }
    
    include_once('functions.inc.php');


    try {
        $db = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        CreateRolesTable($db);
        CreateUsersTable($db);
        CreateCalibersTable($db);
        CreateGunTypesTable($db);
        CreateFirearmsTable($db); 
        CreateShootingTypesTable($db);
        CreateAmmunitionsTable($db);
        CreateShootingActivityTable($db);
        CreateMaintenanceTypesTable($db);
        CreateMaintenanceTable($db);
        CreateAccessoriesTable($db);
        CreateMalfunctionTypesTable($db);
        CreateMalfunctionsTable($db);
        
        InsertRoles($db);
        InsertSuperAdmin($db, $superAdmin, $superPass);
        InsertCalibers($db);
        InsertGunTypes($db);
        // InsertFirearms($db);
        InsertShootingTypes($db);
        InsertMaintenanceTypes($db);
        InsertMalfunctionTypes($db);
    } 
    catch (PDOException $ex) {
        echo $ex->getMessage();
    }

?>