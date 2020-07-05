<?php
class MyConfig
{
    public static function read($filename)
    {
        $config = include $filename;
        return $config;
    }
    public static function write($filename, array $config)
    {
        $config = var_export($config, true);
        file_put_contents($filename, "<?php return $config ;");
    }
}
$url = "http://localhost:6006";
?>
            <div class="card">
                <div class="card-header card-header-warning">
                  <h4 class="card-title ">Log Report Tensorboard</h4>
                  <p class="card-category">Log file training dengan tensorboard
                    <a target="_blank" href="<?php echo $url ?>">detail</a>
                  </p>
                </div>
                <div class="card-body">
                <a href="index.php?menu=log" class="btn btn-primary" type="button">
                View Log TensorBoard
                </a>
                <a href="index.php?menu=log&service=start" class="btn btn-success" type="button">
                START Service TensorBoard
                </a>
                <a href="index.php?menu=log&service=stop" class="btn btn-danger" type="button">
                STOP Service TensorBoard
                </a><br><br>
                <?php
                $ini_array = parse_ini_file("setting-model.txt");
                    if(isset($_GET['service'])){
                      if($_GET['service'] == "start"){
                        @$fp = fsockopen('localhost', 6006, $errno, $errstr, 50);
                          if (!$fp) {
                            ob_end_flush();
                            ini_set("output_buffering", "0");
                            ob_implicit_flush(true);
                            chdir($dirfull);
                            $output1 = "<pre>".shell_exec("sh ./bash-log.sh ".$ini_array['tensorboard']."> /dev/null 2>&1 &")."</pre>";
                            sleep(3);
                            echo "<h4>Sukses Start Service!</h4>";
                          } else {
                            echo "<h4>Port Sudah Running!</h4>";
                            fclose($fp);
                          }
                      }elseif($_GET['service'] == "stop"){
                          ob_end_flush();
                          ini_set("output_buffering", "0");
                          ob_implicit_flush(true);
                          chdir($dirfull);
                          $output2 = "<pre>".shell_exec("kill -9 `lsof -i:6006 -t`")."</pre>";
                          echo "<h4>Sukses Kill Process</h4>";
                      }
                    }else{
                      @$fp = fsockopen('localhost', 6006, $errno, $errstr, 50);
                      if (!$fp) {
                          echo "<h4>Port belum aktif, Start service TensorBoard terlebih dahulu</h4>";
                      } else {
                          fclose($fp);
                          ?>
                              <div class="iframe-container d-none d-lg-block">
                                        <iframe src="<?php echo $url ?>"style="height:600px">
                                            <p>Your browser does not support iframes.</p>
                                        </iframe>
                                    </div>
                                    <div
                                        class="col-md-12 d-none d-sm-block d-md-block d-lg-none d-block d-sm-none text-center ml-auto mr-auto">
                                        <h5>lihat detail
                                            <a href="<?php echo $url ?>" target="_blank">TensorBoard Report</a>
                                        </h5>
                                    </div>
                            </div>
                          <?php
                      }
                    }
                ?>
              </div>