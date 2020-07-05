<?php
$dataset = 'trainhijab';
if(isset($_GET['dataset'])){
    if($_GET['dataset'] != ""){
        $dataset = $_GET['dataset'];
    }
}
?>
<div class="card">
    <div class="card-header card-header-tabs card-header-warning">
        <div class="nav-tabs-navigation">
            <div class="nav-tabs-wrapper">
                <span class="nav-tabs-title">Dataset : </span>
                <ul class="nav nav-tabs" data-tabs="tabs">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($dataset == "trainhijab" ? "active" : ""); ?>" href="<?php echo "index.php?menu=dataset&dataset=trainhijab&page=1&perpage=$perpages"; ?>">
                            <i class="material-icons">library_books</i> Training Hijab
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($dataset == "trainnonhijab" ? "active" : ""); ?>" href="<?php echo "index.php?menu=dataset&dataset=trainnonhijab&page=1&perpage=$perpages"; ?>">
                            <i class="material-icons">library_books</i> Training Non Hijab
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($dataset == "testhijab" ? "active" : ""); ?>" href="<?php echo "index.php?menu=dataset&dataset=testhijab&page=1&perpage=$perpages"; ?>">
                            <i class="material-icons">library_books</i> Validasi Hijab
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($dataset == "testnonhijab" ? "active" : ""); ?>" href="<?php echo "index.php?menu=dataset&dataset=testnonhijab&page=1&perpage=$perpages"; ?>">
                            <i class="material-icons">library_books</i> Validasi Non Hijab
                            <div class="ripple-container"></div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card-body">
    <div class="row">

        <?php
        $datasetdir = 'dataset/train/hijab';
        if($dataset == "trainnonhijab"){
            $datasetdir = 'dataset/train/nonhijab';
        }elseif($dataset == "testhijab"){
            $datasetdir = 'dataset/val/hijab';
        }elseif($dataset == "testnonhijab"){
            $datasetdir = 'dataset/val/nonhijab';
        }else{
            $datasetdir = 'dataset/train/hijab';
        }
        $data = getDirContents($datasetdir);
        $total = count($data);
        $totalpage = ceil($total/$perpages);
        $files = getPages($pages, $perpages, $data);
        if($dataset == "trainnonhijab"){
            echo '<div class="container">
            <a target="_blank" href="filemanager2/dialog.php?type=1&popup=1" class="btn btn-primary" type="button">';
            echo "Upload Data Training Non Hijab";
        }elseif($dataset == "testhijab"){
            echo '<div class="container">
            <a target="_blank" href="filemanager3/dialog.php?type=1&popup=1" class="btn btn-primary" type="button">';
            echo "Upload Data Validasi Hijab";
        }elseif($dataset == "testnonhijab"){
            echo '<div class="container">
            <a target="_blank" href="filemanager4/dialog.php?type=1&popup=1" class="btn btn-primary" type="button">';
            echo "Upload Data Validasi Non Hijab";
        }else{
            echo '<div class="container">
            <a target="_blank" href="filemanager1/dialog.php?type=1&popup=1" class="btn btn-primary" type="button">';
            echo "Upload Data Training Hijab";
        }
        echo '</a>
        <br><br>
        <div class="row">';
        foreach ($files as $file) {
            $file = str_replace($dirfull,$actual_link,$file);
            echo "<div class='col-sm-2 col-md-1'>";
            echo "<img src='$file' class='img-thumbnail' style='width:100%;'><br><span class='title-imgset'>".basename($file).'</span><br><br>';
            echo "</div>";
        }
        echo '</div></div>';
    ?>
    </div>

    <?php
    // menampilkan link previous
    echo '<nav aria-label="page"><ul class="pagination justify-content-center">';
    if ($pages > 1) {
        echo "<li class='page-item'><a class='page-link text-pages' href='".$_SERVER['PHP_SELF'].'?menu=dataset&dataset='.$dataset.'&page='.($pages - 1).'&perpage='.$perpages."' aria-label='Previous'>Sebelumnya</a></a></li>";
    }else{
        echo '<li class="page-item"><a class="page-link text-pages" aria-disabled="true">Sebelumnya</a></li>';
    }
    $tampilhalaman = null;
    for ($halaman = 1; $halaman <= $totalpage; ++$halaman) {
        if ((($halaman >= $pages - 6) && ($halaman <= $pages + 6)) || ($halaman == 1) || ($halaman == $totalpage)) {
            if (($tampilhalaman == 1) && ($halaman != 2)) {
                echo '<li class="page-item"><a class="page-link text-pages" aria-disabled="true">...</a></li>';
            }
            if (($tampilhalaman != ($totalpage - 1)) && ($halaman == $totalpage)) {
                echo '<li class="page-item"><a class="page-link text-pages" aria-disabled="true">...</a></li>';
            }
            if ($halaman == $pages) {
                echo '<li class="page-item active"><a class="page-link text-pages" href="#">'.$halaman.'</a></li>';
            } else {
                echo "<li class='page-item'><a class='page-link text-pages' href='".$_SERVER['PHP_SELF'].'?menu=dataset&dataset='.$dataset.'&page='.$halaman.'&perpage='.$perpages."'>".$halaman.'</a></li>';
            }
            $tampilhalaman = $halaman;
        }
    }
    if ($pages < $totalpage) {
        echo "<li class='page-item'>
        <a class='page-link text-pages' href='".$_SERVER['PHP_SELF'].'?menu=dataset&dataset='.$dataset.'&page='.($pages + 1).'&perpage='.$perpages."'>Selanjutnya</a>
        </li>";
    } else{
        echo '<li class="page-item"><a class="page-link text-pages" aria-disabled="true">Selanjutnya</a></li>';
    }
    echo '</ul></nav>';
    ?>
    </div>
</div>
