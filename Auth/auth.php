<?php
include("config.php");
?>

<body>
    <header class="p-3 mb-3 border-bottom">
      <div class="container" style="width:100%">
        <div class="d-flex flex-wrap align-items-left justify-content-left justify-content-lg-end">
          <ul class="nav nav-pills bd-highlight flex-grow-1">
            <li class="mr-auto bd-highlight"><a href="index.php" class="nav-link active" aria-current="page">Домашня</a></li>
            <li style="visibility: hidden;">//</li>
            <li class="mr-auto bd-highlight"><a href="admin.php" class="nav-link active" aria-current="page">Адмінка розкладу</a></li>
            <li style="visibility: hidden;">//</li>
            <li class="mr-auto bd-highlight"><a href="tables/teacherTimetable.php" class="nav-link active" aria-current="page">Розклад для вчителів</a></li>
            <li style="visibility: hidden;">//</li>
            <li class="mr-auto bd-highlight"><a href="" class="nav-link active" aria-current="page">Учні</a></li>
          </ul>
          <?php
          if(!empty($resres)) {
              $sql_init = "SELECT * FROM student WHERE s_us_id = '".$_SESSION['us_email']."'";
              $query = $mysqli->query($sql_init);
              $result = $query->fetch_row()[1];
              echo '
          <div class="dropdown text-end">
            <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle show" data-bs-toggle="dropdown" aria-expanded="true">
              <div class="initials-avatar large" 
                style="background: '.getColor($result).';">
                  '.getCapitals($result).'
              </div>
            </a>
            <form method="POST" id="DropDown">
            <ul class="dropdown-menu text-small" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 34px);" data-popper-placement="bottom-start">
              <li><a class="dropdown-item" href="cabinet.php">Мій кабінет</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><button type="submit" name="logout" class="btn btn-outline-primary me-2 mx-2">Вийти</button></li>
            </ul>
            <input type="submit" style="display:none" name="logout" id="logout">
            </form>
          </div>';
          } else {
            echo '<a href="auth/login.php"><button type="button" class="btn btn-outline-primary me-2">Увійти</button></a>';
            echo '<a href="auth/register.php"><button type="button" class="btn btn-primary">Реєстрація</button></a>';
          }
        ?>
        </div>
      </div>
    </header>
    <main>
        <h1>
            <?php
                // if(!empty($resres)) {
                //     echo "<h1>перегляд сторінки за учня</h1>";
                // } else {
                //     echo "<h1>перегляд сторінки за гостя</h1>";
                // }
            ?>
        </h1>
    </main>
    <!-- <script src="js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>             -->
  </body>
</html>