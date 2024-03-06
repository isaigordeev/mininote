<div class="container-fluid Signup">
  <div class="col-md-6 offset-md-3">
    <br>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="col-md-8 offset-5">
      <h5>Files</h5>
      </div>

      <div id="navigation-bar">
      </div>
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

    <div class="col-md-3">
      <div class="d-flex flex-column vh-100">
        <div class="flex-fill">
          <div class="container">
            <div class="row">
            <div class="col-md-8 ">
              <h5>Linked mentions </h5>
            </div>
            <div class="col">
              <h5 id="status">~private</h5>
            </div>
            </div>
          </div>
          <div id="info-bar"></div>
           </div>
        <div class="flex-fill">

        </div>
      </div>
    </div>



  </div>
 </div>
</div>