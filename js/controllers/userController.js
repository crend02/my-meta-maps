/**
* Send a POST-request to the server to save a registration
* @param {Object} model
* @param {JSON} inputRegister 
*/
function userRegisterController(model, inputRegister) {
	model.save(inputRegister, {
		
		/*
		 * Before get response of server show loading-symbol 
		 */
		before: function() {
			Progress.start('.modal-progress');
		},
		
		/*
		 * In successfulled registration remove error-messages in the formular, 
		 * hide the modal for registration and show a message-box  
		 */
		success: function () {
			Debug.log('Registration succeded');
			FormErrorMessages.remove('#form-register');
        	$('#ModalRegister').modal('hide');
			MessageBox.addSuccess(Lang.t('succededRegister'));
		},
	
		/*
		 * In failed registration add error-messages in the formular
		 * and remove loading-symbol 
		 */
		error: function (data, response) {
			Debug.log('Registration failed');
			Progress.stop('.modal-progress');
			FormErrorMessages.apply('#form-register', response.responseJSON);
		}
	});
};

/**
* Send a GET-request to the server to logout a user
*/
function userLogoutController() {
	var model = new UserLogout();
	
	model.fetch({
		
		/*
		 * In successfulled logout show a message-box and set authentificated user
		 */
		success: function(){
			Debug.log('Logout succeded');
			MessageBox.addSuccess(Lang.t('succededLogout'));
			AuthUser.setUser();
		},
		
		/*
		 * In failed logout show a message-box
		 */
		error: function(){
			Debug.log('Logout failed');
			MessageBox.addError(Lang.t('failedLogout'));
		}
	});
}

/**
* Send a POST-request to the server to login a user
* @param {Object} model
* @param {JSON} inputLogin 
*/
function userLoginController(model, inputLogin) {
	model.save(inputLogin, {
		
		/*
		 * Before get response of server show loading-symbol 
		 */
		before: function() {
			Progress.start('.modal-progress');
		},
		
		/*
		 * In successfulled login remove error-messages in the formular, 
		 * hide the modal for login, show a message-box and set the user 
		 * as authentificated
		 */
		success: function (model, response) {
			Debug.log('Login succeded');
			FormErrorMessages.remove('#form-login');
        	$('#ModalLogin').modal('hide');
			MessageBox.addSuccess(Lang.t('succededLogin'));
			AuthUser.setUser(response.user.name);
			if (config.locale !== response.user.language) {
				registeredUserChangedLanguage();
			}
		},
	
		/*
		 * In failed login add error-messages in the formular
		 * and remove loading-symbol 
		 */
		error: function () {
			Debug.log('Login failed');
			Progress.stop('.modal-progress');
			var msg = Lang.t('failedLogin');
			var errorMessages = {
				identifier: msg,
				password: msg
			};
			FormErrorMessages.apply('#form-login', errorMessages);
		}
	});
};

/**
* Send a POST-request to the server to login a user
* @param {Object} model
* @param {JSON} inputChangeGeneral 
*/
function userChangeGeneralController(model, inputChangeGeneral) {
	model.save(inputChangeGeneral, {
		
		/*
		 * Before get response of server show loading-symbol 
		 */
		before: function() {
			Progress.start('.modal-progress');
		},
		
		/*
		 * In successfulled changing profile remove error-messages in the formular, 
		 * hide the modal for changing profile, show a message-box and add the new settings
		 */
		success: function (model) {
			Debug.log('Change general user data succeded');
			FormErrorMessages.remove('#form-changeGeneral');
			$('#ModalUserAccountGeneral').modal('hide');
			MessageBox.addSuccess(Lang.t('succededChangeGeneral'));
			// Set new username 
			AuthUser.setUser(model.get('name'));
			// At changing language load site again
			if (config.locale !== model.get('language')) {
				registeredUserChangedLanguage();
			}
		},
	
		/*
		 * In failed changing profile add error-messages in the formular
		 * and remove loading-symbol 
		 */
		error: function (model, response) {
			Debug.log('Change general user data failed');
			Progress.stop('.modal-progress');
			FormErrorMessages.apply('#form-changeGeneral', response.responseJSON);
		}
	});
};

/**
* Send a POST-request to the server to login a user
* @param {Object} model
* @param {JSON} inputChangePassword 
*/
function userChangePasswordController(model, inputChangePassword) {
	model.save(inputChangePassword, {
		
		/*
		 * Before get response of server show loading-symbol 
		 */
		before: function() {
			Progress.start('.modal-progress');
		},
		
		/*
		 * In successfulled changing password remove error-messages in the formular, 
		 * hide the modal for changing password and show a message-box
		 */
		success: function () {
			Debug.log('Change password succeded');
			FormErrorMessages.remove('#form-changePassword');
			$('#ModalUserAccountPassword').modal('hide');
			MessageBox.addSuccess(Lang.t('succededChangePW'));
		},
	
	    /*
		 * In failed changing profile add error-messages in the formular
		 * and remove loading-symbol 
		 */
		error: function (data, response) {
			Debug.log('Change password failed');
			Progress.stop('.modal-progress');
			FormErrorMessages.apply('#form-changePassword', response.responseJSON);
		}
	});
};

/**
 * Called when the language of a registered user should be changed on the page.
 */
function registeredUserChangedLanguage() {
	window.location.href = '/';
}

/**
 * Send POST-request to the server to check user data
 * 
 * @param {Object} model
 * @param {String} idInput 
 * @param {String} idForm
 * @param {String} key
 */
function userCheckDataController(idInput, idForm, key) {
	var inputCheckData = {};
	inputCheckData[key] = $("#" + idInput).val();
	var model = new UserCheckData();
	
	model.save(inputCheckData, {
		
		/*
		 * Before get response of server show loading-symbol 
		 */
		before: function() {
			Progress.start('.modal-progress');
		},
		
		/*
		 * In successfulled checking user data add success-messages to the formular
		 */
		success: function () {
			Debug.log('User data has not already been taken.');
			Progress.stop('.modal-progress');
			responseJSON = {};
			responseJSON[key] = Lang.t('specUse');
			FormErrorMessages.applyPartially('#'+idForm, responseJSON, true);
		},
	
		/*
		 * In failed checking user data add error-messages to the formular
		 */
		error: function (data, response) {
			Debug.log('User data has already been taken.');
			Progress.stop('.modal-progress');
			FormErrorMessages.applyPartially('#'+idForm, response.responseJSON, false);
		}

	});
};
