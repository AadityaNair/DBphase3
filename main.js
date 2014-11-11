var main  = function (event) {
	var home_button,
		logout_button,
		report_button,
		admin_button,
		tables;

	var init = function () {
		home_button = document.getElementById('button-home');
		logout_button = document.getElementById('button-logout');
		report_button = document.getElementById('button-report');
		admin_button = document.getElementById('button-admin');

		if (home_button) {
			home_button.addEventListener('click' , handleHomeButtonClick , true);
		}
		if (logout_button) {
			logout_button.addEventListener('click' , handleLogoutButtonClick , true);
		}
		if (report_button) {
			report_button.addEventListener('click' , handleReportButtonClick , true);
		}
		if (admin_button) {
			admin_button.addEventListener('click' , handleAdminButtonClick , true);
		}

		tables = document.getElementsByClassName('table-list child');
		for (var i = tables.length - 1; i >= 0; i--) {
			tables[i].addEventListener('click' , handleTableButtonClick , true);
		};
	};

	var handleTableButtonClick = function (event) {
		if (event.target.id) {
			var table_name = event.target.id;
		} else {
			var table_name = "";
		}
		window.location.href = "./table_display.php?table=" + table_name;
	}

	var handleHomeButtonClick = function (event) {
		window.location.href = "./";
	};

	var handleLogoutButtonClick = function (event) {
		window.location.href = ".?logout";
	};

	var handleReportButtonClick = function (event) {
		window.location.href = "./report.php";
	};

	var handleAdminButtonClick = function (event) {
		window.location.href = "./admin.php";
	};



	var xmlhttp = new XMLHttpRequest();
	var postData = function (data) {
		xmlhttp.open("POST" , "./model.php" , true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
		var stringToSend = "";
		for (var key in data) {
			stringToSend += key + "=" + data[key] + "&";
		}
		stringToSend = stringToSend.slice(0 , -1);
		console.log(stringToSend);
		xmlhttp.send(stringToSend);
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.status == 200 && xmlhttp.readyState == 4) {
				window.location.href = "./";
			}
		};
	};

	init();
}

window.addEventListener("DOMContentLoaded" , main , true);

