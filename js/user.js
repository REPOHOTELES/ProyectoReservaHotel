var idUser;

function defineRegister(){
    document.getElementById("edit-btn").style.display = "none";
    document.getElementById("delete-btn").style.display = "none";
    document.getElementById("back-btn").style.display = "none";
}

function defineDetailsUser(idRol){
    var mySelectRole = document.getElementsByTagName("select")[1];
    mySelectRole.selectedIndex = idRol-1;
}

function defineUpdate(idRol, idUserInput){
    idUser = idUserInput;
    var mySelectRole = document.getElementsByTagName("select")[1];
    mySelectRole.selectedIndex = idRol-1;
}

function saveUser(){
    if(!validateFields())
        showAlert("alert-i","Es necesario agregar información en los campos obligatorios (*)");
    else{
        var inputs = document.getElementsByTagName('input');
        var name = inputs[0].value;
        var lastName = inputs[1].value;
        var select = document.getElementsByTagName('select')[0]; 
        var typeDocument = select.options[select.selectedIndex].value; 
        var numberDocument = inputs[2].value;
        var phone = inputs[3].value;
        var selectRole = document.getElementsByTagName('select')[1]; 
        var role = selectRole.options[selectRole.selectedIndex].index+1;
        var email = inputs[4].value;
        var userName = inputs[5].value;
        var password1 = inputs[6].value;
        var password2 = inputs[7].value;
        
        if(password1 != password2){
            showAlert("alert-i","Las contraseñas no coinciden, por favor tenga en cuenta los caracteres ingresados");
        }else{
            if(password1.length <8)
                showAlert("alert-i","Es necesario que la contraseña tenga al menos 8 caracteres");
            
            var espacios = false;
            var cont = 0;

            while (!espacios && (cont < password1.length)) {
              if (password1.charAt(cont) == " ")
                espacios = true;
              cont++;
            }

            if (espacios){
              showAlert("alert-i","La contraseña no puede contener caracteres en blanco");  
            }else{
                $.ajax({
                    type: 'post',
                    url: '../../includes/insert.php',
                    data: "entity=saveUser&name="+name+"&lastName="+lastName+"&typeDocument="+typeDocument+"&numberDocument="+numberDocument+"&phone="+phone+"&role="+role+"&email="+email+"&userName="+userName+"&password="+password1,
                    success: function (ans) {
                        var data=ans.split(";");
                        showAlert(data[0],data[1]);
                        setTimeout("redirect()", 2000);
                    },
                    error: function (ans) {
                        showAlert('alert-d','No se pudo conectar con la base de datos');
                    }
                });
            } 
        }
    } 
}


function updateUser(){
    if(!validateFields())
        showAlert("alert-i","Es necesario agregar información en los campos obligatorios (*)");
    else{
        var inputs = document.getElementsByTagName('input');
        var name = inputs[0].value;
        var lastName = inputs[1].value;
        var select = document.getElementsByTagName('select')[0]; 
        var typeDocument = select.options[select.selectedIndex].value; 
        var numberDocument = inputs[2].value;
        var phone = inputs[3].value;
        var selectRole = document.getElementsByTagName('select')[1]; 
        var role = selectRole.options[selectRole.selectedIndex].index+1;
        var email = inputs[4].value;
        var userName = inputs[5].value;
        var password1 = inputs[6].value;
        var password2 = inputs[7].value;
        
        if(password1 != password2){
            showAlert("alert-i","Las contraseñas no coinciden, por favor tenga en cuenta los caracteres ingresados");
        }else{
            if(password1.length <8)
                showAlert("alert-i","Es necesario que la contraseña tenga al menos 8 caracteres");
            
            var espacios = false;
            var cont = 0;

            while (!espacios && (cont < password1.length)) {
              if (password1.charAt(cont) == " ")
                espacios = true;
              cont++;
            }

            if (espacios){
              showAlert("alert-i","La contraseña no puede contener caracteres en blanco");  
            }else{
                $.ajax({
                    type: 'post',
                    url: '../../includes/update.php',
                    data: "action=updateUser&name="+name+"&lastName="+lastName+"&typeDocument="+typeDocument+"&numberDocument="+numberDocument+"&phone="+phone+"&role="+role+"&email="+email+"&userName="+userName+"&password="+password1+"&id="+idUser,
                    success: function (ans) {
                        var data=ans.split(";");
                        showAlert(data[0],data[1]);
                        setTimeout("redirect()", 2000);
                    },
                    error: function (ans) {
                        showAlert('alert-d','No se pudo conectar con la base de datos');
                    }
                });
            } 
        }
    } 
}

function redirect(){
    window.location = "../../usuarios/";
}


function deleteUser(idUserInput){
    $.ajax({
        type: 'post',
        url: '../../includes/update.php',
        data: "action=deleteUser&id="+idUserInput,
        success: function (ans) {
            var data=ans.split(";");
            showAlert(data[0],data[1]);
            setTimeout("redirect()", 2000);
        },
        error: function (ans) {
            showAlert('alert-d','No se pudo conectar con la base de datos');
        }
    });
}

function validateFields(){
    var inputs = document.getElementsByTagName('input');
    for(var i=0; i<inputs.length; i++){
        if(i != 4){
            if(inputs[i].value == "")
                return false;
        }
    }
    return true;
}
