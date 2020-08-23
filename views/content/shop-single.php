<div class="site-section">
  <div class="container">
    <div class="row">
    <?php
      include "models/admin/products/functions.php";
      $product_id = $_GET['id'];
      $product = singleProduct($product_id);
    ?>
      <div class="col-md-6">
        <img src="<?=$product->large?>" alt="<?=$product->title?>" class="img-fluid">
      </div>
      <div class="col-md-6">
        <h2 class="text-black"><?=$product->title?></p>
        <p class="mb-4"><?=$product->description?></p>
        <p><strong class="text-primary h4">$<?=$product->price?></strong></p>
        <div class="mb-1 d-flex">
        <?php
          $sizes = getSizes();
          foreach($sizes as $size):
        ?>
          <label for="option-sm" class="d-flex mr-3 mb-3">
            <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-sm" name="shop-sizes"></span> <span class="d-inline-block text-black"><?=$size->title?></span>
          </label>
          <?php endforeach;?>
        </div>
        <div class="mb-5">
          <div class="input-group mb-3" style="max-width: 120px;">
          <div class="input-group-prepend">
            <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
          </div>
          <input type="text" class="form-control text-center" value="1" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
          <div class="input-group-append">
            <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
          </div>
        </div>

        </div>
        <p><a href="cart.html" class="buy-now btn btn-sm btn-primary">Add To Cart</a></p>

      </div>
    </div>
  </div>
</div>
