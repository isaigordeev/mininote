<?php

function startPage() {
    echo <<<FLAG

      <h2>No file is open</h2>

      <div class="empty-state-action-list">
        <div class="empty-state-action">Create new file (⌘ N)</div>
        <div class="empty-state-action">Go to file (⌘ R)</div>
        <div class="empty-state-action">See recent files (⌘ R)</div>
        <div class="empty-state-action mod-close">Close</div>
      </div>

FLAG;

    }


function editorInstance(){
    echo <<<FLAG


      <div id="editor-bar">
        <textarea id="code" rows="30" name="code"></textarea>
      </div>

FLAG;

}
?>