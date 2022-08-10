var typeBill = 0;
var idBook = -1;
var totalBill = 0;
var user = "";

/**
* Función encargada de buscar a la persona titular de la reserva, con el fin de generar una nueva factura
**/
function searchTitular(input, typePayment, typeTitular, idRes){
    if(typePayment==0){
        var rbutton = document.getElementsByName("typeId");
        var typeId = getRadioButtonSelectedValue(rbutton);
        if(typeId == 'CC'){
            fullDataTPerson(input.value, typePayment, 0, idRes);
        }else if(typeId == 'NIT'){
            fullDataTEnterprise(input.value, typePayment, 0, idRes);
        }   
    }else if(typePayment==1){
        if(typeTitular==0){
            fullDataTPerson(input, typePayment, 0, idRes);
        }else{
            fullDataTEnterprise(input, typePayment, 0, idRes);
        }
    }else if(typePayment==2){
        if(typeTitular==0){
            fullDataTPerson(input, typePayment, 1, idRes);
        }else{
            fullDataTEnterprise(input, typePayment, 1, idRes);
        }
    }else if(typePayment==3){
        if(typeTitular==0){
            fullDataTPerson(input, typePayment, 0, idRes);
        }else{
            fullDataTEnterprise(input, typePayment, 0, idRes);
        }
    }
}


function fullDataTPerson(input, typePayment, toPay, idRes){
    //resetValues();
    
    $.ajax({
        type: 'post',
        url: '../../includes/get.php',
        data: 'entity=searchTitularPerson&idTitular='+input+"&typePayment="+typePayment+"&idRes="+idRes,
        
        success:function(ans){
            var data=ans.split(";");
            if(data.length>=14){
                
                var searchs=document.getElementsByClassName("card-search");
                var search;
                
                for (var i = 0; i < searchs.length; i++) {
                    if(searchs[i].getElementsByTagName("input")[2]==input){
                        search=searchs[i];
                    }     
                }
                
                var typeId = document.getElementById("numberId");
                typeId.innerHTML = "Número de Documento: ";
                
                
                //var body= search.parentElement.getElementsByClassName("infos")[0];
                if(typePayment==0){
                    document.getElementsByTagName("input")[2].value = "";    
                }
                
                
                
                var valueLabels = document.getElementsByTagName("label");
                user = document.getElementById("currentUser").value;
                if(typePayment==0){
                    valueLabels[4].innerHTML = data[0]+" "+data[1];
                    valueLabels[5].innerHTML = data[3];
                    valueLabels[6].innerHTML = data[2];
                    valueLabels[7].innerHTML = data[7];
                    valueLabels[8].innerHTML = data[4];
                    valueLabels[9].innerHTML = data[5];    
                }else{
                    valueLabels[0].innerHTML = data[0]+" "+data[1];
                    valueLabels[1].innerHTML = data[3];
                    valueLabels[2].innerHTML = data[2];
                    valueLabels[3].innerHTML = data[7];
                    valueLabels[4].innerHTML = data[4];
                    valueLabels[5].innerHTML = data[5];
                }
                
                
                //var body= search.parentElement.getElementsByClassName("col-12")[3];
                document.getElementById("myTable").innerHTML = "";
                
                if(toPay==0){
                    var count = 0;
                    var classTable = "";
                    var resultRow = "";
                    for(var i = 9; i<data.length-1; i++){
                        if(count==3)
                            classTable = "class = totals";
                        else
                            classTable = 'class = ""';
                        resultRow += "<td "+classTable+">"+data[i]+"</td>";
                        count++;
                        if(count==4){
                            var myRow = document.createElement("tr");
                            myRow.innerHTML = resultRow;
                            document.getElementById("myTable").appendChild(myRow);
                            count = 0;
                            resultRow = "";
                        }
                    }
                }
                
                var valueTotals = document.getElementsByClassName("totals");

                for(var i = 0; i<valueTotals.length; i++){
                    totalBill += parseInt(valueTotals[i].innerHTML.replace('.', ''));
                }
                
                paidValue = data[data.length-1];
            
                document.getElementById("paidValue").innerHTML=new Intl.NumberFormat("es-CO").format(paidValue);
                
                if(toPay == 1){
                    totalBill = paidValue;
                    document.getElementById("valueTotal").innerHTML=new Intl.NumberFormat("es-CO").format(paidValue);
                }else{
                    document.getElementById("valueTotal").innerHTML=new Intl.NumberFormat("es-CO").format(totalBill-paidValue);
                    document.getElementById("totalRes").innerHTML=new Intl.NumberFormat("es-CO").format(totalBill);
                }
                    
                
                if(typePayment != 1){
                    buttonBill = document.getElementById("generateBill");    
                }
                
                
                
                idBook = data[8];
                if(toPay==1){
                    buttonBill.onclick = function(){sendBill(); setTimeout(function (){location.href='../../reportes/facturas?id='+idBook+"&typeBill="+typeBill+"&serie=TOPAY";}, 2000)};
                }else{
                    if(typePayment!=1){
                        buttonBill.onclick = function(){sendBill(); setTimeout(function (){location.href='../../reportes/facturas?id='+idBook+"&typeBill="+typeBill+"&serie=NEW";}, 2000)};  
                    }         
                }
                
                
                showAlert("alert-s","Se encontró al cliente con el número de documento "+input);
            }else{
                if(typePayment==0){
                    if(document.getElementsByTagName("input")[2].value==""){
                        showAlert("alert-i","Es necesario que ingrese un valor en el campo de búsqueda");
                    }else{
                        showAlert("alert-i","No se encontró a ningun cliente con el número de documento "+input);
                        if(typePayment==0){
                            document.getElementsByTagName("input")[2].value = "";    
                        }
                    }    
                }
            }
        }
    }); 
}


