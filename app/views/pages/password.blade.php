<div class="modal fade" id="ModalUserAccountPassword" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
				<h4 class="modal-title" id="meinModalLabel">Passwort ändern</h4>
			</div>
			
			<div class="modal-body">
				
				<form id="form-changePassword" onsubmit="return false">
					
					<div class="row form-group form-group-marginSides">
						<label for="old_password">Altes Passwort</label>
						<input class="form-control" name="old_password" id="inputChangeOldPassword" type="password">
						<div class="error-message"></div>
					</div>
							
					<div class="row form-group form-group-marginSides">
						<label for="password">Neues Passwort</label>
						<input class="form-control" name="password" id="inputChangePassword" type="password">
						<div class="error-message"></div>
					</div>
					
					<div class="row form-group form-group-marginSides">
						<label for="password_confirmation">Neues Password wiederholen</label>
						<input class="form-control" name="password_confirmation" id="inputChangePasswordRepeat" type="password">
						<div class="error-message"></div>
					</div>
						
					<button type="submit" class="btn btn-primary" id="changePasswordBtn">Passwort ändern</button>
							
				</form>	
				
			</div>
			
		</div>
	</div>
</div>