<?php if(isset($_SESSION['user'])):?>
  <?php if($_SESSION['user']->role == "administrator"):?>
<div class="site-section">
  <div class="container">
    <div class="col-md-6 mb-3 mb-md-0">
        <a href="#" class="btn btn-primary btn-sm" style="margin-bottom: 20px; margin-top: -50px;">Show users</a>
        <a href="#" class="btn btn-primary btn-sm" style="margin-bottom: 20px; margin-top: -50px;">Show products</a>
    </div>
    <div class="site-blocks-table">
    <h1>Users</h1>
          <table class="table table-bordered">
            <thead>
              <tr>
              <th class="product-name">No.</th>
                <th class="product-name">First name</th>
                <th class="product-name">Last name</th>
                <th class="product-name">Username</th>
                <th class="product-name">E-mail</th>
                <th class="product-name">Role</th>
                <th class="product-name">Activity</th>
                <th class="product-remove" colspan="2">Options</th>
              </tr>
            </thead>
            <tbody>
            <?php
              include "models/admin/users/functions.php";
              
              $users = getUsers();
              $br = 1;
              foreach($users as $user):
            ?>
              <tr>
                <td class="product-thumbnail">
                  <h1><?=$br++;?></h1>
                </td>
                <td class="product-name">
                  <h2 class="h5 text-black"><?=$user->first_name;?></h2>
                </td>
                <td>
                    <h2 class="h5 text-black"><?=$user->last_name;?></h2>
                </td>
                <td>
                    <h2 class="h5 text-black"><?=$user->username;?></h2>
                </td>
                <td><?=$user->email;?></td>
                <td><?=$user->role;?></td>
                <td ><a href="#" class="d-flex color-item align-items-center filter-colors" >
              <span class="bg-<?=$user->is_active?"success":"danger"?> color d-inline-block rounded-circle mr-2"></span> <span class="text-black"><?=$user->is_active?"Online":"Offline"?></span>
            </a></td>
                <td><a href="#" data-id="<?=$user->user_id;?>" class="btn btn-primary btn-sm delete">Delete</a></td>
                <td><a href="#" data-id="<?=$user->user_id;?>" class="btn btn-primary btn-sm update">Update</a></td>
              </tr>
            <?php endforeach;?>
            <tr>
              <td colspan="9"><a class="btn btn-primary btn-sm excel-download" href="#">Download excel table</a></td>
            </tr>
            </tbody>
          </table>
        <div class="col-md-7 admin-form" style="display:none;">
        
        <form action="#" method="POST">
        <span style="float:right;"><a href="#" style="font-size: 36px; padding: 10px;" class="close-form">&times;</a></span>
        <input type="hidden" id="usr_id_hdn" value="">
          <div class="p-3 p-lg-5 border">
            <div class="form-group row">
              <div class="col-md-6">
                <label for="u_fname" class="text-black">First Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="u_fname" name="u_fname">
              </div>
              <div class="col-md-6">
                <label for="u_lname" class="text-black">Last Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="u_lname" name="u_lname">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <label for="u_email" class="text-black">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="u_email" name="u_email" placeholder="">
              </div>
            </div>            
            <div class="form-group row">
              <div class="col-md-12">
                <label for="u_username" class="text-black">Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="u_username" name="u_username">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <label for="u_password" class="text-black">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="u_password" name="u_password">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <label for="u_password_repeat" class="text-black">Repeat Password <span class="text-danger">*</span></label>
                <input type="password" disabled="true" class="form-control" id="u_password_repeat" name="u_password_repeat">
              </div>
            </div>
            <!-- <div class="form-group row">
              <div class="col-md-12">
                <label for="c_message" class="text-black">Message </label>
                <textarea name="c_message" id="c_message" cols="30" rows="7" class="form-control"></textarea>
              </div>
            </div> -->
            <div class="form-group row">
              <div class="col-lg-12">
                <input type="submit" class="btn btn-primary btn-lg btn-block" id="idUpdate" value="Update">
              </div>
            </div>
          </div>
        </form>
      </div>
      <br/> 
        </div>
      <div class="site-blocks-table">
        <h1>Products</h1>
        <table class="table table-bordered">
            <thead>
              <tr>
                <th class="product-name">Image</th>
                <th class="product-name">Title</th>
                <th class="product-name">Description</th>
                <th class="product-name">Color</th>
                <th class="product-name">Price</th>
                <th class="product-remove">Options</th>
              </tr>
            </thead>
            <tbody>
            <?php
            include "models/admin/products/functions.php";
              $products = allProducts();
              foreach($products as $product):
            ?>
              <tr>
                <td class="product-thumbnail">
                  <img src="<?=$product->large?>" alt="<?=$product->title?>" class="img-fluid"/>
                </td>
                <td class="product-name">
                  <h2 class="h5 text-black"><?=$product->title?></h2>
                </td>
                <td>
                    <h3 class="h5 text-black"><?=$product->description?></h3>
                </td>
                <td>
                <a href="#" class="d-flex color-item align-items-center filter-colors" >
              <span class="bg-<?=$product->color_code?> color d-inline-block rounded-circle mr-2"></span> <span class="text-black"><?=$product->title?></span>
            </a>
                </td>
                <td>$<?=$product->price?></td>
                <td><a href="#" data-id="<?=$product->product_id?>" class="btn btn-primary btn-sm dlt-product">Delete</a></td>
              </tr>
            <?php endforeach;?>
            </tbody>
          </table>
        <div class="col-md-7 products-form" >
      </div>
        </div>
    <div>
</div>
  <?php endif;?>
<?php endif;?>