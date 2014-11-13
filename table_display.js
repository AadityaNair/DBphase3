var Table = function (params) {
	"use strict";
	var data,
		container,
		theme,
		interval,
		offset,
		currentTable;
			
	var init = function (params) {
		currentTable = params['table'];
		var table = {};
		var str_tmp = "show_" + currentTable.toLowerCase().replace(" " , "_") + "_expanded";
		table[str_tmp] = true;
		table['offset'] = offset || 0;
		fetchData(table);
		container = params['container'];
		theme = params['theme'] || "index-list";
		
		if (!container) {
			console.log("Undefined container");
			return null;
		}
	};

	var init_extended = function (responseText) {
		container.innerHTML = "";
		var parent = createNode("div" , "" , [theme , "parent"] , "" , container , null , {});
		data = responseText;
		var header = createNode("div" , "" , [theme , "row-wrapper" , "header"] , "" , parent , null , {});
		for (var key in data[0]) {
			createNode("div" , "" , [theme , "header" , "cell"] , key.replace(/_/g, " " ) , header , null , {});
		}
		createNode("div" , "" , [theme , "cell" , "add-button"] , "+" , header , null , {});
		for (var i = data.length - 1; i >= 0; i--) {
			var row = createNode("div" , "" , [theme , "row-wrapper" , "body"] , "" , parent , null , {});
			for (var key in data[i]) {
				createNode("div" , "" , [theme , "body" , "cell"] , data[i][key] , row , null , {
					"data-id" : data[i]['id']
				});
			}
			createNode("div" , "" , [theme , "cell" , "delete-button"] , "Delete" , row , handleDeleteButtonClick , {
				"data-id" : data[i]['id']
			});
		};

	}

	var handleDeleteButtonClick = function (event) {
		if (event.target) {
			var table = {};
			var str_tmp = "delete_" + currentTable.toLowerCase().replace(" " , "_");
			table[str_tmp] = true;
			table['id'] = event.target.dataset.id;
			postData(table);
		}
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
				// window.location.reload();
			}
		};
	};

	var xmlhttpGet = new XMLHttpRequest();
	var fetchData = function (data) {
		xmlhttpGet.open("POST" , "./model.php" , true);
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
		node.addEventListener('click' , onclickHandler , false);
		parentNode.appendChild(node);
		for (var key in attributes) {
			node.setAttribute(key , attributes[key]);
		};
		return node;
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
