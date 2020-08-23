<div class="site-section border-bottom" data-aos="fade">
      <?php
        $query = $conn->query("SELECT *, i.id AS image_id FROM author a INNER JOIN images i ON a.id_image = i.id");
        $author = $query->fetch();
      ?>
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-6">
            <div class="block-16">
              <figure>
                <img src="assets/images/<?=$author->large?>" alt="<?=$author->title?>" class="img-fluid rounded">

              </figure>
            </div>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-5">
            
            <div class="site-section-heading pt-3 mb-4">
              <h2 class="text-black"><?="{$author->first_name}\t{$author->last_name}"?></h2>
            </div>
            <p><?=$author->intro?></p>
            <p><?=$author->description?></p>
            <p><a href="#" class="btn btn-primary btn-sm word-download">Get word document</a></p>
          </div>
        </div>
      </div>
    </div>