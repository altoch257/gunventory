<?php
  $title = "Firearm Details";

  include_once('header.php');

  require_once 'includes/dbh.inc.php';

  // Get details for one firearm
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sqlStr = "SELECT
                    f.Id,
                    f.Status,
                    f.Manufacturer,
                    f.Model,
                    f.PurchaseDate,
                    f.Price,
                    f.ImgURL,
                    f.DocURL,
                    f.GunTypeId,
                    c.Caliber,
                    g.GunType,
                    IFNULL((SELECT
                        SUM(RoundsFired) AS RoundsFired
                      FROM ShootingActivities
                      WHERE firearmId = f.Id
                    AND Status = 'A'), 0) AS TotalRoundsFired,
                    (SELECT
                        ShootingDate
                      FROM ShootingActivities sa
                      WHERE Status = 'A'
                      AND sa.FirearmId = f.Id
                      ORDER BY ShootingDate DESC LIMIT 1) AS LastShootingActivity,
                    (SELECT
                        Date
                      FROM Maintenance m
                      WHERE m.Status = 'A'
                      AND m.FirearmId = f.Id
                      ORDER BY Date DESC LIMIT 1) AS LastMaintenance,
                    IFNULL((SELECT
                        SUM(acc.Price)
                      FROM Accessories acc
                      WHERE acc.FirearmId = f.Id
                      AND acc.Status = 'A'), 0.00) AS TotalAccessories,
                      (SELECT
                        MalfunctionDate
                      FROM Malfunctions
                      WHERE Status = 'A'
                      AND FirearmId = f.Id
                      ORDER BY MalfunctionDate DESC LIMIT 1) AS LastMalfunction
                FROM Firearms f
                INNER JOIN GunTypes g
                    ON g.Id = f.GunTypeId
                INNER JOIN Calibers c
                    ON c.Id = f.CaliberId
                WHERE f.Id = :id;";
    
    $stmt = $db->prepare($sqlStr);
    $stmt->execute([':id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Save some values in a variable so they can be used in other queries
    if (!empty($result['Id'])) {}
    $fId = $result['Id'];
    $gt = $result['GunTypeId'];
    // ----------------------------------------------

    $sqlStr = "SELECT
                    SUM(RoundsFired) AS RoundsFired
                FROM ShootingActivities
                WHERE Status = 'A';";
    
    $stmt = $db->prepare($sqlStr);
    $stmt->execute();
    $result2 = $stmt->fetch(PDO::FETCH_ASSOC);
    // ----------------------------------------------

    $sqlStr = "SELECT
                  a.Id,
                  a.Manufacturer,
                  SUM(a.Rounds) AS Rounds,
                  (SELECT SUM(sa.RoundsFired) FROM ShootingActivities sa WHERE sa.AmmoId = a.Id AND sa.Subtract = 1) AS RoundsFired
              FROM Ammunitions a
              WHERE a.Status = 'A'
              AND a.GunTypeId = $gt
              GROUP BY Manufacturer;";

    $stmt = $db->prepare($sqlStr);
    $stmt->execute();
    $ammoLine = $stmt->fetchAll();
    // ----------------------------------------------

    $sqlStr = "SELECT
                    s.Id,
                    s.ShootingDate,
                    st.ShootingType,
                    s.RoundsFired
                FROM ShootingActivities s
                INNER JOIN Firearms f
                  ON f.Id = s.FirearmId
                INNER JOIN ShootingTypes st
                  ON s.ShootingTypeId = st.Id
                WHERE s.Status = 'A'
                AND f.Id = $fId
                ORDER BY ShootingDate DESC;";
    
    $stmt = $db->prepare($sqlStr);
    $stmt->execute();
    $shootingLine = $stmt->fetchAll();
    // ----------------------------------------------

    $sqlStr = "SELECT
                  m.Id,
                  m.Date,
                  mt.MaintenanceType
              FROM Maintenance m
              INNER JOIN MaintenanceTypes mt
                ON mt.Id = m.MaintenanceTypeId
              WHERE m.Status = 'A'
              ORDER BY Date DESC;";
    
    $stmt = $db->prepare($sqlStr);
    $stmt->execute();
    $maintenanceLine = $stmt->fetchAll();
    // ----------------------------------------------

    $sqlStr = "SELECT
                  acc.Id,
                  acc.Manufacturer,
                  acc.Model,
                  acc.Price,
                  acc.ImgURL
              FROM Accessories acc
              INNER JOIN Firearms f
                ON f.Id = acc.FirearmId
              WHERE acc.Status = 'A'
              AND acc.FirearmId = $fId
              ORDER BY acc.Model, acc.Manufacturer;";
    
    $stmt = $db->prepare($sqlStr);
    $stmt->execute();
    $accessoryLine = $stmt->fetchAll();
    // ----------------------------------------------

    $sqlStr = "SELECT
                  m.Id,
                  mt.MalfunctionType,
                  m.MalfunctionDate
              FROM Malfunctions m
              INNER JOIN MalfunctionTypes mt
                ON mt.Id = m.MalfunctionId
              WHERE m.Status = 'A'
              AND m.FirearmId = $fId
              ORDER BY m.MalfunctionDate DESC;";
    
    $stmt = $db->prepare($sqlStr);
    $stmt->execute();
    $malfunctionLine = $stmt->fetchAll();
  }
  else {
    echo '<h1>Oops. An exception occurred while trying to open the requested firearm. Please check your request and try again.</h1>';
  }

  $grandTotal = $result['Price'] + $result['TotalAccessories'];
?>
  
<div class="container-xl">
  <div class="row">
    <div class="col-lg-7">
      <div class="row justify-content-center">
        <div class="col-md-12 text-center my-4">
          <h2 >Firearm Details</h2>
        </div>
      </div>
      
      <div class="row justify-content-center">
        <div class="col-md-12">
          <span class="d-block mb-3">
            <div class="h3 d-block mb-0"><?= $result['Model']; ?></div>
            <div><?= $result['Manufacturer']; ?></div>
            <div class="mb-3"><?= $result['Caliber']; ?></div>
            <div><i class="bi bi-calendar mr-3"></i><?= substr($result['PurchaseDate'], 0, 10); ?></div>

            <!-- <?php if (!empty($result['LastShootingActivity'])) : ?> -->
              <div><i class="mr-3 bi bi-bullseye"></i><?= substr($result['LastShootingActivity'], 0, 10); ?></div>
            <!-- <?php endif; ?> -->

            <!-- <?php if (!empty($result['LastMaintenance'])) : ?> -->
              <div><i class="mr-3 bi bi-eyedropper"></i><?= substr($result['LastMaintenance'], 0, 10); ?></div>
            <!-- <?php endif; ?> -->

            <?php if (!empty($result['LastMalfunction'])) : ?>
              <div><i class="mr-3 bi bi-exclamation-triangle"></i><?= substr($result['LastMalfunction'], 0, 10); ?></div>
            <?php endif; ?>
          </span>
        </div>
      </div>

      <div class="row justify-content-center mt-3">
        <div class="col-md-12">
          <span class="float-left">
            <a class="btn btn-primary btn-small text-light mr-2" href="edit-firearm.php?id=<?php echo $result['Id']; ?>"><i class="mdi mdi-small mdi-square-edit-outline"></i></a>
          </span>
          <span class="float-right">
            <a class="btn btn-primary btn-small text-light" href="delete-firearm.php?id=<?php echo $result['Id']; ?>"><i class="mdi mdi-small mdi-trash-can-outline"></i></a>
          </span>
        </div>
      </div>

      <!-- Stats / Details -->
      <div class="row">
        <div class="col-md-12 mt-5">
          <h2 >Stats / Details</h2>
        </div>
      </div>

      <div class="row my-1">
        <div class="col-8 col-lg-9 shaded-row">
          Purchase Date: 
        </div>
        <div class="col-4 col-lg-3 shaded-row">
          <?= substr($result['PurchaseDate'], 0, 10); ?>
        </div>
      </div>

      <div class="row my-1">
        <div class="col-8 col-lg-9 shaded-row">
          Purchase Price: 
        </div>
        <div class="col-4 col-lg-3 shaded-row">
          <?= "$" . number_format($result['Price'], 2); ?>
        </div>
      </div>

      <div class="row my-1">
        <div class="col-8 col-lg-9 shaded-row">
          Total With Accessories: 
        </div>
        <div class="col-4 col-lg-3 shaded-row">
          <?= "$" . number_format($grandTotal, 2); ?>
        </div>
      </div>

      <div class="row my-1">
        <div class="col-8 col-lg-9 shaded-row">
          Total Rounds Fired: 
        </div>
        <div class="col-4 col-lg-3 shaded-row">
          <?= $result['TotalRoundsFired']; ?>
        </div>
      </div>

      <!-- Available Ammo -->
      <?php if ($ammoLine) : ?>
        <div class="row">
          <div class="col-md-12 mt-5">
            <h2>Available Ammo</h2>
          </div>
        </div>

        <?php foreach ($ammoLine as $row) : 
          $availAmmo = $row['Rounds'] - $row['RoundsFired'];
        ?>
          <?php if ($availAmmo > 0) : ?>
            <div class="row my-1">
              <div class="col-8 col-lg-9 shaded-row">
                <?= $row['Manufacturer']; ?>
              </div>
              <div class="col-3 col-lg-2 shaded-row">
                <?= $availAmmo; ?>
              </div>
              <div class="col-1 col-lg-1 shaded-row text-right">
                <a class="" href="delete-ammo.php?id=<?= $row['Id']; ?>"><i class="mdi mdi-small mdi-trash-can-outline text-danger"></i></a>
              </div>
            </div>
          <?php endif; ?>
        <?php endforeach; ?> 
      <?php endif; ?>

      <!-- Shooting Activity -->
      <?php if ($shootingLine) : ?>
        <div class="row">
          <div class="col-md-12 mt-5">
            <h2>Shooting Activity</h2>
          </div>
        </div>
        
        <?php foreach ($shootingLine as $row) : ?>
          <div class="row my-1">
            <div class="col-4 col-lg-5 shaded-row">
              <i class="bi bi-bullseye mr-2"></i><?= substr($row['ShootingDate'], 0, 10); ?>
            </div>
            <div class="col-4 col-lg-4 shaded-row">
              <?= $row['ShootingType']; ?>
            </div>
            <div class="col-3 col-lg-2 shaded-row">
              <?= $row['RoundsFired'] . " Rds"; ?>
            </div>
            <div class="col-1 col-lg-1 shaded-row text-right">
              <a class="" href="delete-shooting-activity.php?id=<?= $row['Id']; ?>"><i class="mdi mdi-small mdi-trash-can-outline text-danger"></i></a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <div class="col-lg-5">
      <div class="row">
        <div class="col-md-12 my-4">
          <h2>Image</h2>
        </div>      

        <span class="ml-3">
          <img class="thumbnail" src="<?= $result['ImgURL']; ?>">
        </span>

        <?php if (!empty($result['DocURL'])) : ?>
          <div class="row">
            <div class="col-md-12 mt-5">
              <h2>Documents</h2>
            </div>

            <div class="ml-3">
              <a class="text-white text-decoration-none" href="<?= $result['DocURL']; ?>" target="_blank"><i class="bi bi-file-earmark mr-2"></i><?= substr($result['DocURL'], -14); ?></a>
          </div>
        </div>
        <?php endif; ?>
      </div>

      <?php if ($accessoryLine) : ?>  
        <div class="row">
          <div class="col-md-12 mt-5">
            <h2>Accessories</h2>
          </div>
        </div>

        <?php foreach ($accessoryLine as $row) : ?>
          <div class="row justify-content-center">
            <div class="col-md-12 my-2">      
              <span class="float-left mr-3" onClick="document.location.href='accessory-details.php?id=<?= $row['Id']; ?>';" style="cursor: pointer;">
                <img class="img-fluid thumbnail-sm" src="<?= $row['ImgURL']; ?>">
              </span>
              
              <span class="d-block">
                  <div><?= $row['Model']; ?></div>
                  <div><?= $row['Manufacturer']; ?></div>
                  <div><?= "$" . number_format($row['Price'], 2); ?></div>
                  <div>
                    <a class="btn btn-secondary btn-small text-light mr-2" href="edit-job.php?id=<?php echo $row['Id']; ?>"><i class="mdi mdi-small mdi-square-edit-outline"></i></a>
                    <a class="btn btn-primary btn-small text-light" href="delete-accessory.php?id=<?php echo $row['Id']; ?>"><i class="mdi mdi-small mdi-trash-can-outline"></i></a>
                  </div>
              </span>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

    </div>
  </div>
</div>




<?php if ($maintenanceLine) : ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 text-center mt-5">
        <h2 >Maintenance Activity</h2>
      </div>
    </div>

    <?php foreach ($maintenanceLine as $row) : ?>
      <div class="row justify-content-center my-1">
        <div class="col-8 col-md-5 shaded-row">
          <i class="bi bi-eyedropper mr-2"></i><?= substr($row['Date'], 0, 10); ?>
        </div>
        <div class="col-3 col-md-2 shaded-row">
          <?= $row['MaintenanceType']; ?>
        </div>
        <div class="col-1 col-md-1 shaded-row text-right">
          <a class="" id="myBtn" href="delete-maintenance.php?id=<?php echo $row['Id']; ?>"><i class="mdi mdi-small mdi-trash-can-outline text-danger"></i></a>
        </div>
      </div>
    <?php endforeach; ?> 
  </div>
<?php endif; ?>



<?php if ($malfunctionLine) : ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 text-center mt-5">
        <h2 >Malfunctions</h2>
      </div>
    </div>

    <?php foreach ($malfunctionLine as $row) : ?>
      <div class="row justify-content-center my-1">
        <div class="col-8 col-md-5 shaded-row">
          <i class="bi bi-eyedropper mr-2"></i><?= substr($row['MalfunctionDate'], 0, 10); ?>
        </div>
        <div class="col-3 col-md-2 shaded-row">
          <?= $row['MalfunctionType']; ?>
        </div>
        <div class="col-1 col-md-1 shaded-row text-right">
          <a class="" id="myBtn" href="delete-malfunction.php?id=<?php echo $row['Id']; ?>"><i class="mdi mdi-small mdi-trash-can-outline text-danger"></i></a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

  
  <!-- <p class="my-0"> </p>
  <p class="mt-0"> </p>
  <p><label for="description" class="col-form-label text-left font-weight-bold display-6">Job Description:</label></p>
  <p><?php echo strip_tags(htmlspecialchars_decode($result['Description']), '<strong><b><em><ul><ol><li><p><h1><h2><h3><h4><h5><h6>'); ?></p>
</div> -->

<script>
$(document).ready(function(){
  $("#myBtn").click(function(){
    $('.toast').toast('show');
  });
});
</script>


<?php
  include_once('footer.php');
?>