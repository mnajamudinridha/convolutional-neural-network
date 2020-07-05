<div class="sidebar-wrapper">
          <ul class="nav">
            <li class="nav-item <?php echo ($menu == null ? "active" : "");($menu == null ? $title = "Dashboard":"") ?>">
              <a class="nav-link" href="index.php">
                <i class="material-icons">dashboard</i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item <?php echo ($menu == "dataset" ? "active" : "");($menu == "dataset" ? $title = "All Dataset":"") ?>">
              <a class="nav-link" href="index.php?menu=dataset">
                <i class="material-icons">content_paste</i>
                <p>All Dataset</p>
              </a>
            </li>
            <li class="nav-item <?php echo ($menu == "learning" ? "active" : "");($menu == "learning" ? $title = "Learning Model":"") ?>">
              <a class="nav-link" href="index.php?menu=learning">
                <i class="material-icons">bubble_chart</i>
                <p>Learning Model</p>
              </a>
            </li>
            <li class="nav-item <?php echo ($menu == "translearning" ? "active" : "");($menu == "translearning" ? $title = "Use Transfer Learning":"") ?>">
              <a class="nav-link" href="index.php?menu=translearning">
                <i class="material-icons">location_ons</i>
                <p>Transfer Learning</p>
              </a>
            </li>
            <li class="nav-item <?php echo ($menu == "log" ? "active" : "");($menu == "log" ? $title = "Log Learning":"") ?>">
              <a class="nav-link" href="index.php?menu=log">
                <i class="material-icons">library_books</i>
                <p>Log Learning</p>
              </a>
            </li>
            <li class="nav-item <?php echo ($menu == "cnn" ? "active" : "");($menu == "cnn" ? $title = "CNN Alexnet":"") ?>">
              <a class="nav-link" href="index.php?menu=cnn">
                <i class="material-icons">person</i>
                <p>CNN Alexnet</p>
              </a>
            </li>
          </ul>
      </div>