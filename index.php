<?php
  $title = "Inventory";

  include_once('header.php');

  require_once('includes/dbh.inc.php');
                                                  
  if (!isset($_SESSION['user'])) {
    echo "<script>window.location = 'login.php';</script>";
  }

  $sqlStr = "SELECT 
                c.Caliber,
                f.Id,
                f.Status, 
                f.Manufacturer, 
                f.Model, 
                f.Serial, 
                f.PurchaseDate,
                f.Price,
                f.Notes,
                f.ImgURL,
                f.sTimestamp,
                g.GunType,
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
                  ORDER BY Date DESC LIMIT 1) AS LastMaintenance
              FROM Firearms f
              INNER JOIN GunTypes g
                ON g.Id = f.GunTypeId
              INNER JOIN Calibers c
                ON c.Id = f.CaliberId
              WHERE f.Status = 'A';";
  $stmt = $db->prepare($sqlStr);
  $stmt->execute();
  $result = $stmt->fetchAll();
?>
    
<div class="container">
  <div class="row mt-5">
    <div class="col-sm-12">
      <h2 class="display-6 text-center">Inventory</h2>
      <table class="table table-dark table-hover" id="job-table">
          
        <tbody>
          <?php
          if ($result) {
              foreach ($result as $row) {
          ?>
            <tr>
              <td onClick="document.location.href='firearm-details.php?id=<?= $row['Id']; ?>';" colspan="4" style="cursor: pointer;">
                <span class="float-left mr-3">
                  <img class="thumbnail" src="<?= $row['ImgURL']; ?>">
                </span>
                <span class="">
                  <div class="h3 d-block mb-0"><?= $row['Model']; ?></div>
                  <div><?= $row['Manufacturer']; ?></div>
                  <div><?= $row['Caliber']; ?></div>
                  <div><i class="mr-3 bi bi-calendar"></i><?= substr($row['PurchaseDate'], 0, 10); ?></div>
                  
                  <?php
                    if (!empty($row['LastShootingActivity'])) :
                  ?>
                  <div><i class="mr-3 bi bi-bullseye"></i><?= substr($row['LastShootingActivity'], 0, 10); ?></div>
                  <?php
                    endif;
                  ?>
                  
                  <?php
                    if (!empty($row['LastShootingActivity'])) :
                  ?>
                  <div><i class="mr-3 bi bi-eyedropper"></i><?= substr($row['LastMaintenance'], 0, 10); ?></div>
                  <?php
                    endif;
                  ?>
                    
                  </span>
              </td>
          <!-- <?php if (isset($_SESSION['user']) && ($_SESSION['user']['roleId'] == 1 || $_SESSION['user']['roleId'] == 2)): ?> -->
                  
                <!-- <td>
                  <a class="btn btn-primary btn-small text-light mr-2" href="edit-job.php?id=<?php echo $row['Id']; ?>"><i class="mdi mdi-small mdi-square-edit-outline"></i></a>
                  <a class="btn btn-danger btn-small text-light" href="delete-job.php?id=<?php echo $row['Id']; ?>"><i class="mdi mdi-small mdi-trash-can-outline"></i></a>
                </td>     -->
          <!--<?php endif; ?>-->
            </tr>
          <?php
            }
          } else {
            echo '<tr><td colspan="4" class="text-center text-white">No inventory found.</td></tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php
  include_once('footer.php');
?>
