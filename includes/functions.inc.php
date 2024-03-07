<?php

    function CreateUsersTable($db) {
        $sqlStr = $db->prepare("CREATE TABLE IF NOT EXISTS Users (
            `Id` INT AUTO_INCREMENT PRIMARY KEY,
            `Status` VARCHAR(1) NOT NULL,
            `FirstName` VARCHAR(50) NOT NULL,
            `LastName` VARCHAR(50) NOT NULL,
            `Email` VARCHAR(100) NOT NULL,
            `Phone` VARCHAR(15),
            `Username` VARCHAR(20) NOT NULL,
            `Password` CHAR(60),
            `RoleId` INT NOT NULL,
            `Position` VARCHAR(30),
            `Street` VARCHAR(30),
            `Street2` VARCHAR(30),
            `City` VARCHAR(30),
            `State` VARCHAR(2),
            `Zip` VARCHAR(10),
            `sTimestamp` DATETIME NOT NULL,
            UNIQUE KEY (`Username`),
            UNIQUE KEY (`Email`),
            FOREIGN KEY (RoleId) REFERENCES Roles(Id)
        );");
        if($sqlStr->execute() !== false) {
            $result = 1; 
        }
        else {
            $result = 0;
        }
    }

    function CreateRolesTable($db) {
        $sqlStr = $db->prepare("CREATE TABLE IF NOT EXISTS Roles (
            `Id` INT AUTO_INCREMENT PRIMARY KEY,
            `Status` VARCHAR(1) NOT NULL,
            `Role` VARCHAR(50) NOT NULL, 
            `sTimestamp` DATETIME NOT NULL
        );");

        if($sqlStr->execute() !== false) { $result = 1; }
    }

    function CreateGunTypesTable($db) {
        $sqlStr = $db->prepare("CREATE TABLE IF NOT EXISTS GunTypes (
            `Id` INT AUTO_INCREMENT PRIMARY KEY,
            `Status` VARCHAR(1) NOT NULL,
            `GunType` VARCHAR(15) NOT NULL, 
            `sTimestamp` DATETIME NOT NULL
        );");

        if($sqlStr->execute() !== false) { $result = 1; }
    }

    function CreateCalibersTable($db) {
        $sqlStr = $db->prepare("CREATE TABLE IF NOT EXISTS Calibers (
            `Id` INT AUTO_INCREMENT PRIMARY KEY,
            `Status` VARCHAR(1) NOT NULL,
            `Caliber` VARCHAR(15) NOT NULL,
            `sTimestamp` DATETIME NOT NULL
        );");

        if($sqlStr->execute() !== false) { $result = 1; }
    }

    function CreateFirearmsTable($db) {
        $sqlStr = $db->prepare("CREATE TABLE IF NOT EXISTS Firearms (
            `Id` INT AUTO_INCREMENT PRIMARY KEY,
            `Status` VARCHAR(1) NOT NULL,
            `Manufacturer` VARCHAR(30) NOT NULL,
            `Model` VARCHAR(50) NOT NULL,
            `GunTypeId` INT NOT NULL,
            `CaliberId` INT NOT NULL,
            `Serial` VARCHAR(20) NOT NULL,
            `PurchaseDate` DATETIME NOT NULL,
            `Price` DECIMAL NOT NULL,
            `Notes` VARCHAR(50),
            `ImgURL` VARCHAR(100),
            `DocURL` VARCHAR(100),
            `sTimestamp` DATETIME NOT NULL,
            UNIQUE KEY (`Serial`),
            FOREIGN KEY (GunTypeId) REFERENCES GunTypes(Id),
            FOREIGN KEY (CaliberId) REFERENCES Calibers(Id)
        );");
        if($sqlStr->execute() !== false) {
            $result = 1; 
        }
        else {
            $result = 0;
        }
    }

    function CreateAmmunitionsTable($db) {
        $sqlStr = $db->prepare("CREATE TABLE IF NOT EXISTS Ammunitions (
            `Id` INT AUTO_INCREMENT PRIMARY KEY,
            `Status` VARCHAR(1) NOT NULL,
            `Manufacturer` VARCHAR(50) NOT NULL,
            `GunTypeId` INT NOT NULL,
            `CaliberId` INT NOT NULL,
            `Rounds` INT NOT NULL,
            `PurchaseDate` DATETIME NOT NULL,
            `Price` DECIMAL(9,2) NOT NULL DEFAULT 0,
            `ImgURL` VARCHAR(100),
            `sTimestamp` DATETIME NOT NULL,
            FOREIGN KEY (GunTypeId) REFERENCES GunTypes(Id),
            FOREIGN KEY (CaliberId) REFERENCES Calibers(Id)
        );");
        if($sqlStr->execute() !== false) {
            $result = 1; 
        }
        else {
            $result = 0;
        }
    }

    function CreateShootingTypesTable($db) {
        $sqlStr = $db->prepare("CREATE TABLE IF NOT EXISTS ShootingTypes (
            `Id` INT AUTO_INCREMENT PRIMARY KEY,
            `Status` VARCHAR(1) NOT NULL,
            `ShootingType` VARCHAR(50) NOT NULL
        );");
        if($sqlStr->execute() !== false) {
            $result = 1; 
        }
        else {
            $result = 0;
        }
    }

    function CreateShootingActivityTable($db) {
        $sqlStr = $db->prepare("CREATE TABLE IF NOT EXISTS ShootingActivities (
            `Id` INT AUTO_INCREMENT PRIMARY KEY,
            `Status` VARCHAR(1) NOT NULL,
            `FirearmId` INT NOT NULL,
            `AmmoId` INT NOT NULL,
            `CaliberId` INT NOT NULL,
            `ShootingTypeId` INT NOT NULL,
            `ShootingDate` DATETIME NOT NULL,
            `RoundsFired` INT NOT NULL,
            `Subtract` BOOLEAN NOT NULL DEFAULT 0,
            `Details` VARCHAR(255),
            `sTimestamp` DATETIME NOT NULL,
            FOREIGN KEY (FirearmId) REFERENCES Firearms(Id),
            FOREIGN KEY (AmmoId) REFERENCES Ammunitions(Id),
            FOREIGN KEY (CaliberId) REFERENCES Calibers(Id),
            FOREIGN KEY (ShootingTypeId) REFERENCES ShootingTypes(Id)
        );");

        if($sqlStr->execute() !== false) { $result = 1; }
    }

    function CreateMaintenanceTypesTable($db) {
        $sqlStr = $db->prepare("CREATE TABLE IF NOT EXISTS MaintenanceTypes (
            `Id` INT AUTO_INCREMENT PRIMARY KEY,
            `Status` VARCHAR(1) NOT NULL,
            `MaintenanceType` VARCHAR(50) NOT NULL
        );");
        if($sqlStr->execute() !== false) {
            $result = 1; 
        }
        else {
            $result = 0;
        }
    }
    
    function CreateMaintenanceTable($db) {
        $sqlStr = $db->prepare("CREATE TABLE IF NOT EXISTS Maintenance (
            `Id` INT AUTO_INCREMENT PRIMARY KEY,
            `Status` VARCHAR(1) NOT NULL,
            `FirearmId` INT NOT NULL,
            `MaintenanceTypeId` INT NOT NULL,
            `Date` DATETIME NOT NULL,
            `Details` VARCHAR(255),
            `sTimestamp` DATETIME NOT NULL,
            FOREIGN KEY (FirearmId) REFERENCES Firearms(Id),
            FOREIGN KEY (MaintenanceTypeId) REFERENCES MaintenanceTypes(Id)
        );");
        
        if($sqlStr->execute() !== false) { $result = 1; }

    }

    function CreateAccessoriesTable($db) {
        $sqlStr = $db->prepare("CREATE TABLE IF NOT EXISTS Accessories (
            `Id` INT AUTO_INCREMENT PRIMARY KEY,
            `Status` VARCHAR(1) NOT NULL,
            `Manufacturer` VARCHAR(50) NOT NULL,
            `Model` VARCHAR(50) NOT NULL,
            `PurchaseDate` DATETIME NOT NULL,
            `Price` DECIMAL(9,2) DEFAULT 0.00,
            `Details` INT NOT NULL,
            `FirearmId` INT NOT NULL,
            `ImgURL` VARCHAR(100),
            `sTimestamp` DATETIME NOT NULL,
            FOREIGN KEY (FirearmId) REFERENCES Firearms(Id)
        );");
        if($sqlStr->execute() !== false) {
            $result = 1; 
        }
        else {
            $result = 0;
        }
    }

    function CreateMalfunctionTypesTable($db) {
        $sqlStr = $db->prepare("CREATE TABLE IF NOT EXISTS MalfunctionTypes (
            `Id` INT AUTO_INCREMENT PRIMARY KEY,
            `Status` VARCHAR(1) NOT NULL,
            `MalfunctionType` VARCHAR(50) NOT NULL
        );");
        if ($sqlStr->execute() !== false) { $result = 1; }
    }

    function CreateMalfunctionsTable($db) {
        $sqlStr = $db->prepare("CREATE TABLE IF NOT EXISTS Malfunctions (
            `Id` INT AUTO_INCREMENT PRIMARY KEY,
            `Status` VARCHAR(1) NOT NULL,
            `FirearmId` Int NOT NULL,
            `MalfunctionId` Int NOT NULL,
            `AmmoId` Int NOT NULL,
            `MalfunctionDate` DATETIME,
            `Details` VARCHAR(255),
            `sTimestamp` DATETIME NOT NULL,
            FOREIGN KEY (FirearmId) REFERENCES Firearms(Id),
            FOREIGN KEY (MalfunctionId) REFERENCES MalfunctionTypes(Id),
            FOREIGN KEY (AmmoId) REFERENCES Ammunitions(Id)
        );");
        if ($sqlStr->execute() !== false) { $result = 1; }
    }

    // function CreateTerminalsTable($db) {
    //     $sqlStr = $db->prepare("CREATE TABLE IF NOT EXISTS Terminals (
    //         `Id` INT AUTO_INCREMENT PRIMARY KEY,
    //         `Status` VARCHAR(1) NOT NULL,
    //         `TerminalName` VARCHAR(30) NOT NULL,
    //         `CompanyName` VARCHAR(30),
    //         `Phone` VARCHAR(15),
    //         `Email` VARCHAR(100),
    //         `Street` VARCHAR(30),
    //         `Street2` VARCHAR(30),
    //         `City` VARCHAR(30),
    //         `State` VARCHAR(2),
    //         `Zip` VARCHAR(10),
    //         `sTimestamp` DATETIME,
    //         `LastUpdated` DATETIME
    //     );");
    //     if ($sqlStr->execute() !== false) { $result = 1; }
    // }


    function InsertSuperAdmin($db, $user, $pass) {
        // Insert Power user if table was just created.
        $sqlStr = $db->prepare("SELECT * FROM Users WHERE username = '$user' LIMIT 1");
        $sqlStr->execute();
        $row = $sqlStr->fetch(PDO::FETCH_ASSOC);

        if ($sqlStr->rowCount() == 0) {
            $firstName = "System Admin";
            $lastName = "";
            $email = "altoch@hotmail.com";
            $phone = "(848) 456-0660";
            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

            $timestamp = new DateTime('now', new DateTimeZone('America/New_York'));
            $timestamp = $timestamp->format('Y-m-d H:i:s');

            $sqlStr = $db->prepare("INSERT INTO Users (Status, FirstName, LastName, Email, Phone, Username, Password, RoleId, sTimeStamp) 
                                    VALUES ('A', :fn, :ln, :email, :phone, :username, :pass, 1, :dt)");

            $sqlStr->execute([':fn' => $firstName,
                                ':ln' => $lastName,
                                ':email' => $email,
                                ':phone' => $phone, 
                                ':username' => $user, 
                                ':pass' => $hashedPass,
                                ':dt' => $timestamp
            ]);
        }
    }

    function InsertRoles($db) {
        // Insert Power user if table was just created.
        $sqlStr = $db->prepare("SELECT * FROM Roles WHERE Role = 'Administration' LIMIT 1");
        $sqlStr->execute();
        $row = $sqlStr->fetch(PDO::FETCH_ASSOC);

        if ($sqlStr->rowCount() == 0) {
            $adminRole = "Administration";
            $hrRole = "Human Resources";
            $bdRole = "Business Development";
            $csRole = "Customer Service";
            $usersRole = "Users";

            $timestamp = new DateTime('now', new DateTimeZone('America/New_York'));
            $timestamp = $timestamp->format('Y-m-d H:i:s');

            $sqlStr = $db->prepare("INSERT INTO Roles (Status, Role, sTimestamp) 
                                    VALUES ('A', '$adminRole', '$timestamp'),
                                           ('A', '$hrRole', '$timestamp'),
                                           ('A', '$bdRole', '$timestamp'),
                                           ('A', '$csRole', '$timestamp'),
                                           ('A', '$usersRole', '$timestamp');");

            if($sqlStr->execute() !== false) { $result = 1; }
        }
    }

    function InsertShootingTypes($db) {
        // Insert Standard Shooting Types if table exist and is empty.
        $sqlStr = $db->prepare("SELECT * FROM ShootingTypes;");
        $sqlStr->execute();
        $row = $sqlStr->fetch(PDO::FETCH_ASSOC);

        if ($sqlStr->rowCount() == 0) {
            $or = "Outdoor Range";
            $ir = "Indoor Range";
            $oo = "Outing / Off-Grrid";
            $hn = "Hunting";
            $other = "Other";

            $sqlStr = $db->prepare("INSERT INTO ShootingTypes (Status, ShootingType) 
                                    VALUES ('A', '$or'),
                                           ('A', '$ir'),
                                           ('A', '$oo'),
                                           ('A', '$hn'),
                                           ('A', '$other');");

            if($sqlStr->execute() !== false) { $result = 1; }
        }
    }

    function InsertGunTypes($db) {
        // Insert Standard gun types if table exist and is empty.
        $sqlStr = $db->prepare("SELECT * FROM GunTypes;");
        $sqlStr->execute();
        $row = $sqlStr->fetch(PDO::FETCH_ASSOC);

        if ($sqlStr->rowCount() == 0) {
            $handgun = "Handgun";
            $rifle = "Rifle";
            $shotgun = "Shotgun";

            $timestamp = new DateTime('now', new DateTimeZone('America/New_York'));
            $timestamp = $timestamp->format('Y-m-d H:i:s');

            $sqlStr = $db->prepare("INSERT INTO GunTypes (Status, GunType, sTimestamp) 
                                    VALUES ('A', '$handgun', '$timestamp'),
                                           ('A', '$rifle', '$timestamp'),
                                           ('A', '$shotgun', '$timestamp');");

            if($sqlStr->execute() !== false) { $result = 1; }
        }
    }

    function InsertCalibers($db) {
        // Insert Standard calibers if table exist and is empty.
        $sqlStr = $db->prepare("SELECT * FROM Calibers;");
        $sqlStr->execute();
        $row = $sqlStr->fetch(PDO::FETCH_ASSOC);

        if ($sqlStr->rowCount() == 0) {
            $one = "9 mm";
            $two = ".223/.556";
            $three = ".380 ACP";
            $four = ".38 Special";
            $five = ".40 S&W";
            $six = ".45 ACP";

            $timestamp = new DateTime('now', new DateTimeZone('America/New_York'));
            $timestamp = $timestamp->format('Y-m-d H:i:s');

            $sqlStr = $db->prepare("INSERT INTO Calibers (Status, Caliber, sTimestamp) 
                                    VALUES ('A', '$one', '$timestamp'),
                                           ('A', '$two', '$timestamp'),
                                           ('A', '$three', '$timestamp'),
                                           ('A', '$four', '$timestamp'),
                                           ('A', '$five', '$timestamp'),
                                           ('A', '$six', '$timestamp');");

            if($sqlStr->execute() !== false) { $result = 1; }
        }
    }

    // function InsertFirearms($db) {
    //     // Insert Mockup Firearm if table exist and is empty.
    //     $sqlStr = $db->prepare("SELECT * FROM Firearms;");
    //     $sqlStr->execute();
    //     $row = $sqlStr->fetch(PDO::FETCH_ASSOC);

    //     if ($sqlStr->rowCount() == 0) {
    //         $timestamp = new DateTime('now', new DateTimeZone('America/New_York'));
    //         $timestamp = $timestamp->format('Y-m-d H:i:s');

    //         $sqlStr = $db->prepare("INSERT INTO Firearms (Status, Brand, Model, GunTypeId, CaliberId, Serial, PurchaseDate, Price, Notes, ImgURL, sTimestamp) 
    //                                 VALUES ('A', 'Smith & Wesson', 'M&P 2.0 4in', 1, 1, 'NKR0194', '2023-06-21', 610.00, '', './img/uploads/swmp2.png', '$timestamp');");

    //         if($sqlStr->execute() !== false) { $result = 1; }
    //     }
    // }

    function InsertMaintenanceTypes($db) {
        // Insert Standard Maintenance Types if table exist and is empty.
        $sqlStr = $db->prepare("SELECT * FROM MaintenanceTypes;");
        $sqlStr->execute();
        $row = $sqlStr->fetch(PDO::FETCH_ASSOC);

        if ($sqlStr->rowCount() == 0) {
            $one = "Refreshed EDC Defense Rounds";
            $two = "Complete Breakdown Cleaning";
            $three = "Field Strip";
            $four = "Zeroed Optics";
            $other = "Other";

            $sqlStr = $db->prepare("INSERT INTO MaintenanceTypes (Status, MaintenanceType) 
                                    VALUES ('A', '$one'),
                                           ('A', '$two'),
                                           ('A', '$three'),
                                           ('A', '$four'),
                                           ('A', '$other');");

            if($sqlStr->execute() !== false) { $result = 1; }
        }
    }


    function InsertMalfunctionTypes($db) {
        // Insert Standard Malfunction Types if table exist and is empty.
        $sqlStr = $db->prepare("SELECT * FROM MalfunctionTypes;");
        $sqlStr->execute();
        $row = $sqlStr->fetch(PDO::FETCH_ASSOC);

        if ($sqlStr->rowCount() == 0) {
            $one = "Double-Feed";
            $two = "Failure to Eject: Stovepipe";
            $three = "Failure to Extract";
            $four = "Failure to Fire: Hangfire";
            $five = "Failure to Fire: Light Stike";
            $six = "Failure to Fire: Squib Load";
            $seven = "Tip-Up";
            $other = "Other";

            $sqlStr = $db->prepare("INSERT INTO MalfunctionTypes (Status, MalfunctionType) 
                                    VALUES ('A', '$one'),
                                           ('A', '$two'),
                                           ('A', '$three'),
                                           ('A', '$four'),
                                           ('A', '$five'),
                                           ('A', '$six'),
                                           ('A', '$seven'),
                                           ('A', '$other');");

            if($sqlStr->execute() !== false) { $result = 1; }
        }
    }

    // function InsertDefaultTerminal($db) {
    //     $sqlStr = $db->prepare("SELECT * FROM Terminals;");
    //     $sqlStr->execute();
    //     $row = $sqlStr->fetch(PDO::FETCH_ASSOC);

    //     if ($sqlStr->rowCount() == 0) {
    //         $tmName = "*Default";
    //         $coName = "";
    //         $phone = "";
    //         $email = "";
    //         $street = "";
    //         $street2 = "";
    //         $city = "";
    //         $state = "";
    //         $zip = "";    

    //         $timestamp = new DateTime('now', new DateTimeZone('America/New_York'));
    //         $timestamp = $timestamp->format('Y-m-d H:i:s');

    //         $sqlStr = $db->prepare("INSERT INTO Terminals (Status, TerminalName, CompanyName, Phone, Email, Street, Street2, City, State, Zip, sTimestamp)
    //                                 VALUES ('A', '$tmName', '$coName', '$phone', '$email', '$street', '$street2', '$city', '$state', '$zip', '$timestamp');");

    //         if ($sqlStr->execute() !== false) { $result = 1; }
    //     }
    // }