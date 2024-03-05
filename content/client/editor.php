<div class="container-fluid Signup">
  <div class="col-md-6 offset-md-3">
    <br>
  </div>
  <div class="row">

    <div id="navigation-bar" class="col">

    </div>

    <div class="col-md-6">
    <div id="noteNameSpace">
    </div>



    <div id="editor-bar">
      <div class="col-md-6 offset-md-3">

        <?php
        require("editor_page_logic.php");
        startPage();
        ?>
        </div>
    </div>
    </div>

    <div id="info-bar" class="col-md-3">
      <div class="d-flex flex-column vh-100">
        <div class="flex-fill">

          Note information

          </div>
        <div class="flex-fill">
          <div class="container">
            <div id="calendar">
            </div>
              <?php
              for ($i=1;$i<10;$i++){
                  //echo "<span id='lt$i'>utilisateur $i <button id='t$i' class='test'>supprimer</button><br><br></span>";
              }
              ?>
            <div id="reponse">
            </div>
          </div>


        </div>
      </div>

  </div>
 </div>
</div>