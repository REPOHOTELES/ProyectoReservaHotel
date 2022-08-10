function loadBooking(id){
	var main=document.getElementById("main-row");

	$.ajax({
		type: 'post',
		url: '../../includes/get.php',
		data:'entity=booking&id='+id
	}).then(function(ans){
		var data=ans.split(";");
		var fDate=document.getElementById("finish-date");
		var roomsQ=document.getElementById("rooms-quantity");
		document.getElementById("start-date").value=data[0];
		fDate.value=data[1];
		roomsQ.value=data[2];
		fDate.onchange.call();
		updateRoom(roomsQ);
		var idHolder=data[3];
		var isEnterprise=data[4]!="";

		return $.ajax({
			type: 'post',
			url: '../../includes/get.php',
			data: 'entity=bookingRooms&id='+id
		});
	}).then(function(ans){
		var roomGroups=main.getElementsByClassName("room-group");
		var data=ans.split("?");
		var checkinButtons= main.getElementsByClassName("btn-check-in");

		for (var i = 0; i < data.length-1; i++) {
			var roomData=data[i].split(";");
			var clientIds=roomData[4].split(",");
			var clientDocs=roomData[5].split(",");
			console.log(clientIds);
			console.log(clientDocs);
			var selects=roomGroups[i].getElementsByClassName("card-room")[0].getElementsByTagName("select");
			selects[0].value=roomData[0];
			updateGuest(i,selects[0]);
			selects[0].onchange.call();
			selects[1].value=roomData[1];
			selects[2].value=roomData[2];
			selects[3].value=roomData[3];



			for (var j = 0; j < clientIds.length; j++) {
				var search=roomGroups[i].getElementsByClassName("card-client")[j]
				.getElementsByClassName("card-search")[0].getElementsByTagName("input")[0];

				if(clientIds.length==clientDocs.length&&clientIds.length!=1)
					search.value=clientDocs[j];
				else
					search.value=clientIds[j];

				searchPerson(search);
			}
		}

		for (var i = 0; i < checkinButtons.length; i++) {
			checkinButtons[i].style.display="none";
		}

	});
}

function setUpdatePreviewBook(){
	var mainRow=document.getElementById("main-row");
	var confirm= document.getElementById("confirm-modal").getElementsByClassName("card-body")[0];
	var switches= document.getElementById("confirm-modal").getElementsByClassName("card-body")[1];
	var primeInputs=mainRow.getElementsByClassName('card-prime')[0].getElementsByTagName("input");
	var roomGroups= mainRow.getElementsByClassName("room-group");
	var clientCards=mainRow.getElementsByClassName("card-client");
	var holderCard=clientCards[0];
	var holderInputs=holderCard.getElementsByTagName("input");
	confirm.innerHTML="";
	var row =document.createElement("div");
	row.classList.add("row");
	row.appendChild(createFormGroupLabel("Fecha de llegada",convertDate(primeInputs[0].value),"calendar"));
	row.appendChild(createFormGroupLabel("Fecha de salida",convertDate(primeInputs[1].value),"calendar"));
	row.appendChild(createFormGroupLabel("Cantidad de habitaciones",primeInputs[3].value,"bed"));
	confirm.appendChild(row);
	var flags=document.getElementById("main-row").getElementsByClassName("row-flag");
	var isComplete=true;

	for (var i = 0; i < flags.length; i++) {
		if(flags[i].getAttribute("state")!="show"){
			isComplete=false;
			break;
		}
	}
	
	if(!holderInputs[0].checked){
		row =document.createElement("div");
		row.classList.add("row");
		var bodies=holderCard.getElementsByClassName("card-body");

		if(bodies[1].style.display=="")
			row.appendChild(createFormGroupLabel("Titular",holderInputs[1].value+" "+holderInputs[2].value,"user"));
		else
			row.appendChild(createFormGroupLabel("Empresa",getSelectedOptionNameFrom(bodies[1].getElementsByTagName("select")[0]),"user"));
		
		confirm.appendChild(row);
	}

	var roomSelects;
	var roomInput;
	var guests;
	var guestsNames;
	var tariff;
	var totalTariffs=0;
	var clientsQuantity=0;

	for (var i = 0; i < roomGroups.length; i++) {
		guestsNames="";
		row =document.createElement("div");
		row.classList.add("row");
		roomSelects=roomGroups[i].getElementsByClassName("card-room")[0].getElementsByTagName("select");
		roomInput=roomGroups[i].getElementsByClassName("card-room")[0].getElementsByTagName("input")[0];
		row.appendChild(createFormGroupLabel("Habitación "+(i+1),getSelectedOptionNameFrom(roomSelects[2])+" ("+getSelectedOptionNameFrom(roomSelects[1])+")","bed"));
		tariff=getSelectedOptionNameFrom(roomSelects[3]);
		
		if(tariff=="Otro")
			tariff=roomInput.value;
		
		tariff=tariff.replace('.','');
		totalTariffs+=parseInt(tariff);
		row.appendChild(createFormGroupLabel("Tarifa",tariff,"dollar"));
		guests=roomGroups[i].getElementsByClassName("client-cards")[0].getElementsByClassName("card-body");
		
		for (var j = 0; j < guests.length; j++) {
			if(guests[j].id!="enterprise-holder"){
				guestsNames+=guests[j].getElementsByTagName("input")[0].value;
				clientsQuantity++;

				if(j!=guests.length-1)
					guestsNames+=",";
			}
		}

		row.appendChild(createFormGroupLabel("Huespedes",guestsNames,"group"));
		confirm.appendChild(row);
	}

	row =document.createElement("div");
	row.classList.add("row");
	row.appendChild(createFormGroupLabel("Total (Habitaciones)",totalTariffs,"dollar","total-label"));
	confirm.appendChild(row);
	document.getElementById("input-paid").value=totalTariffs;
}
