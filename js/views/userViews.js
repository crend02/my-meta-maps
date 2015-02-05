/**
 * View for register an user 
 * @extends ModalView
 * @namespace
 */
RegisterView = ModalView.extend({

	/**
	 * Return url for the template of the registration
	 * @return {String} url for the template of the registration
	 * @memberof RegisterView
	 */
	getPageTemplate: function() {
		return '/api/internal/doc/register';
	},
	
	events: {
    	"click #registerBtn": "register"
    },

	/**
	 * Called if a user want to register
	 * Call the method userRegisterController from the file userController.js 
	 * @memberof RegisterView
	 */
	register: function(event) {
		Debug.log('Trying to register');

		// Creates details of a registration with typed in values
		var inputRegister = {
			"name" : $("#inputNameForRegister").val(),
			"email" : $("#inputMailForRegister").val(),
			"password" : $("#inputPasswordRegister").val(),
			"password_confirmation" : $("#inputPasswordRepeat").val()
		};

		userRegisterController(new UserRegister(), inputRegister);
	}
});

/**
 * View for login as an user 
 * @extends ModalView
 * @namespace
 */
LoginView = ModalView.extend({

	/**
	 * Return url for the template of the login
	 * @return {String} url for the template of the login
	 * @memberof LoginView
	 */
	getPageTemplate: function() {
		return '/api/internal/doc/login';
	},
	
	events: {
    	"click #loginBtn": "login"
    },

	/**
	 * Called if a user want to login
	 * Call the method userLoginController from the file userController.js 
	 * @memberof LoginView
	 */
	login: function(event) {
		Debug.log('Try to login');
		
		// Creates details of a login with typed in values
		var inputLogin = {
			credentials: {
				identifier : $("#inputUsername").val(),
				password : $("#inputPasswordLogin").val(),
				remember : $("#remember").is(":checked")
			}
		};
		
		userLoginController(new UserLogin(), inputLogin);
	}
});

/**
 * View for change general user data as an registered user
 * @extends ModalView
 * @namespace
 */
ProfileView = ModalView.extend({
	
	/**
	 * Return url for the template of the profil of a registred user
	 * @return {String} url for the template of the profil of a registred user
	 * @memberof ProfileView
	 */
	getPageTemplate: function() {
		return '/api/internal/doc/userAccount';
	},
	
	/**
	 * Sets that this view is not cached
	 * @return {boolean} true  
	 * @memberof ProfileView
	 */
	noCache: function(url) {
		// The templates contain the user data, therefore we shouldn't cache them!
		return true;
	},
	
	events: {
		"click #changeGeneralDataBtn": "changeGeneral"
	},
	
	/**
	 * Called if a user want to change the profil
	 * Call the method userChangeGeneralController from the file userController.js 
	 * @memberof ProfileView
	 */
	changeGeneral: function(event) {
		Debug.log('Try to change general user data');
		
		// Creates details of a change of general user data with typed in values
		var inputChangeGeneral = {
			name: $("#inputChangeUsername").val(),
			email: $("#inputChangeMail").val(),
			language: $("#inputChangeLanguage").val()
		};
		
		userChangeGeneralController(new UserChangeGeneral(), inputChangeGeneral);
	},

});

/**
 * View for change the password as an registered user
 * @extends ModalView
 * @namespace
 */
PasswordView = ModalView.extend({
	
	/**
	 * Return url for the template of the formular to change the password
	 * @return {String} url for the template of the formular to change the password
	 * @memberof PasswordView
	 */
	getPageTemplate: function() {
		return '/api/internal/doc/password';
	},
	
	events: {
		"click #changePasswordBtn": "changePassword"
	},
	
	/**
	 * Called if a user want to change the password
	 * Call method userChangePasswordControlle from the file userController.js
	 * @param {Object} event
	 * @memberof PasswordView
	 */
	changePassword: function(event) {
		Debug.log('Try to change password of user');
		
		var oldPw = null;
		// No old password needed when authenticated with oauth
		if ($("#inputChangeOldPassword").size() > 0) {
			oldPw = $("#inputChangeOldPassword").val();
		}
		
		// Creates details of a change of password of a user with typed in values
		var inputChangePassword = {
			old_password: oldPw,
			password: $("#inputChangePassword").val(),
			password_confirmation: $("#inputChangePasswordRepeat").val()
		};
		
		userChangePasswordController(new UserChangePassword(), inputChangePassword);
	}
});