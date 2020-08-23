<body>
  <div class="site-wrap">
    <header class="site-navbar" role="banner">
      <div class="site-navbar-top">
        <div class="container">
          <div class="row align-items-center">

            <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
            <?php
            if(isset($_GET['page'])):
              if($_GET['page'] == 'shop'):
                $limit = isset($_GET['limit']) ? $_GET['limit'] : 0;
          ?>
              <form action="" class="site-block-top-search">
                <input type="hidden" id="limit-hidden" name="limit-hidden" value="<?=$limit?>"/>
                <span class="icon icon-search2"></span>
                <input type="text" id="search-box" class="form-control border-0" placeholder="Search">
              </form>
              <?php endif;?>
            <?php endif;?>
            </div>

            <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
              <div class="site-logo">
                <a href="index.php?page=home" class="js-logo-clone">Shoppers</a>
              </div>
            </div>

            <div class="col-6 col-md-4 order-3 order-md-3 text-right">
              <div class="site-top-icons">
                <ul>
                <?php if(isset($_SESSION['user'])):?>
                  <li><a href="models/users/logout.php">Logout</a></li>
                <?php endif;?>
                  <li><a href="#"><span class="icon icon-person"></span></a></li>
                  <li><a href="#"><span class="icon icon-heart-o"></span></a></li>
                <?php if(isset($_SESSION['user'])):?>
                  <li>
                    <a href="index.php?page=cart" class="site-cart">
                      <span class="icon icon-shopping_cart"></span>
                      <span class="count" id="cart-count"></span>
                    </a>
                  </li>
                <?php endif;?>
                  <li class="d-inline-block d-md-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a></li>
                </ul>
              </div> 
            </div>

          </div>
        </div>
      </div> 
      <nav class="site-navigation text-right text-md-center" role="navigation">
        <div class="container">
          <ul class="site-menu js-clone-nav d-none d-md-block">
            <li class="<?= $_GET['page']=='home'?'active':''?>"><a href="index.php?page=home">Home</a></li>
            <li class="<?= $_GET['page']=='about'?'active':''?>"><a href="index.php?page=about">About</a></li>
            <li class="<?= $_GET['page']=='shop'?'active':''?>"><a href="index.php?page=shop">Shop</a></li>
            <li class="<?= $_GET['page']=='registration'?'active':''?>"><a href="index.php?page=registration">Registration</a></li>
            <li class="<?= $_GET['page']=='author'?'active':''?>"><a href="index.php?page=author">Author</a></li>
            <li><a href="data/documentation.pdf">Documentation</a></li>
            <?php if(isset($_SESSION['user'])):?>
              <?php if($_SESSION['user']->role == "administrator"):?>
                <li class="<?= $_GET['page']=='admin'?'active':''?>"><a href="index.php?page=admin">Admin</a></li>
                <li class="<?= $_GET['page']=='insert-product'?'active':''?>"><a href="index.php?page=insert-product">Insert product</a></li>
              <?php endif;?>
            <?php endif;?>
          </ul>
        </div>
      </nav>
    </header>
    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.php?page=home">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">About</strong></div>
        </div>
      </div>
    </div>  