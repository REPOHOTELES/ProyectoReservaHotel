var idCustomer;
var idSign;
var idBlood;
/**
* Archivo para las funciones que son llamadas para un cliente - Actualizar.
*/

function defineUpdate(idUserInput, idSignRH, idBloodRH){
    idCustomer = idUserInput;
    idSign = idSignRH;
    idBlood = idBloodRH;
    var sign = document.getElementsByTagName("select")[5];
    sign.selectedIndex = idSignRH;
}


function updateCustomer(){
    var inputs = document.getElementsByTagName("input");
    
    var name = inputs[0].value;
    var lastName = inputs[1].value;
    var numberDoc = inputs[2].value;
    var phone = inputs[3].value;
    var email = inputs[4].value;
    var birthDate = inputs[5].value;
    var select = document.getElementsByTagName('select')[0]; 
    var typeDocument = select.options[select.selectedIndex].value; 
    
    var countryExp = document.getElementsByTagName('select')[1].value; 
    
    var cityExp = document.getElementsByTagName('select')[2].value;  
    
    var gender = document.getElementsByTagName('select')[3].value; 
    
    var blood = document.getElementsByTagName('select')[4].value; 
    
    var rh = document.getElementsByTagName('select')[5].value; 
    
    var typeBlood = blood+rh;
    
    var profession = document.getElementsByTagName('select')[6].value;
    
    var nationality = document.getElementsByTagName('select')[7].value;
    
    $.ajax({
        type: 'post',
        url: '/includes/update.php',
        data: "action=updateCustomer&name="+name+"&lastName="+lastName+"&numberDoc="+numberDoc+"&phone="+phone+"&email="+email+"&birthDate="+birthDate+"&typeDocument="+typeDocument+"&countryExp="+countryExp+"&cityExp="+cityExp+"&gender="+gender+"&typeBlood="+typeBlood+"&profession="+profession+"&nationality="+nationality+"&id="+idCustomer,
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

function deleteCustomer(){
    deleteUser();
    setTimeout("redirect()", 1);
        
}

function redirect(){
    window.location = "/clientes/";
}
