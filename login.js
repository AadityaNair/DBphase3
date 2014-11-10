var login = function (event) {
	var login_button,
		error_message,
		register_button;
	
	var init = function () {
		login_button = document.getElementById('button-login');
		if (login_button) {
			login_button.addEventListener('click' , handleLoginButtonClick , true);
		}
		register_button = document.getElementById('button-register');
		if (register_button) {
			register_button.addEventListener('click' , handleRegisterButtonClick , true);
		}
		error_message = document.getElementById('error');
	}

	var handleLoginButtonClick = function (event) {
		postData({
			'user_id' : document.getElementById('user_id').value,
			'password' : document.getElementById('password').value,
			'login_request' : true			
		});
	}

	var handleRegisterButtonClick = function (event) {
		postData({
			'user_id' : document.getElementById('user_id').value,
			'password' : document.getElementById('password').value,
			'name' : document.getElementById('name').value,
			'register_request' : true,
		});
	}

	var xmlhttp = new XMLHttpRequest();
	var postData = function (data) {
		xmlhttp.open("POST" , "./model.php" , true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
		var stringToSend = "";
		for (var key in data) {
			stringToSend += key + "=" + data[key] + "&";
		}
		stringToSend = stringToSend.slice(0 , -1);
		xmlhttp.send(stringToSend);
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.status == 200 && xmlhttp.readyState == 4) {
				error_message.innerHTML = xmlhttp.responseText;
				if (xmlhttp.responseText.indexOf("Sucess") != -1) {
					window.setTimeout (function() {
						window.location.reload();
					} , 1000);
				}
			}
		};
	};

	init();
}

window.addEventListener('DOMContentLoaded' , login , true);