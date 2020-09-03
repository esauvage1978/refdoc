function required(field) {
    field.prop("required", true);
}

function unrequired(field) {
    field.prop("required", false);
}

function disabled(field) {
    field.prop("disabled", true);
}

function undisabled(field) {
    field.prop("disabled", false);
}

function html(field, value) {
    field.html(value);
}

function getVal(field) {
    return field.val();
}

function setVal(field, value) {
    return field.val(value);
}

function fillComboboxMP(selecteur, route, selectedId = "") {
    axios.get(route).then(function (response) {
        selecteur.append('<option  value=""></option>');

        $.each(response.data.value, function (index, value) {

            if (selectedId === value.id) {
                selected = 'selected';
            } else {
                selected = '';
            }
            selecteur.append('<option ' + selected + ' value="' + value.id + '">' + value.name + '</option>');
        });
    }).catch(function (error) {
        console.log(error);
    });
}