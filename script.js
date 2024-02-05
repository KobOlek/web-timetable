function setChysZnam(chbox, sel){
    if(sel.value == "-"){
        chbox.checked = false;
        return;   
    }
    chbox.checked = true;
}

function setPermanent(permanentCheckbox, znamennyk_checkbox, chyselnyk_checkbox, znamennyk_select, chyselnyk_select){
    znamennyk_checkbox.checked = false;
    chyselnyk_checkbox.checked = false;
    
    znamennyk_select.value = "-";

    znamennyk_checkbox.disabled = permanentCheckbox.checked;
    chyselnyk_checkbox.disabled = permanentCheckbox.checked;
    znamennyk_select.disabled = permanentCheckbox.checked;
}