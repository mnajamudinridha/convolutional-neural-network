<?php
$step = 'step1';
if(isset($_GET['step'])){
    if($_GET['step'] != ""){
        $step = $_GET['step'];
    }
}
?>
<div class="card">
    <div class="card-header card-header-tabs card-header-warning">
        <div class="nav-tabs-navigation">
            <div class="nav-tabs-wrapper">
                <span class="nav-tabs-title">Step : </span>
                <ul class="nav nav-tabs" data-tabs="tabs">
                <li class="nav-item">
                        <a class="nav-link <?php echo ($step == "step1" ? "active" : ""); ?>" href="<?php echo "index.php?menu=cnn&step=step1&page=1&perpage=$perpages"; ?>">
                            <i class="material-icons">library_books</i> File PDF
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($step == "step2" ? "active" : ""); ?>" href="<?php echo "index.php?menu=cnn&step=step2&page=1&perpage=$perpages"; ?>">
                            <i class="material-icons">library_books</i> File Image
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($step == "step3" ? "active" : ""); ?>" href="<?php echo "index.php?menu=cnn&step=step3&page=1&perpage=$perpages"; ?>">
                            <i class="material-icons">library_books</i> Generate Faces
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($step == "step4" ? "active" : ""); ?>" href="<?php echo "index.php?menu=cnn&step=step4&page=1&perpage=$perpages"; ?>">
                            <i class="material-icons">library_books</i> Faces Detection
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($step == "step5" ? "active" : ""); ?>" href="<?php echo "index.php?menu=cnn&step=step5&page=1&perpage=$perpages"; ?>">
                            <i class="material-icons">library_books</i> CNN Alexnet Clasification
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php
        if($step == "step1"){
            echo '<a target="_blank" href="filemanager5/dialog.php?type=2&popup=1" class="btn btn-primary" type="button">
            Upload File PDF</a><br><br>';
            echo '<div class="row">';
            $datasetdir = 'files';
            $data = getDirContents($datasetdir);
            foreach ($data as $file) {
                $file = str_replace($dirfull,$actual_link,$file);
                echo "<div class='col-md-6'>
                      <iframe width='100%' height='600px' src='assets/pdf/web/viewer2.html?file=$file'>
                        <p style='font-size: 110%;'>
                        <em>
                        <strong>Error</strong>
                        Browser ini tidak didukung,
                        </em>
                        Download
                        <a target='_blank' href='$file'>majalah.pdf</a>
                        </p>
                      </iframe>
                    </div>";
            }
            echo '</div>';
        }elseif($step == "step2"){
            echo '<a target="_blank" href="filemanager6/dialog.php?type=1&popup=1" class="btn btn-primary" type="button">
            Upload File Image</a><br><br>';
            echo '<div class="row">';
            $datasetdir = 'files-img';
            $data = getDirContents($datasetdir);
            foreach ($data as $file) {
                $file = str_replace($dirfull,$actual_link,$file);
                echo "<div class='col-sm-2 col-md-2'>";
                echo "<img src='$file' class='img-thumbnail' style='width:100%;'><br><span class='title-imgset'>".basename($file).'</span><br><br>';
                echo "</div>";
            }
            echo '</div>';
        }elseif($step == "step3"){
            ?>
            <br><br>
            <div class="row">
            <div class="col-md-6">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#">
                    <img class="img" src="assets/pdf.jpg">
                  </a>
                </div>
                <div class="card-body">
                  <h6 class="card-category text-gray">Process CNN Alexnet</h6>
                  <h4 class="card-title">Get Face From PDF</h4>
                  <p class="card-description">
                    Face Detection menggunakan<br>OpenCV Haar Cascade Classifiers
                    dari files PDF
                  </p>
                  <a href="index.php?menu=cnn&step=step3&source=pdf" class="btn btn-danger btn-round">Face Detection From PDF</a>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card card-profile">
                <div class="card-avatar">
                  <a href="#pablo">
                    <img class="img" src="assets/jpg.jpg">
                  </a>
                </div>
                <div class="card-body">
                  <h6 class="card-category text-gray">Process CNN Alexnet</h6>
                  <h4 class="card-title">Get Face From JPG/PNG</h4>
                  <p class="card-description">
                  Face Detection menggunakan<br>OpenCV Haar Cascade Classifiers
                    dari files JPG/PNG
                  </p>
                  <a href="index.php?menu=cnn&step=step3&source=jpg" class="btn btn-success btn-round">Face Detection From JPG/PNG</a>
                </div>
              </div>
            </div>
            </div>
            <?php
            if(isset($_GET['source'])){
                if($_GET['source'] == "pdf"){
                    ob_end_flush();
                    ini_set("output_buffering", "0");
                    ob_implicit_flush(true);
                    chdir($dirfull);
                    $output1 = shell_exec("sh ./bash-haar-pdf.sh > /dev/null 2>&1 &");
                    echo '<div class="card card-profile"><div class="card-body">';
                    echo '<h3 class="text-warning">Generate Face From PDF</h3>';
                    echo "<div class='form-group purple-border'>
                    <textarea id='file_content_pdf' class='form-control' rows='15' style='text-align:center' readonly></textarea></div>";
                    echo '<a href="index.php?menu=cnn&step=step4&page=1&perpage=36" class="btn btn-primary btn-round">Lihat Hasil Face Detection</a>';
                    echo '</div></div>';
                    ?>
                    <script>
                        var time = 0;
                        setInterval(function() {
                            $.ajax({
                                type: "POST",
                                data: {time : time},
                                url: "validate-haar-pdf.php",
                                success: function (data) {
                                    var result = $.parseJSON(data)
                                    if (result.content) {
                                        $('#file_content_pdf').empty().append(result.content);
                                    }
                                    time = result.time;
                                }
                            });
                        }, 1000);
                    </script>
                    <?php
                }elseif($_GET['source'] == "jpg"){
                    ob_end_flush();
                    ini_set("output_buffering", "0");
                    ob_implicit_flush(true);
                    chdir($dirfull);
                    $output1 = shell_exec("sh ./bash-haar-jpg.sh > /dev/null 2>&1 &");
                    echo '<div class="card card-profile"><div class="card-body">';
                    echo '<h3 class="text-warning">Generate Face From JPG/PNG</h3>';
                    echo "<div class='form-group purple-border'>
                    <textarea class='form-control' rows='15' style='text-align:center' id='file_content_jpg' readonly></textarea></div>";
                    echo '<a href="index.php?menu=cnn&step=step4&page=1&perpage=36" class="btn btn-primary btn-round">Lihat Hasil Face Detection</a>';
                    echo '</div></div>';
                    ?>
                    <script>
                        var time = 0;
                        setInterval(function() {
                            $.ajax({
                                type: "POST",
                                data: {time : time},
                                url: "validate-haar-jpg.php",
                                success: function (data) {
                                    var result = $.parseJSON(data)
                                    if (result.content) {
                                        $('#file_content_jpg').empty().append(result.content);
                                    }
                                    time = result.time;
                                }
                            });
                        }, 1000);
                    </script>
                    <?php                    
                }
            }
            ?>
            <?php
        }elseif($step == "step4"){
            echo '<h3 class="text-warning" style="text-align:center">Haar Cascade Classifiers Result</h3><br>';
            echo '<div class="row">';
            $datasetdir = 'images';
            $data = getDirContents($datasetdir);
            foreach ($data as $file) {
                $file = str_replace($dirfull,$actual_link,$file);
                echo "<div class='col-sm-2 col-md-1'>";
                echo "<img src='$file' class='img-thumbnail' style='width:100%;'><br><span class='title-imgset'>".basename($file).'</span><br><br>';
                echo "</div>";
            }
            echo '</div>';
        }elseif($step == "step5"){
            echo '<a href="index.php?menu=cnn&step=step5" class="btn btn-success" type="button">
            Hasil Validasi CNN Alexnet</a>';
            echo '<a href="index.php?menu=cnn&step=step5&process=cnn" class="btn btn-primary" type="button">
            Running Ulang Validasi CNN Alexnet</a>';
            echo '<a href="index.php?menu=cnn&step=step5&process=clear" class="btn btn-danger" type="button">
            Hapus Hasil Validasi CNN Alexnet</a>';
            echo '<a href="#" onclick="print()" class="btn btn-warning" type="button">
            Simpan Katalog PDF</a><br>';
            if(isset($_GET['process'])){
                if($_GET['process'] == "cnn"){
                    ob_end_flush();
                    ini_set("output_buffering", "0");
                    ob_implicit_flush(true);
                    chdir($dirfull);
                    $output1 = shell_exec("sh ./bash-alexnet.sh > /dev/null 2>&1 &");
                    echo '<div class="card card-profile"><div class="card-body">';
                    echo '<h3 class="text-warning" style="text-align:center">CNN Alexnet Clasification</h3>';
                    echo "<div class='form-group purple-border'><textarea id='file_content_alexnet' class='form-control' rows='15' style='text-align:center' readonly></textarea></div>";
                    echo '</div></div>';
                    ?>
                    <script>
                        var time = 0;
                        setInterval(function() {
                            $.ajax({
                                type: "POST",
                                data: {time : time},
                                url: "validate-alexnet.php",
                                success: function (data) {
                                    var result = $.parseJSON(data)
                                    if (result.content) {
                                        $('#file_content_alexnet').empty().append(result.content);
                                    }
                                    time = result.time;
                                }
                            });
                        }, 1000);
                    </script>
                    <?php
                }elseif($_GET['process'] == "clear"){
                    ob_end_flush();
                    ini_set("output_buffering", "0");
                    ob_implicit_flush(true);
                    echo '<div class="card card-profile"><div class="card-body">';
                    echo '<h3 class="text-warning">Clear Last Result</h3>';
                    chdir($dirfull);
                    $output1 = shell_exec("/bin/rm output/*hijab/*");
                            echo '<div class="row">';

                            $datasetdir = 'output/hijab';
                            $data = getDirContents($datasetdir);
                            $total = count($data);
                            echo '<div class="col-md-6">
                                <div class="card card-profile">
                                <div class="card-body">
                                <h3 class="text-warning">Hasil CNN : Hijab '.$total.' Foto</h3>';
                                echo '<div class="row">';
                                foreach ($data as $file) {
                                    $file = str_replace($dirfull,$actual_link,$file);
                                    $persen = str_replace(".jpg","",str_replace('-','',strstr(basename($file), "-")));
                                    echo "<div class='col-sm-4 col-md-2'>";
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
                            echo '<div class="col-md-6">
                                <div class="card card-profile">
                                <div class="card-body">
                                <h3 class="text-warning">Hasil CNN : Non Hijab '.$total.' Foto</h3>';
                                echo '<div class="row">';
                                foreach ($data as $file) {
                                    $file = str_replace($dirfull,$actual_link,$file);
                                    $persen = str_replace(".jpg","",str_replace('-','',strstr(basename($file), "-")));
                                    echo "<div class='col-sm-4 col-md-2'>";
                                    echo "<img src='$file' class='img-thumbnail' style='width:100%;'><br>
                                            <span class='title-imgset'>".
                                            number_format((float)$persen, 4, '.', '').
                                            '</span><br><br>';
                                    echo "</div>";
                                }
                                echo '</div>';
                            echo '</div></div></div>';
                            echo '</div>';
                    echo '</div></div>';
                    }
            }else{
                echo '<div class="row">';

                $datasetdir = 'output/hijab';
                $data = getDirContents($datasetdir);
                $total = count($data);
                echo '<div class="col-md-6">
                      <div class="card card-profile">
                      <div class="card-body">
                      <h3 class="text-warning">Hasil CNN : Hijab '.$total.' Foto</h3>';
                      //untuk print
                      echo '<div id="printarea" style="display:none;">';
                      echo '<table width="100%" style="padding:20px"><tr>';
                      $nn = 1;
                      foreach ($data as $file) {
                        $file = str_replace($dirfull,$actual_link,$file);
                        $persens = str_replace(".jpg","",str_replace('-','',strstr(basename($file), "-")));
                        echo "<td style='padding:5px'>";
                        echo "<img src='$file' style='width:100%'>";
                        echo "</td>";
                        if($nn % 2 == 0){
                            echo "</tr><tr>";
                        }
                        $nn++;
                      }
                      echo '</tr></table>';
                      echo '</div>';
                      //end untuk print
                      echo '<div class="row">';
                      foreach ($data as $file) {
                          $file = str_replace($dirfull,$actual_link,$file);
                          $persen = str_replace(".jpg","",str_replace('-','',strstr(basename($file), "-")));
                          echo "<div class='col-sm-4 col-md-2'>";
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
                echo '<div class="col-md-6">
                      <div class="card card-profile">
                      <div class="card-body">
                      <h3 class="text-warning">Hasil CNN : Non Hijab '.$total.' Foto</h3>';
                      echo '<div class="row">';
                      foreach ($data as $file) {
                          $file = str_replace($dirfull,$actual_link,$file);
                          $persen = str_replace(".jpg","",str_replace('-','',strstr(basename($file), "-")));
                          echo "<div class='col-sm-4 col-md-2'>";
                          echo "<img src='$file' class='img-thumbnail' style='width:100%;'><br>
                                <span class='title-imgset'>".
                                number_format((float)$persen, 4, '.', '').
                                '</span><br><br>';
                          echo "</div>";
                      }
                      echo '</div>';
                echo '</div></div></div>';
                echo '</div>';
            }
        }
        ?>
    </div>
</div>