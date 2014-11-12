var Table = function (params) {
	"use strict";
	var data,
		container,
		theme,
		interval;
			
	var init = function (params) {
		var table = {};
		var str_tmp = "show_" + params['table'].toLowerCase() + "_expanded";
		table[str_tmp] = true;
		table['offset'] = 0;
		fetchData(table);
				
		container = params['container'];
		
		theme = params['theme'] || "index-list";
		
		if (!container) {
			console.log("Undefined container");
			return null;
		}
	};

	var init_extended = function (responseText) {
		data = responseText;
		console.log(data);
	}

	var xmlhttpPost = new XMLHttpRequest();
	var postData = function (data) {
		xmlhttpPost.open("POST" , "./model.php" , true);
		xmlhttpPost.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
		var stringToSend = "";
		for (var key in data) {
			stringToSend += key + "=" + data[key] + "&";
		}
		stringToSend = stringToSend.slice(0 , -1);
		console.log(stringToSend);
		xmlhttpPost.send(stringToSend);
		xmlhttpPost.onreadystatechange = function () {
			if (xmlhttpPost.status == 200 && xmlhttpPost.readyState == 4) {
				window.location.href = "./";
			}
		};
	};

	var xmlhttpGet = new XMLHttpRequest();
	var fetchData = function (data) {
		xmlhttpGet.open("POST" , "./retrieve.php" , true);
		xmlhttpGet.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
		var stringToSend = "";
		for (var key in data) {
			stringToSend += key + "=" + data[key] + "&";
		}
		stringToSend = stringToSend.slice(0 , -1);
		console.log(stringToSend);
		xmlhttpGet.send(stringToSend);
		xmlhttpGet.onreadystatechange = function () {
			if (xmlhttpGet.status == 200 && xmlhttpGet.readyState == 4) {
				var data = JSON.parse(xmlhttpGet.responseText);
				init_extended(data);
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
