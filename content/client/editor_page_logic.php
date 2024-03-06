<?php

function startPage() {
    echo <<<FLAG


      <div id="empty-state-action-list">
        <h2>No file is open</h2>
        
      
        <div class="empty-state-action">Create new file (Shift N)</div>
        
        <div class="empty-state-action">Delete a note (Shift D)</div>
        
        <div class="empty-state-action">Make a note public (Shift C)</div>
        
        <div class="empty-state-action">Make a note private (Shift V)</div>
        
        <div class="empty-state-action mod-close">Save and Quit (Shift W)</div>
        
        <div class="empty-state-action mod-close">Save (Shift S)</div>
        
        
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