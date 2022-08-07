function calcValues(){
    
    var value1 = ((document.getElementById("cant1").value)*(document.getElementById("unit1").value));
    document.getElementById("vTotal1").value = value1;

    var value2 = ((document.getElementById("cant2").value)*(document.getElementById("unit2").value));
    document.getElementById("vTotal2").value = value2;

    var value3 = ((document.getElementById("cant3").value)*(document.getElementById("unit3").value));
    document.getElementById("vTotal3").value = value3;

    var value4 = ((document.getElementById("cant4").value)*(document.getElementById("unit4").value));
    document.getElementById("vTotal4").value= value4;


    document.getElementById("valueTotal").value = value1 + value2 + value3 + value4;
    
}

function example(){
    var responsible = document.getElementById('responsible').innerHTML;
    var name = document.getElementById('nameTitular').value;
    var enterprise = document.getElementById('nameEnterprise').value;
    var documentTitular = document.getElementById('document').value;
    var rooms = document.getElementById('rooms').value; 
    var checkIn = document.getElementById('dateGetIn').value; 
    var checkOut = document.getElementById('dateGetOut').value;
    var idBill = document.getElementById('idBill').innerHTML;
    var desc1 = document.getElementById('desc1').value;
    var desc2 = document.getElementById('desc2').value;
    var desc3 = document.getElementById('desc3').value;
    var desc4 = document.getElementById('desc4').value;
    var cant1 = document.getElementById('cant1').value;
    var cant2 = document.getElementById('cant2').value;
    var cant3 = document.getElementById('cant3').value;
    var cant4 = document.getElementById('cant4').value;
    var unit1 = document.getElementById('unit1').value;
    var unit2 = document.getElementById('unit2').value;
    var unit3 = document.getElementById('unit3').value;
    var unit4 = document.getElementById('unit4').value;
    var vTotal1 = document.getElementById('vTotal1').value;
    var vTotal2 = document.getElementById('vTotal2').value;
    var vTotal3 = document.getElementById('vTotal3').value;
    var vTotal4 = document.getElementById('vTotal4').value;
    var valueTotal = document.getElementById('valueTotal').value; 
    

    $.ajax({
        type: 'post',
		url: '../../includes/insert.php',
		data: "entity=saveManualBill&name="+name+"&enterprise="+enterprise+"&documentTitular="+documentTitular+"&rooms="+rooms+"&checkIn="+checkIn+"&checkOut="+checkOut+"&idBill="+idBill+"&desc1="+desc1+"&desc2="+desc2+"&desc3="+desc3+"&desc4="+desc4+"&cant1="+cant1+"&cant2="+cant2+"&cant3="+cant3+"&cant4="+cant4+"&unit1="+unit1+"&unit2="+unit2+"&unit3="+unit3+"&unit4="+unit4+"&vTotal1="+vTotal1+"&vTotal2="+vTotal2+"&vTotal3="+vTotal3+"&vTotal4="+vTotal4+"&valueTotal="+valueTotal+"&responsible="+responsible,
		success: function (ans) {
            var data=ans.split(";");
            alert(data[1]);
            showAlert(data[0],data[1]);
            location.href = '../../reportes/facturas/manualBill.php?idBill='+idBill;
		},
		error: function (ans) {
			showAlert('alert-d','No se pudo conectar con la base de datos');
		}
    });
}


function clearAllFields(){
    var name = document.getElementById('nameTitular').value = "";
    var enterprise = document.getElementById('nameEnterprise').value = "";
    var documentTitular = document.getElementById('document').value = "";
    var rooms = document.getElementById('rooms').value = ""; 
    var checkIn = document.getElementById('dateGetIn').value = ""; 
    var desc1 = document.getElementById('desc1').value = "";
    var desc2 = document.getElementById('desc2').value = "";
    var desc3 = document.getElementById('desc3').value = "";
    var desc4 = document.getElementById('desc4').value = "";
    var cant1 = document.getElementById('cant1').value = 0;
    var cant2 = document.getElementById('cant2').value = 0;
    var cant3 = document.getElementById('cant3').value = 0;
    var cant4 = document.getElementById('cant4').value = 0;
    var unit1 = document.getElementById('unit1').value = 0;
    var unit2 = document.getElementById('unit2').value = 0;
    var unit3 = document.getElementById('unit3').value = 0;
    var unit4 = document.getElementById('unit4').value = 0;
    var vTotal1 = document.getElementById('vTotal1').value = 0;
    var vTotal2 = document.getElementById('vTotal2').value = 0;
    var vTotal3 = document.getElementById('vTotal3').value = 0;
    var vTotal4 = document.getElementById('vTotal4').value = 0;
    var valueTotal = document.getElementById('valueTotal').value = 0; 
}
