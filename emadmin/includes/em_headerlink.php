
          <div class="row head">
		   <div class="col-2 text-center logo">
          <a href="<?=$CFG->wwwroot?>/emadmin/index.php"><?=$CFG->title?></a>
       </div>
       <div class="col-10  headernav">
          <div class="row">
            <div class="col-6">
              <p class="username">Hey！ <?=$_SESSION['admin']['name']; ?>,how are you?</p>
            </div>
            <div class="col-6">
                <div class="row button justify-content-end">
                <?//此功能主管、老闆限定
                  if ($_SESSION['admin']['level'] != 2) {?>
                      <div class="col-auto admin">
                        <a href="<?=$CFG->back_wwwroot?>/admin/admin.php">Admin List</a>
                      </div>
                <?}?>
                  <div class="col-auto logout">
                    <a href="<?=$CFG->back_wwwroot?>/admin_logout.php">loginout</a>
                  </div>
                </div>
            </div>
          </div>
        </div>
		</div>  
   