function fullDataTEnterprise(input, typePayment, toPay, idRes){
   // resetValues();
    $.ajax({
        type: 'post',
        url: '../../includes/get.php',
        data: 'entity=searchTitularEnterprise&idTitular='+input+"&typePayment="+typePayment+"&idRes="+idRes,
        
        success:function(ans){
            var data=ans.split(";");
            
            if(data.length>=9){
                
                var searchs=document.getElementsByClassName("card-search");
                var search;
                
                for (var i = 0; i < searchs.length; i++) {
                    if(searchs[i].getElementsByTagName("input")[2]==input){
                        search=searchs[i];
                    }     
                }
                
                var typeId = document.getElementById("numberId");
                typeId.innerHTML = "NIT: ";
                
                
                //var body= search.parentElement.getElementsByClassName("infos")[0];
                if(typePayment==0){
                    document.getElementsByTagName("input")[2].value = "";    
                }
                
                
                var valueLabels = document.getElementsByTagName("label");
                user = document.getElementById("currentUser").value;
                
                if(typePayment==0){
                    valueLabels[4].innerHTML = data[0]
                    valueLabels[5].innerHTML = data[1];
                    valueLabels[6].innerHTML = data[2];
                    valueLabels[7].innerHTML = data[5];
                    valueLabels[8].innerHTML = data[3];
                    valueLabels[9].innerHTML = data[4];    
                }else{
                    valueLabels[0].innerHTML = data[0]
                    valueLabels[1].innerHTML = data[1];
                    valueLabels[2].innerHTML = data[2];
                    valueLabels[3].innerHTML = data[5];
                    valueLabels[4].innerHTML = data[3];
                    valueLabels[5].innerHTML = data[4];
                }
                
                
                //var body= search.parentElement.getElementsByClassName("col-12")[3];
                document.getElementById("myTable").innerHTML = "";
                

                if(toPay==0){
                    var count = 0;
                    var classTable = "";
                    var resultRow = "";
                    for(var i = 7; i<data.length-1; i++){
                        if(count==3)
                            classTable = "class = totals";
                        else
                            classTable = 'class = ""';
                        resultRow += "<td "+classTable+">"+data[i]+"</td>";
                        count++;
                        if(count==4){
                            var myRow = document.createElement("tr");
                            myRow.innerHTML = resultRow;
                            document.getElementById("myTable").appendChild(myRow);
                            count = 0;
                            resultRow = "";
                        }
                    }  
                }
                
                var valueTotals = document.getElementsByClassName("totals");

                for(var i = 0; i<valueTotals.length; i++){
                    totalBill += parseInt(valueTotals[i].innerHTML.replace('.', ''));
                }
                
                paidValue = data[data.length-1];
                document.getElementById("paidValue").innerHTML=new Intl.NumberFormat("es-CO").format(paidValue);
                if(toPay == 1)
                    document.getElementById("valueTotal").innerHTML=new Intl.NumberFormat("es-CO").format(paidValue);
                else
                    document.getElementById("valueTotal").innerHTML=new Intl.NumberFormat("es-CO").format(totalBill-paidValue);
                
                if(typePayment != 1){
                    buttonBill = document.getElementById("generateBill");
                }
                
                
                idBook = data[6];
                if(toPay==1){
                    buttonBill.onclick = function(){sendBill(); setTimeout(function (){location.href='../../reportes/facturas?id='+idBook+"&typeBill="+typeBill+"&serie=TOPAY";}, 2000)};
                }else{
                    if(typePayment!=1){
                        buttonBill.onclick = function(){sendBill(); setTimeout(function (){location.href='../../reportes/facturas?id='+idBook+"&typeBill="+typeBill+"&serie=NEW";}, 2000)};       
                    }
                }
                
                showAlert("alert-s","Se encontró a la empresa con NIT " +input);
            }else{
                if(typePayment==0){
                    if(document.getElementsByTagName("input")[2].value==""){
                        showAlert("alert-i","Es necesario que ingrese un valor en el campo de búsqueda");
                    }else{
                        showAlert("alert-i","No se encontró a ninguna empresa con el NIT " +input);
                        if(typePayment==0){
                            document.getElementsByTagName("input")[2].value = "";    
                        }
                    }
                }
            }
        }
    }); 
}

