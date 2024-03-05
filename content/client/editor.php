
<div class="container-fluid Signup">
  <div class="col-md-6 offset-md-3">
  <h4>Note name</h4>
  </div>
  <div class="row">

    <div id="navigation-bar" class="col">

    </div>

    <div class="col-md-6">
    <div id="editableNoteName" contenteditable="true">Untitled</div>

    <div id="editor-bar">
        <?php
        require("editor_page_logic.php");
//        editorInstance();
        var_dump($_GET);
        var_dump($_POST);


        startPage();
//        if(isset($_GET["isnote"])){
//          var_dump($_GET);
//          editorInstance();
//        } else {
//            var_dump($_GET);
//          startPage();
//        }
        ?>
<!--      <div id="editor-bar">-->
<!--        <textarea id="code" rows="30" name="code"></textarea>-->
<!--      </div>-->
    </div>
    </div>

    <div id="info-bar" class="col-md-3">
      Note information
    </div>

  </div>

<!--    <div id="output">test text</div>-->

<!--    <button onclick="getText()">Get Text</button>-->
</div>

<script src="navigation_init.js"></script>


<!--<script>-->
<!--    var menuItems = document.querySelectorAll('ul > li');-->
<!--    menuItems.forEach(function(item) {-->
<!--        item.addEventListener('click', function(event) {-->
<!--            var submenu = item.querySelector('ul');-->
<!--            if (submenu) {-->
<!--                if (submenu.style.display === 'none') {-->
<!--                    submenu.style.display = 'block';-->
<!--                } else {-->
<!--                    submenu.style.display = 'none';-->
<!--                }-->
<!--            }-->
<!--        });-->
<!---->
<!--        var submenuItems = item.querySelectorAll('ul > li');-->
<!--        submenuItems.forEach(function(subitem) {-->
<!--            subitem.addEventListener('click', function(event) {-->
<!--                event.stopPropagation();-->
<!--            });-->
<!--        });-->
<!--    });-->
<!--</script>-->