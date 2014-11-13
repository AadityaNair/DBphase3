var Table = function (params) {
	"use strict";
	var data,
		container,
		theme,
		interval,
		offset,
		currentTable,
		dataList,
		newDataList;
			
	var init = function (params) {
		currentTable = params['table'];
		var table = {};
		var str_tmp = "show_" + currentTable.toLowerCase().replace(" " , "_") + "_expanded";
		table[str_tmp] = true;
		table['offset'] = offset || 0;
		fetchData(table , init_extended);
		container = params['container'];
		theme = params['theme'] || "index-list";

		newDataList = [];
		dataList = [];
		
		if (!container) {
			console.log("Undefined container");
			return null;
		}
	};

	var handleNormalButtonClick = function (event) {
		var table = {};
		var str_tmp = "show_" + currentTable.toLowerCase().replace(" " , "_") + "_expanded";
		table['offset'] = offset || 0;
		table[str_tmp] = true;
		fetchData(table , init_extended);

		for (var i = dataList.length - 1; i >= 0; i--) {
			dataList[i]
			var table = {};
			var str_tmp = "update_" + currentTable.toLowerCase().replace(" " , "_");
			for (var j = dataList[i].length - 1; j >= 0; j--) {
				table[dataList[i][j].dataset.key] = dataList[i][j].value;
			};
			table[str_tmp] = true;
			postData(table);
		};
	};

	var init_extended = function (responseText) {
		container.innerHTML = "";
		var parent = createNode("div" , "" , [theme , "parent"] , "" , container , null , {});
		data = responseText;
		var header = createNode("div" , "" , [theme , "row-wrapper" , "header"] , "" , parent , null , {});
		for (var key in data[0]) {
			createNode("div" , "" , [theme , "header" , "cell"] , key.replace(/_/g, " " ) , header , null , {});
		}
		createNode("div" , "" , [theme , "cell" , "add-button"] , "Edit/Add" , header , handleEditButtonClick , {});
		for (var i = data.length - 1; i >= 0; i--) {
			var row = createNode("div" , "" , [theme , "row-wrapper" , "body"] , "" , parent , null , {});
			for (var key in data[i]) {
				createNode("div" , "" , [theme , "body" , "cell"] , data[i][key] , row , null , {
					"data-id" : data[i]['id'],
					"data-key" : key
				});
			}
			createNode("div" , "" , [theme , "cell" , "delete-button"] , "Delete" , row , handleDeleteButtonClick , {
				"data-id" : data[i]['id']
			});
		};
	}

	var init_edit = function (responseText) {
		container.innerHTML = "";
		var parent = createNode("div" , "" , [theme , "parent"] , "" , container , null , {});
		data = responseText;
		var header = createNode("div" , "" , [theme , "row-wrapper" , "header"] , "" , parent , null , {});
		for (var key in data[0]) {
			createNode("div" , "" , [theme , "header" , "cell"] , key.replace(/_/g, " " ) , header , null , {});
		}
		createNode("div" , "" , [theme , "cell" , "add-button"] , "Save" , header , handleNormalButtonClick , {});

		var row = createNode("div" , "" , [theme , "row-wrapper" , "body"] , "" , parent , null , {});
		for (var key in data[0]) {
			var wrapper_node = createNode("div" , "" , [theme , "body" , "cell"] , "" , row , null , {
				"data-key" : key
			});
			if (key != "id")
				newDataList.push(createNode("input" , "" , [theme] , "" , wrapper_node , null , {
				"placeholder" : key.replace(/_/g, " " ),
				"data-key" : key
				}));
			else 
				newDataList.push(createNode("input" , "" , [theme] , "" , wrapper_node , null , {
				"placeholder" : "Set Automatically",
				"data-key" : key,
				"disabled" : "disabled"
				}));
		}
		createNode("div" , "" , [theme , "cell" , "new_save-button"] , "New" , row , handleNewSaveButtonHandler , {});

		for (var i = data.length - 1; i >= 0; i--) {
			var row = createNode("div" , "" , [theme , "row-wrapper" , "body"] , "" , parent , null , {});
			dataList[i] = [];
			for (var key in data[i]) {
				var wrapper_node = createNode("div" , "" , [theme , "body" , "cell"] , "" , row , null , {
					"data-id" : data[i]['id'],
					"data-key" : key
				});
				dataList[i].push(createNode("input" , "" , [theme] , "" , wrapper_node , null , {
					"data-id" : data[i]['id'],
					"value" : data[i][key],
					"placeholder" : key.replace(/_/g, " " ),
					"data-key" : key
				}));
			}
			createNode("div" , "" , [theme , "cell" , "delete-button"] , "Delete" , row , handleDeleteButtonClick , {
				"data-id" : data[i]['id']
			});
		};
	}

	var handleNewSaveButtonHandler = function (event) {
		var table = {};
		var str_tmp = "add_" + currentTable.toLowerCase().replace(" " , "_");
		for (var i = newDataList.length - 1; i >= 0; i--) {
			table[newDataList[i].dataset.key] = newDataList[i].value;
		};
		table[str_tmp] = true;
		postData(table);
	}

	var handleEditButtonClick = function (event) { 
		var table = {};
		var str_tmp = "show_" + currentTable.toLowerCase().replace(" " , "_");
		table[str_tmp] = true;
		fetchData(table , init_edit);
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
		stringToSend.replace(" " , "+");
		xmlhttpPost.send(stringToSend);
		xmlhttpPost.onreadystatechange = function () {
			if (xmlhttpPost.status == 200 && xmlhttpPost.readyState == 4) {
				window.location.reload();
			}
		};
	};

	var xmlhttpGet = new XMLHttpRequest();
	var fetchData = function (data , callback) {
		xmlhttpGet.open("POST" , "./model.php" , true);
		xmlhttpGet.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
		var stringToSend = "";
		for (var key in data) {
			stringToSend += key + "=" + data[key] + "&";
		}
		stringToSend = stringToSend.slice(0 , -1);
		stringToSend.replace(" " , "+");
		xmlhttpGet.send(stringToSend);
		xmlhttpGet.onreadystatechange = function () {
			if (xmlhttpGet.status == 200 && xmlhttpGet.readyState == 4) {
				var data = JSON.parse(xmlhttpGet.responseText);
				callback(data);
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
