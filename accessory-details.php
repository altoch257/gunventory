<?php
  $title = "Firearm Details";

  include_once('header.php');

  require_once 'includes/dbh.inc.php';

  // Get details for one firearm
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sqlStr = "SELECT
                acc.Id,
                acc.Manufacturer,
                acc.Model,
                acc.PurchaseDate,
                acc.Price,
                acc.Details,
                acc.ImgURL
              FROM accessories acc
              INNER JOIN firearms f
                ON f.Id = acc.FirearmId
              WHERE acc.Id = :id LIMIT 1;";
    
    $stmt = $db->prepare($sqlStr);
    $stmt->execute([':id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Save some values in a variable so they can be used in other queries
    $fId = $result['Id'];
    // ----------------------------------------------

    
  }
  else {
    echo '<h1>Oops. An exception occurred while trying to open the requested firearm. Please check your request and try again.</h1>';
  }

?>
  
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 text-center my-4">
      <h2 >Accessory Details</h2>
    </div>
  </div>
  
  <div class="row justify-content-center">
    <div class="col-md-8">
      
      
      <span class="float-left mr-3">
        <img src="<?= $result['ImgURL']; ?>" style="max-width: 9rem; max-height: 9rem;">
      </span>
      
      <span class="d-block">
        <div class="h3 d-block mb-2"><?= $result['Model']; ?></div>
        <div><?= $result['Manufacturer']; ?></div>
      </span>
    </div>
  </div>

  <div class="row justify-content-center mt-3">
    <div class="col-md-8">
      <span class="float-left">
        <a class="btn btn-primary btn-small text-light mr-2" href="edit-accessory.php?id=<?php echo $result['Id']; ?>"><i class="mdi mdi-small mdi-square-edit-outline"></i></a>
      </span>
      <span class="float-right">
        <a class="btn btn-primary btn-small text-light" href="delete-accessory.php?id=<?php echo $result['Id']; ?>"><i class="mdi mdi-small mdi-trash-can-outline"></i></a>
      </span>
    </div>
  </div>

  <!-- Stats / Details -->
  <div class="row justify-content-center">
    <div class="col-md-8 text-center mt-5">
      <h2>Stats / Details</h2>
    </div>
  </div>

  <div class="row justify-content-center my-1">
    <div class="col-9 col-md-5 shaded-row">
      Purchase Date: 
    </div>
    <div class="col-3 col-md-3 shaded-row">
      <?= substr($result['PurchaseDate'], 0, 10); ?>
    </div>
  </div>

  <div class="row justify-content-center my-1">
    <div class="col-9 col-md-5 shaded-row">
      Purchase Price: 
    </div>
    <div class="col-3 col-md-3 shaded-row">
      <?= "$" . number_format($result['Price'], 2); ?>
    </div>
  </div>

  <?php if (!empty($result['Details'])) : ?>
    <div class="row justify-content-center my-1">
      <div class="col-12 col-md-2 shaded-row">
        Details:
      </div>
      <div class="col-12 col-md-6 shaded-row">
        <?= $details; ?>
      </div>
    </div>
  <?php endif; ?>
    <div class="mb-5"></div>

  
  <!-- <p class="my-0"> </p>
  <p class="mt-0"> </p>
  <p><label for="description" class="col-form-label text-left font-weight-bold display-6">Job Description:</label></p>
  <p><?php echo strip_tags(htmlspecialchars_decode($result['Details']), '<strong><b><em><ul><ol><li><p><h1><h2><h3><h4><h5><h6>'); ?></p>
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