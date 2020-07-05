<?php
$action = null;
$param  = null;
if(isset($_GET['action'])){
    if($_GET['action'] != ""){
        $action = $_GET['action'];
    }
}
?>
<div class="card">
    <div class="card-header card-header-tabs card-header-warning">
        <div class="nav-tabs-navigation">
            <div class="nav-tabs-wrapper">
                <span class="nav-tabs-title">Training : </span>
                <ul class="nav nav-tabs" data-tabs="tabs">
                <li class="nav-item">
                        <a class="nav-link <?php echo ($action == null ? "active" : ""); ?>" href="<?php echo "index.php?menu=learning"; ?>">
                            <i class="material-icons">library_books</i> Configuration
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($action == "view" ? "active" : ""); ?>" href="<?php echo "index.php?menu=learning&action=view"; ?>">
                            <i class="material-icons">library_books</i> Progress Training
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card-body">
    <?php
        if(isset($_GET['action'])){
            if($_GET['action'] == "view"){
                // exec("pgrep -f '/usr/bin/python3 datatraining.py'", $pids);
                exec("pgrep python3", $pids);
                if(empty($pids)) {
                    echo '<div class="row">';
                    echo '<div class="col-md-12">
                    <div class="card card-profile">
                    <div class="card-body">
                    <h3 class="text-warning">Tidak Ada Progress Training</h3>';
                    echo "<div class='form-group purple-border'><textarea id='file_content_training' class='form-control' rows='25' style='text-align:center' readonly></textarea></div>";
                echo '</div></div></div>';
                echo '</div>';            
                }else{
                    echo '<div class="row">';
                    echo '<div class="col-md-12">
                        <div class="card card-profile">
                        <div class="card-body">
                        <h3 class="text-warning">View Progress Training</h3>';
                        echo "<div class='form-group purple-border'><textarea id='file_content_training' class='form-control' rows='25' style='text-align:center' readonly></textarea></div>";
                    echo '</div></div></div>';
                    echo '</div>';                
                    ?>
                        <script>
                            var time = 0;
                            setInterval(function() {
                                $.ajax({
                                    type: "POST",
                                    data: {time : time},
                                    url: "validate-training.php",
                                    success: function (data) {
                                        var result = $.parseJSON(data)
                                        if (result.content) {
                                            $('#file_content_training').empty().append(result.content);
                                        }
                                        time = result.time;
                                    }
                                });
                            }, 1000);
                        </script>
                    <?php
                }
            }
        }else{
            if(isset($_POST['stopprocess'])){
                shell_exec("kill -9 `pgrep -f '/usr/bin/python3 datatraining.py'` > /dev/null 2>&1");
            }
            if(isset($_POST['learning_rate'])){
                //run training with param
                ob_end_flush();
                ini_set("output_buffering", "0");
                ob_implicit_flush(true);
                chdir($dirfull);
                @$learning_rate = $_POST['learning_rate'];
                @$num_epochs = $_POST['num_epochs'];
                @$batch_size = $_POST['batch_size'];
                @$dropout_rate = $_POST['dropout_rate'];
                @$patience = $_POST['patience'];
                $output1 = shell_exec("sh ./bash-training.sh $learning_rate $num_epochs $batch_size $dropout_rate $patience> /dev/null 2>&1 &");
            }
            exec("pgrep python3", $pids);
            if(empty($pids)) {
                echo '<div class="row">';
                echo '<div class="col-md-12">
                    <div class="card card-profile">
                    <div class="card-body">
                    <h3 class="text-warning">Configuration Training</h3>';
                ?>
                    <form action="index.php?menu=learning" method="POST">
                    <div class="form-group">
                        <label class="bmd-label-floating">Learning Rate</label>
                        <input type="text" name="learning_rate"  value="0.0001" class="form-control" placeholder="Learning Rate">
                    </div>
                    <div class="form-group">
                        <label class="bmd-label-floating">Number Epochs</label>
                        <input type="text" name="num_epochs"  value="20" class="form-control" placeholder="Number Epochs">
                    </div>
                    <div class="form-group">
                        <label class="bmd-label-floating">Batch Size</label>
                        <input type="text" name="batch_size"  value="100" class="form-control" placeholder="Batch Size">
                    </div>
                    <div class="form-group">
                        <label class="bmd-label-floating">Dropout Rate</label>
                        <input type="text" name="dropout_rate"  value="0.5" class="form-control" placeholder="Dropout Rate">
                    </div>
                    <div class="form-group">
                        <label class="bmd-label-floating">Earlystop Patience</label>
                        <input type="text" name="patience"  value="25" class="form-control" placeholder="Patience EarlyStop, Empty to Ignore">
                    </div>
                    <button type="submit" class="btn btn-primary">Run Training</button>
                    </form>
                <?php
                echo '</div></div></div>';
                echo '</div>';
            }else{
                echo '<div class="row">';
                echo '<div class="col-md-12">
                    <div class="card card-profile">
                    <div class="card-body">
                    <h3 class="text-warning">Proses Training Sedang Berjalan</h3>
                    <h4>Berikut Process Detail Linux Exec</h4><br>';
                exec("pgrep -f 'python3 datatraining.py'", $test);
                if(!empty($test)){
                    foreach ($test as $a) {
                        exec("ps -p $a", $pids);
                        echo print_r($pids);
                        echo "<br>";
                    } 
                }
                echo '<br>';
                echo '<form action="index.php?menu=learning" method="POST">
                        <input type="hidden" name="stopprocess" value="oke">
                        <a href="index.php?menu=learning&action=view" class="btn btn-success btn-round">Lihat Realtime Output</a>
                        <button type="submit" class="btn btn-danger btn-round">Stop Process Training</button>
                      </form>';
                echo '</div></div></div>';
                echo '</div>';
                
            }
        }
    ?>
    </div>
</div>
