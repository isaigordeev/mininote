<div class="container-fluid Signup">
  <div class="col-md-6 offset-md-3">
  <h4>Note name</h4>
  </div>
  <div class="row">

    <div id="navigation-bar" class="col">
      <?php
      $paths = array(
//          'Create Folder' => null,
          'documents' => array(
              'report1' => array(),
              'report2' => array(
                  'report3' => array()
              )
          ),
          'images' => array(
              'photos' => array()
          ),
          'videos' => array(),
          'file1',
          'note2'

      );

      function renderMenu($menu) {
          echo '<ul>';
          foreach ($menu as $key => $value) {
//              echo '<li>';
//              if ($value === null) {
//                  echo '<button class="create-folder-button">' . $key . '</button>';
//              } else {
//                  echo '<a href="#">' . $key . '</a>';
//              }
              if (is_array($value)) {
                  echo '<li><a href="#">' . $key. '</a>';
                if(count($value) > 0) {
                    renderMenu($value);
                } else {
                  echo "";
                }
              } else {

                  echo '<li><a href="#">' . $value . '</a>';
              }
              echo '</li>';
          }
          echo '</ul>';
      }

      // Render the menu
      renderMenu($paths);
      ?>
    </div>

    <div class="col-md-6">

      <div id="editor-bar">
        <textarea id="code" rows="30" name="code"></textarea>
      </div>
    </div>

    <div id="info-bar" class="col-md-3">
      Note information
    </div>

  </div>

<!--    <div id="output">test text</div>-->

<!--    <button onclick="getText()">Get Text</button>-->
</div>

<script>
    var menuItems = document.querySelectorAll('ul > li');
    menuItems.forEach(function(item) {
        item.addEventListener('click', function(event) {
            var submenu = item.querySelector('ul');
            if (submenu) {
                if (submenu.style.display === 'none') {
                    submenu.style.display = 'block';
                } else {
                    submenu.style.display = 'none';
                }
            }
        });

        var submenuItems = item.querySelectorAll('ul > li');
        submenuItems.forEach(function(subitem) {
            subitem.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        });
    });
</script>