function filterEnterprise(e){
    var input = document.getElementById("inputEnterprise");
    input.value = input.value.toUpperCase();
    var key = e.keyCode;
    if(!validateChar(key)){
        if(input.value != ""){
            searchEnterprise(input.value)
        }else{
            searchEnterprise("");
        }
    }
}

function searchEnterprise(valueInput){
    $.ajax({
        type: 'post',
        url: '../includes/filterTable.php',
        data: 'entity=enterprise&id='+valueInput,
        success: function (ans) {
            var data=ans.split(";");
            showAlert(data[0],data[1]);
        },
        error: function (ans) {
            showAlert('alert-d','No se pudo conectar con la base de datos');
        }
    })
    .done(function(res){
        $("#dataEnterprise").html(res);
    });
}

function filterUser(e){
    var input = document.getElementById("inputUser");
    input.value = input.value.toUpperCase();
    var key = e.keyCode;
    if(!validateChar(key)){
        if(input.value != ""){
            searchUser(input.value)
        }else{
            searchUser("");
        }
    }
}

function searchUser(valueInput){
    $.ajax({
        type: 'post',
        url: '../includes/filterTable.php',
        data: 'entity=user&id='+valueInput,
        success: function (ans) {
            var data=ans.split(";");
            showAlert(data[0],data[1]);
        },
        error: function (ans) {
            showAlert('alert-d','No se pudo conectar con la base de datos');
        }
    })
    .done(function(res){
        $("#dataUser").html(res);
    });
}

function filterCustomer(e){
    var input = document.getElementById("inputCustomer");
    input.value = input.value.toUpperCase();
    var key = e.keyCode;
    if(!validateChar(key)){
        if(input.value != ""){
            searchCustomer(input.value)
        }else{
            searchCustomer("");
        }
    }
}

function searchCustomer(valueInput){
    $.ajax({
        type: 'post',
        url: '../includes/filterTable.php',
        data: 'entity=customer&id='+valueInput,
        success: function (ans) {
            var data=ans.split(";");
            showAlert(data[0],data[1]);
        },
        error: function (ans) {
            showAlert('alert-d','No se pudo conectar con la base de datos');
        }
    })
    .done(function(res){
        $("#dataCustomer").html(res);
    });
}

function validateChar(key){
    var input = document.getElementsByTagName("input")[0];
    if(key == 219){
        input.value = input.value.substring(0, input.value.length - 1);
        return true;
    }   
    return false;
}

function filterBill(e){
    var input = document.getElementById("inputBill");
    input.value = input.value.toUpperCase();
    var key = e.keyCode;
    if(!validateChar(key)){
        if(input.value != ""){
            searchBill(input.value)
        }else{
            searchBill("");
        }
    }
}

function searchBill(valueInput){
    $.ajax({
        type: 'post',
        url: '../includes/filterTable.php',
        data: 'entity=bill&id='+valueInput,
        success: function (ans) {
            var data=ans.split(";");
            showAlert(data[0],data[1]);
        },
        error: function (ans) {
            showAlert('alert-d','No se pudo conectar con la base de datos');
        }
    })
    .done(function(res){
        $("#dataBill").html(res);
    });
}
