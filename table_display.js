var Table = function (params) {
	"use strict";
	var data,
		container,
		theme,
		;
			
	var init = function (params) {
		data = params['data'];
		container = params['container'];
		theme = params['theme'] || "defaulttheme";
		
		if (!data) {
			console.log("Undefined data");
			return null;
		}
		if (!container) {
			console.log("Undefined container");
			return null;
		}

		
	};

	var xmlhttp = new XMLHttpRequest();
	var postRequest = function () {
		var data = inputBox.value;
		xmlhttp.open("POST" , "./feedback.php" , true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
		xmlhttp.send("message=" + data);
		xmlhttp.onreadystatechange = function (argument) {
			if (xmlhttp.status == 200 && xmlhttp.readyState == 4) {
				window.location.reload();
			}
		};
	};

	var createNode = function (type , id , classList , innerText , parentNode , onclickHandler , attributes) {
		var node = document.createElement(type);
		node.id = id;
		for (var i = classList.length - 1; i >= 0; i--) {
			node.classList.add(classList[i]);
		};	
		node.appendChild( document.createTextNode (innerText) );
		node.addEventListener('click' , onclickHandler , true);
		parentNode.appendChild(node);
		return node;
		for (var key in attributes) {
			node.setAttribute(key , attributes[key]);
		};
	};

	var log = function () {
		console.log(params)
		console.log(data);
		console.log(container);
	};

	init(params);
	if (params['debug'])
		log();
}
