<?php
    include "models/admin/products/functions.php";
?>
<div class="site-section">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="h3 mb-3 text-black">Insert Product</h2>
      </div>
      <div class="col-md-7">

        <form id="form" action="" method="POST" enctype="multipart/form-data">
          
          <div class="p-3 p-lg-5 border">
            <div class="form-group row">
              <div class="col-md-6">
                <label for="ip_title" class="text-black">Title</label>
                <input type="text" class="form-control" id="ip_title" name="ip_title">
              </div>
              <div class="col-md-6">
                <label for="ip_description" class="text-black">Description </label>
                <input type="text" class="form-control" id="ip_description" name="ip_description">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <label for="ip_price" class="text-black">Price </label>
                <input type="text" class="form-control" id="ip_price" name="ip_price" placeholder="">
              </div>
            </div>            
            <div class="mb-4">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Gender</h3>
                <?php
                    $genders = getGenders();
                    foreach($genders as $gender):
                ?>
                <label for="g_<?=strtolower($gender->title)?>" class="d-flex">
                    <input type="checkbox" id="g_<?=strtolower($gender->title)?>" class="mr-2 mt-1 genders" value="<?=$gender->id?>" name="chbGenders[]"> <span class="text-black"><?=$gender->title?></span>
                </label>
                    <?php endforeach;?>
            </div>
            <div class="form-group row">
              <div class="col-md-6">
                <label for="ip_color" class="text-black">Color </label>
                <select class="form-control" id="ip_color" name="ip_color">
                <option value="0">Select color</option>
                <?php
                        $colors = getColors();
                        foreach($colors as $color):
                    ?>
                    <option value="<?=$color->id?>"><?=$color->title?></option>
                        <?php endforeach;?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="ip_category" class="text-black">Category </label>
                <select class="form-control" id="ip_category" name="ip_category">
                <option value="0">Select category</option>
                <?php
                        $categories = getCategories();
                        foreach($categories as $category):
                    ?>
                    <option value="<?=$category->id?>"><?=$category->title?></option>
                        <?php endforeach;?>
                </select>
              </div>
            </div>
            <div class="mb-4">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Size</h3>
                <?php
                    $sizes = getSizes();
                    foreach($sizes as $size):
                ?>
                <label for="g_<?=strtolower($size->title)?>" class="d-flex">
                    <input type="checkbox" id="g_<?=strtolower($size->title)?>" class="mr-2 mt-1 sizes" name=chbSizes[] value="<?=$size->id?>"> <span class="text-black"><?=$size->title?></span>
                </label>
                    <?php endforeach;?>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <label for="ip_file" class="text-black">Image</label>
                <input type="file" class="form-control" id="ip_file" name="ip_file">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-lg-12">
                <input type="submit" class="btn btn-primary btn-lg btn-block" id="ip_insert" value="Insert product">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-5 ml-auto" id="errors">
        <!-- <div class="p-4 border mb-3">
          <span class="d-block text-primary h6 text-uppercase">New York</span>
          <p class="mb-0">203 Fake St. Mountain View, San Francisco, California, USA</p>
        </div>
        <div class="p-4 border mb-3">
          <span class="d-block text-primary h6 text-uppercase">London</span>
          <p class="mb-0">203 Fake St. Mountain View, San Francisco, California, USA</p>
        </div>
        <div class="p-4 border mb-3">
          <span class="d-block text-primary h6 text-uppercase">Canada</span>
          <p class="mb-0">203 Fake St. Mountain View, San Francisco, California, USA</p>
        </div>
        <div class="p-4 border mb-3">
          <span class="d-block text-primary h6 text-uppercase">Canada</span>
          <p class="mb-0">203 Fake St. Mountain View, San Francisco, California, USA</p>
        </div>
        <div class="p-4 border mb-3">
          <span class="d-block text-primary h6 text-uppercase">Canada</span>
          <p class="mb-0">203 Fake St. Mountain View, San Francisco, California, USA</p>
        </div> -->
        

      </div>
    </div>
  </div>
</div>