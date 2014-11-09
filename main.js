var main  = function (event) {
	var home_button,
		logout_button,
		report_button,
		admin_button;

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
	};

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

	init();
}

window.addEventListener("DOMContentLoaded" , main , true);

