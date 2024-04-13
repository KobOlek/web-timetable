function setChysZnam(chbox, sel, permanent_checkbox){
    if(sel.value == "-"){
        chbox.checked = false; 
    }
    else if(chbox.disabled == false)
        chbox.checked = true;
    permanent_checkbox.disabled = chbox.checked;
}

function setPermanent(permanentCheckbox, znamennyk_checkbox, chyselnyk_checkbox, znamennyk_select, znam_cabinets_select){
    znamennyk_checkbox.checked = false;
    chyselnyk_checkbox.checked = false;
    znamennyk_select.value = "-";

    znamennyk_checkbox.disabled = permanentCheckbox.checked;
    chyselnyk_checkbox.disabled = permanentCheckbox.checked;
    znamennyk_select.disabled = permanentCheckbox.checked;
    znam_cabinets_select.disabled = permanentCheckbox.checked;
}

function turnOffPermanent(chys_znam_checkbox, permanent_checkbox){
    permanent_checkbox.disabled = chys_znam_checkbox.checked;
}

function setSelect(chbox, sel, chys_znam_checkboxes){
    if(sel.value == "-"){
        chbox.checked = false; 
    }
    else if(chbox.disabled == false)
        chbox.checked = true;
    for (let index = 0; index < chys_znam_checkboxes.length; index++) {
        chys_znam_checkboxes[index].disabled = chbox.checked;
    }
}

function setSameSubject(groupsSelects, subjectSel) {
    for (let index = 0; index < groupsSelects.length; index++) {
        groupsSelects[index].value = subjectSel.value;
    }
}

function switchOffPermanent(permanent_checkbox){
    permanent_checkbox.checked = false;
}