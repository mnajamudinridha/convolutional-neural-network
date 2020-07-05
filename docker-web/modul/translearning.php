<?php
$action = null;
$param  = null;
if(isset($_GET['action'])){
    if($_GET['action'] != ""){
        $action = $_GET['action'];
    }
}
if(isset($_POST['model'])){
    ob_end_flush();
    ini_set("output_buffering", "0");
    ob_implicit_flush(true);
    chdir($dirfull);
    @$model = $_POST['model'];
    @$tensor = $_POST['tensorboard'];
    $output1 = shell_exec("sh ./bash-setting.sh $model $tensor > /dev/null 2>&1 &");
}
?>
            <div class="card">
                <div class="card-header card-header-warning">
                  <h4 class="card-title ">Use Transfer Learning</h4>
                  <p class="card-category">Use Transfer Learning Model From File
                    <a target="_blank" href="<?php echo $url ?>">detail</a>
                  </p>
                </div>
                <div class="card-body">
                <?php
                $ini_array = parse_ini_file("setting-model.txt");
                echo '<div class="row">';
                echo '<div class="col-md-12">
                    <div class="card card-profile">
                    <div class="card-body">
                    <h3 class="text-warning">Use Training Model From File</h3>';
                    if(isset($_POST['model'])){
                        echo '<div class="alert alert-success">
                                <span><b> Success - </b> use selected model and tensorboard</span>
                                </div>';
                    }
                    $ini_array = parse_ini_file("setting-model.txt");

                    $files = array();
                    foreach (glob("model/model-save/*.h5") as $file) {
                    $files[] = $file;
                    }
                    $files2 = array();
                    foreach (glob("model/tensorboard-save/*", GLOB_ONLYDIR) as $file2) {
                    $files2[] = $file2;
                    }
                ?>
                    <form action="index.php?menu=translearning" method="POST">
                    <div class="form-group">
                        <label class="bmd-label-floating">Select Model</label>
                        <select name="model" class="form-control">
                            <?php
                                foreach($files as $value){
                                    $value = str_replace("model/model-save/","",$value);
                                    $value = str_replace(".h5","",$value);
                                    if($value == $ini_array['model']){
                                        echo "<option value='$value' selected>$value</option>";
                                    }else{
                                        echo "<option value='$value'>$value</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="bmd-label-floating">Select Tensorboard</label>
                        <select name="tensorboard" class="form-control">
                            <?php
                                foreach($files2 as $value){
                                    $value = str_replace("model/tensorboard-save/","",$value);
                                    if($value == $ini_array['tensorboard']){
                                        echo "<option value='$value' selected>$value</option>";
                                    }else{
                                        echo "<option value='$value'>$value</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Model & Tensorboard</button>
                    </form>
                <?php
                echo '</div></div></div>';
                echo '</div>';
                ?>
              </div>