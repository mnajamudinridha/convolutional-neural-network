<div class="container-fluid">
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                  </div>
                  <p class="card-category">Train Hijab</p>
                  <h4 class="card-title">
                    <?php
                    $datasetdir = 'dataset/train/hijab';
                    $data = getDirContents($datasetdir);
                    echo $total = count($data);
                    ?>
                    <small>Foto</small>
                  </h4>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons text-warning">local_offer</i>
                    <a href="index.php?menu=dataset&dataset=trainhijab&page=1&perpage=36">Lihat Data Training Hijab >></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                  </div>
                  <p class="card-category">Train Non Hijab</p>
                  <h4 class="card-title">
                    <?php
                    $datasetdir = 'dataset/train/nonhijab';
                    $data = getDirContents($datasetdir);
                    echo $total = count($data);
                    ?>
                  <small>Foto</small>
                  </h4>
                </div>
                <div class="card-footer">
                  <div class="stats">
                  <i class="material-icons text-success">local_offer</i>
                    <a href="index.php?menu=dataset&dataset=trainnonhijab&page=1&perpage=36">Lihat Data Training Non Hijab >></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                  </div>
                  <p class="card-category">Val Hijab</p>
                  <h4 class="card-title">
                    <?php
                    $datasetdir = 'dataset/val/hijab';
                    $data = getDirContents($datasetdir);
                    echo $total = count($data);
                    ?>
                  <small>Foto</small>
                  </h4>
                </div>
                <div class="card-footer">
                  <div class="stats">
                  <i class="material-icons text-danger">local_offer</i>
                    <a href="index.php?menu=dataset&dataset=testhijab&page=1&perpage=36">Lihat Data Validasi Hijab >></a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                  <i class="material-icons">content_copy</i>
                  </div>
                  <p class="card-category">Val Non Hijab</p>
                  <h4 class="card-title">
                    <?php
                    $datasetdir = 'dataset/val/nonhijab';
                    $data = getDirContents($datasetdir);
                    echo $total = count($data);
                    ?>
                  <small>Foto</small>
                  </h4>
                </div>
                <div class="card-footer">
                  <div class="stats">
                  <i class="material-icons text-info">local_offer</i>
                    <a href="index.php?menu=dataset&dataset=trainnonhijab&page=1&perpage=36">Lihat Data Validasi Non Hijab >></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
            echo '<div class="row">';

            $datasetdir = 'output/hijab';
            $data = getDirContents($datasetdir);
            $total = count($data);
            echo '<div class="col-md-12">
                  <div class="card card-profile">
                  <div class="card-body">
                  <h3 class="text-warning">Hasil CNN : Hijab '.$total.' Foto</h3>';
                  echo '<div class="row">';
                  foreach ($data as $file) {
                      $file = str_replace($dirfull,$actual_link,$file);
                      $persen = str_replace(".jpg","",str_replace('-','',strstr(basename($file), "-")));
                      echo "<div class='col-sm-2 col-md-1'>";
                      echo "<img src='$file' class='img-thumbnail' style='width:100%;'><br>
                            <span class='title-imgset'>".
                            number_format((float)$persen, 4, '.', '').
                            '</span><br><br>';
                      echo "</div>";
                  }
                  echo '</div>';
            echo '</div></div></div>';

            $datasetdir = 'output/non hijab';
            $data = getDirContents($datasetdir);
            $total = count($data);
            echo '<div class="col-md-12">
                  <div class="card card-profile">
                  <div class="card-body">
                  <h3 class="text-warning">Hasil CNN : Non Hijab '.$total.' Foto</h3>';
                  echo '<div class="row">';
                  foreach ($data as $file) {
                      $file = str_replace($dirfull,$actual_link,$file);
                      $persen = str_replace(".jpg","",str_replace('-','',strstr(basename($file), "-")));
                      echo "<div class='col-sm-2 col-md-1'>";
                      echo "<img src='$file' class='img-thumbnail' style='width:100%;'><br>
                            <span class='title-imgset'>".
                            number_format((float)$persen, 4, '.', '').
                            '</span><br><br>';
                      echo "</div>";
                  }
                  echo '</div>';
            echo '</div></div></div>';
            echo '</div>';
            
          ?>
        </div>