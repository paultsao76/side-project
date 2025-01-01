	
	 <header class="head">
		  <nav class="navbar navbar-expand-lg navbar-light bg-light">
			  <div class="container-fluid">
			<!-- 首頁標頭區 start -->
			    <a class="navbar-brand" href="<?=$CFG->wwwroot?>/" title="<?=$CFG->title?>"><?=$CFG->title?></a>
			    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			      <span class="navbar-toggler-icon"></span>
			    </button>
			<!-- 首頁標頭區 end -->
			<!-- 分頁導覽區 start -->
			    <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-right: 10px">
			      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
			      	<li class="nav-item">
			          <a class="nav-link active" aria-current="page" href="<?=$CFG->wwwroot?>/about/" title="AboutUs">About Us</a>
			        </li>
			        <li class="nav-item">
			          <a class="nav-link active" aria-current="page" href="<?=$CFG->wwwroot?>/wallarea/" title="Feeling Wall">Feeling Wall</a>
			        </li>
			        <li class="nav-item dropdown">
			          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
			            <?=$CFG->MemberArea?>
			          </a>
			          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
			            <li><a class="dropdown-item" href="<?=$CFG->wwwroot?>/member/">My Area</a></li>
			            <li><a class="dropdown-item" href="<?=$CFG->wwwroot?>/pet/">Pet Area</a></li>
			            <li><a class="dropdown-item" href="<?=$CFG->wwwroot?>/reserve/">Reserve</a></li>
			            <li><a class="dropdown-item" href="<?=$CFG->wwwroot?>/wall/">Share Felling</a></li>
			      	<?if ($_SESSION['member']) {//有登入才顯示?>
			        	<li><hr class="dropdown-divider"></li>
			            <li><a class="dropdown-item" href="<?=$CFG->wwwroot?>/member_logout.php">SignOut</a></li>
			        <?}?>
			            
			          </ul>
			        </li>
			    <!-- 導覽列反灰範例 start-->
			        <!-- <li class="nav-item">
			          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
			        </li> -->
			    <!-- 導覽列反灰範例 end-->
			      </ul>
			    <!-- 導覽列search範例 start-->
			      <!-- <form class="d-flex">
			        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
			        <button class="btn btn-outline-success" type="submit">Search</button>
			      </form> -->
			    <!-- 導覽列search範例 end-->
			    </div>
			<!-- 分頁導覽區 end -->
			  </div>
			</nav>
	 </header>
   