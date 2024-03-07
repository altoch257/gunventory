<?php
  $title = "Add Firearm";
  
  include_once('header.php');

  require_once('includes/dbh.inc.php');

  include 'includes/add-firearm.inc.php';

  if (!isset($_SESSION['user'])) {
    echo "<script>window.location = 'login.php';</script>";
  }

  $msgClass = 'errordiv';
?>

<div class="container">

  <div class="form-group row justify-content-center">
    <div class="col-sm-10 col-md-8 col-lg-6">
      <p class="display-6 mt-5 mb-0">Add Firearm</p>
      <p class="mt-0"><hr/></p>
    </div>
  </div>
    
  <form method="post" class="form" enctype="multipart/form-data">

    <div class="form-group row justify-content-md-center">
      <div class="col-sm-10 col-md-8 col-lg-7">
        <input type="text" class="form-control floating_input" name="manufacturer" id="manufacturer" autocomplete="off" tabindex="1" placeholder="Manufacturer" value="<?php echo !empty($postData['manufacturer']) ? $postData['manufacturer'] : ''; ?>" autofocus>
        <label for="manufacturer" class="floating_label" data-content="Manufacturer *">
        <span class="hidden--visually">Manufacturer</span></label>
      </div>
      <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
        <?php
          if (isset($statusMsgs[0])) {
            foreach ($statusMsgs[0] as $manufacturerErrors) {
              echo "<div><p class='small text-danger ml-4 mb-0'>" . $manufacturerErrors . "</p></div>";
            }
          }
        ?>
      </div>

      <div class="col-sm-10 col-md-8 col-lg-7">
        <input type="text" class="form-control floating_input" name="model" id="model" autocomplete="off" tabindex="2" placeholder="Model" value="<?php echo !empty($postData['model']) ? $postData['model'] : ''; ?>" autofocus>
        <label for="model" class="floating_label" data-content="Model *">
        <span class="hidden--visually">Model</span></label>
      </div>
      <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
        <?php
          if (isset($statusMsgs[1])) {
            foreach ($statusMsgs[1] as $modelErrors) {
              echo "<div><p class='small text-danger ml-4 mb-0'>" . $modelErrors . "</p></div>";
            }
          }
        ?>
      </div>

      <div class="col-sm-10 col-md-8 col-lg-7">
        <select class="form-control form-control-2" name="gunType" id="gunType" tabindex="3">
          <option>[Select Gun Type] *</option>
          <!-- Fetch Gun Types from DB -->
          <?php
            $sqlSelect = $db->prepare("SELECT * FROM GunTypes WHERE Status = 'A';");
            $sqlSelect->execute();

            while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
              echo "<option value='" . $row['Id'] ."'>" . $row['GunType'] . "</option>";
            }
          ?>
        </select>
      </div>
      <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
        <?php
          if (isset($statusMsgs[2])) {
            foreach ($statusMsgs[2] as $gunTypeErrors) {
              echo "<div><p class='small text-danger ml-4 mb-0'>" . $gunTypeErrors . "</p></div>";
            }
          }
        ?>
      </div>

      <div class="col-sm-10 col-md-8 col-lg-7">
        <select class="form-control form-control-2" name="caliber" id="caliber" tabindex="4">
          <option>[Select Caliber] *</option>
          <!-- Fetch Calibers from DB -->
          <?php
            $sqlSelect = $db->prepare("SELECT * FROM Calibers WHERE Status = 'A';");
            $sqlSelect->execute();

            while ($row = $sqlSelect->fetch(PDO::FETCH_ASSOC)) {
              echo "<option value='" . $row['Id'] ."'>" . $row['Caliber'] . "</option>";
            }
          ?>
        </select>
      </div>
      <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
        <?php
          if (isset($statusMsgs[3])) {
            foreach ($statusMsgs[3] as $caliberErrors) {
              echo "<div><p class='small text-danger ml-4 mb-0'>" . $caliberErrors . "</p></div>";
            }
          }
        ?>
      </div>

      <div class="col-sm-10 col-md-8 col-lg-7">
        <input type="text" class="form-control floating_input" name="serial" id="serial" autocomplete="off" tabindex="5" placeholder="serial" value="<?php echo !empty($postData['serial']) ? $postData['serial'] : ''; ?>">
        <label for="serial" class="floating_label" data-content="Serial No. *">
        <span class="hidden--visually">Serial</span></label>
      </div>
      <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
        <?php
          if (isset($statusMsgs[4])) {
            foreach ($statusMsgs[4] as $serialErrors) {
              echo "<div><p class='small text-danger ml-4 mb-0'>" . $serialErrors . "</p></div>";
            }
          }
        ?>
      </div>

      <div class="col-sm-10 col-md-8 col-lg-7">
        <input type="date" class="form-control floating_input" name="purchaseDate" id="purchaseDate" autocomplete="off" tabindex="6" placeholder="PurchaseDate" value="<?php echo !empty($postData['purchaseDate']) ? $postData['purchaseDate'] : ''; ?>">
        <label for="purchaseDate" class="floating_label" data-content="Purchase Date *">
        <span class="hidden--visually">purchaseDate</span></label>
      </div>
      <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
        <?php
          if (isset($statusMsgs[5])) {
            foreach ($statusMsgs[5] as $purchaseDateErrors) {
              echo "<div><p class='small text-danger ml-4 mb-0'>" . $purchaseDateErrors . "</p></div>";
            }
          }
        ?>
      </div>

      <div class="col-sm-10 col-md-8 col-lg-7 pb-0">
        <input type="text" class="form-control floating_input" name="price" id="price" autocomplete="off" tabindex="7" placeholder="Price" value="<?php echo !empty($postData['price']) ? $postData['price'] : ''; ?>">
        <label for="price" class="floating_label" data-content="Price">
        <span class="hidden--visually">Price</span></label>
      </div>
      <div class="col-sm-10 col-md-8 col-lg-7 pb-3">
        <?php
          if (isset($statusMsgs[6])) {
            foreach ($statusMsgs[6] as $priceErrors) {
              echo "<div><p class='small text-danger ml-4 mb-0'>" . $priceErrors . "</p></div>";
            }
          }
        ?>
      </div>

      <div class="col-sm-10 col-md-8 col-lg-7 pb-0">
        <textarea class="form-control form-control-2" name="notes" id="tiny" cols="30" rows="8" tabindex="7" placeholder="Notes *" value="<?php echo !empty($postData['notes']) ? $postData['notes'] : ''; ?>"></textarea>
      </div>

      <div class="col-sm-10 col-md-8 col-lg-7 pt-3">
        <input type="file" class="form-control floating_input pt-3 pb-5" name="image" id="image" tabindex="8">
      </div>

      <div class="col-sm-10 col-md-8 col-lg-7 pt-3">
        <input type="file" class="form-control floating_input pt-3 pb-5" name="document" id="document" tabindex="9">
      </div>
    </div>
          
    <!-- Display submission status -->
    <div class="status">
      <?php if (!empty($pdoError)) { ?>
        <div class="form-group row justify-content-center statusMsg <?php echo !empty($msgClass) ? $msgClass : ''; ?>">
          <div class="col-sm-10 col-md-8 col-lg-6">
            <?php echo $pdoError; ?>
          </div>
        </div>
      <?php } ?>
    </div>

    <div class="form-group row justify-content-center">
      <div class="col-sm-10 col-md-8 col-lg-7">
        <button type="submit" name="submit" class="btn btn-primary form-control form-control-2" tabindex="10" >Submit</button>
      </div>
    </div>

  </form>
</div>

<?php
  include_once('footer.php');
?>
    