function changeToEnterprise(){
    resetValues();
    var example = document.getElementsByTagName("small")[0];
    example.innerHTML = "ej. 900665829-7";
    var namePerson = document.getElementById("namePerson");
    namePerson.innerHTML = "Empresa: ";
    var typeId = document.getElementById("numberId");
    typeId.innerHTML = "NIT: ";
    var mask = document.getElementsByTagName("input")[2];
    mask.value = "";
    mask.onkeydown = function(){$(mask).mask('000000000-0', {reverse: true})};
}

function changeToPerson(){
    resetValues();
    var example = document.getElementsByTagName("small")[0];
    example.innerHTML = "ej. 102055214";
    var namePerson = document.getElementById("namePerson");
    namePerson.innerHTML = "Nombre: ";
    var typeId = document.getElementById("numberId");
    typeId.innerHTML = "Número de Documento: ";
    var mask = document.getElementsByTagName("input")[2];
    mask.value = "";
    mask.onkeydown = function(){$(mask).mask('0000000000')};
}

/**
* Se encarga de almacenar la factura en la base de datos, de acuerdo a la reserva elegida
**/
function sendBill(){
	$.ajax({
		type: 'post',
		url: '../../includes/insert.php',
		data: "entity=saveBill&idBook="+idBook+"&typeBill="+typeBill+"&totalBill="+totalBill+"&currentUser="+user,
		success: function (ans) {
			var data=ans.split(";");
			showAlert(data[0],data[1]);
		},
		error: function (ans) {
			showAlert('alert-d','No se pudo conectar con la base de datos');
		}
	});
}

/**
* Elimina los datos de una tabla determinada
**/
function remove(t){
        var td = t.parentNode;
        var tr = td.parentNode;
        var table = tr.parentNode;
        table.removeChild(tr);
}

/**
* Valida que en un campo únicamente se pueden ingresar valores numéricos
**/
function validateNumericValue(event){
	if(event.charCode >= 48 && event.charCode <= 57){
      return true;
     }
     return false;  
}

/**
* Obtiene el valor del RadioButton que es seleccionado
**/
function getRadioButtonSelectedValue(ctrl){
    for(i=0;i<ctrl.length;i++)
        if(ctrl[i].checked) return ctrl[i].value;
}


function changeSelect(){
    var select = document.getElementById("selectType"); 
    var index = select.options[select.selectedIndex].index; 
    var serieBill = document.getElementById("serieBill");
    var serieOrder = document.getElementById("serieOrder");
    var btn = document.getElementsByTagName("span")[0];
    typeBill = index;
    if(index==0){
        serieOrder.style.display = "none";
        serieBill.style.display = "inline";
        btn.innerHTML = "GUARDAR FACTURA";
    }else{
        serieBill.style.display = "none";
        serieOrder.style.display = "inline";
        btn.innerHTML = "GUARDAR ORDEN";
    }
}

function resetValues(){
    var valueLabels = document.getElementsByTagName("label");
    valueLabels[4].innerHTML = "";
    valueLabels[5].innerHTML = "";
    valueLabels[6].innerHTML = "";
    valueLabels[7].innerHTML = "";
    valueLabels[8].innerHTML = "";
    valueLabels[9].innerHTML = "";
    document.getElementById("myTable").innerHTML = "";
    document.getElementById("paidValue").innerHTML="";
    document.getElementById("valueTotal").innerHTML="";
    totalBill = 0;
}
