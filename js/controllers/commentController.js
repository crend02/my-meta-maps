/**
* Send a POST-request to the server to get geodata
* @param {Object} callback
*/
function geodataShowController(callback) {
	var model = new GeodataShow();
	model.save(getFormData(), callback);
};

/**
 * Executes the search if the MapView is active.
 */
function executeSearch() {
	if (ContentView.active instanceof MapView) {
		ContentView.active.doSearch();
	}
}

/**
 * Resets the search if the MapView is active.
 * @param object form element, e.g. this.form
 */
function resetSearch(form) {
	if (ContentView.active instanceof MapView) {
		ContentView.active.resetSearch(form);
	}
}

/**
 * Save a certain search in a 'permalink' 
 */
function saveSearch() {
	$('#mapFilterShare').popover({
		title: Lang.t('searchShare'),
		placement: 'left auto',
		content: '<div id="permalinkContent"><img src="/img/loading.gif" />' + Lang.t('permLink')+'</div>',
		html: true,
		trigger: 'manual',
		container: '#mapDataPanel'
	});
	var model = new PermalinkSave();
	model.save(getFormData(), {
        success: function (model, response) {
			$('#permalinkContent').html('<a href="' + response.permalink + '" target="_blank">' + response.permalink + '</a>');
        },
        error: function() {
			$('#permalinkContent').html(Lang.t('permLink') + '<br />' + Lang.t('tryAgain'));
		},
		before: function() {
			$('#mapFilterShare').popover('show');
		},
		skipped: function() {
			$('#mapFilterShare').popover('toggle');
			$('#permalinkContent').html(Lang.t('manyClicks') + '<br />' + Lang.t('try15'));
		}
   });
	
}

/**
* Send a POST-request to the server
* @param {Object} model
* @param {JSON} details 
*/
function commentAddFirstStepController(model, details) {
	model.save(details, {
		
		/*
		 * Before get response of server show loading-symbol 
		 */
		before: function() {
			Progress.start('.modal-progress');
		},
		
		/*
		 * In successfulled doing first step of adding comment 
		 * remove error-messages in the formular and stop showing loading-symbol
		 * If checked geodata is invalid add error-message, else initialize second step of adding comment
		 */
        success: function (model, response) {
        	Debug.log('Try to validate URL');
			Progress.stop('.modal-progress');
        	FormErrorMessages.remove('#form-comment-firstStep');
			// Validate data
			if (typeof(response.geodata.metadata.bbox) === 'string') {
				ContentView.register(new CommentAddViewStep2({metadata: response.geodata}));
				$('#ModalAddComment').modal('hide');
				router.navigate('/comments/add');
			}
			else {
				FormErrorMessages.apply('#form-comment-firstStep', {
					url: Lang.t('bboxInvalid')
				});
			}
        },
        
        /*
		 * In failed doin first step of adding comment 
		 * add error-messages and stop showing loading-symbol
		 */
        error: function(model, response) {
        	Debug.log('Can not validate URL');
			Progress.stop('.modal-progress');
        	FormErrorMessages.apply('#form-comment-firstStep', response.responseJSON);
		}
   });
};

/**
* Send a POST-request (because no id is specified) to the server to save a comment
* @param {Object} model
* @param {JSON} details  
*/
function commentAddSecondStepController(model, details) {
	model.save(details, {
		
		/*
		 * In successfulled doing second step of adding comment 
		 * remove error-messages in the formular and show message-box
		 */
		success: function (model, response) {
			Debug.log("Adding comment was successful: " + JSON.stringify(response.responseJSON));
			FormErrorMessages.remove('#form-comment-secondStep');
			router.navigate('', {trigger: true}); // Redirect to frontpage
			MessageBox.addSuccess(Lang.t('succededAddComm'));
		},
	
	    /*
		 * In failed doing second step of adding comment 
		 * add error-messages 
		 */
		error: function (model, response) {
			Debug.log("Adding comment failed");
			FormErrorMessages.apply('#form-comment-secondStep', response.responseJSON);
		}
	});
};

/**
 * Add a comment directly at the detail-site with the comments to a geodata
 * @param {String} url 
 * @param {String} datatype 
 */
function createCommentDirectly(url, datatype, layer) {
	Debug.log('Try to add comment directly');
		
	var details = {
		"url": url,
		"datatype": datatype
	};
	
	var model = new CommentAddFirstStep();
	
	model.save(details, {
			
			/*
		 	 * In successfulled adding comment directly hide modal of  the detail-site with the comments to a geodata
		 	 * and initialize the second step of adding comments with specific parameters (set url, datatype and layer automatic)
		 	 */
	        success: function (model, response) {
	        	Debug.log('Try to get metadata');
	        	var commAddViewStep2 = new CommentAddViewStep2({metadata: response.geodata, layerID: layer});
				ContentView.register(commAddViewStep2);
	        	$('#ModalShowCommentsToGeodata').modal('hide');
				router.navigate('/comments/add');
	        },
	        
	        /*
			 * In failed adding comment directl add error-message
			 */
	        error: function(model, response) {
	        	Debug.log('Can not get metadata');
	        	MessageBox(lang.t('commentAddQuickError'));
			}
		}
		
	);
};


/**
* Send a POST-request to the server to get comments to a geodata
* @param {Object} gid
* @param {Object} cid
*/
function commentsToGeodataController(gid, cid) {
	if (typeof(cid) == 'undefined') {
		cid = 0;
	}

	var progressClass = '.comment-' + gid + '-progress';
	Progress.start(progressClass);

	var model = new CommentsToGeodata();
	model.id = gid;
	model.save(getFormData(cid), {
		
		/*
		 * In successfulled getting comments to a geodata show detail-site with the comments to the geodata
		 */
        success: function (data, response) {
        	Debug.log('Showing comments to geodata succeded');
			Progress.stop(progressClass);
			response.geodata.comment = cid;
			new CommentsShowView(response);
        },
        
        /*
         * In failed getting comments to a geodata add error-message
         */
        error: function() {
        	Debug.log('Showing comments to geodata failed');
			Progress.stop(progressClass);
			MessageBox.addError(Lang.t('failedLoadGeodata'));
		},
   });
};

/**
 * Get typed in values of the fitlers
 * @param {Object} commentId
 * @return {JSON} values of filters
 */
function getFormData(commentId) {
	
	var bbox = null;
	if (ContentView.active instanceof MapView) {
		bbox = ContentView.active.getBoundingBox();
	}
	return {
		q : $("#SearchTerms").val(),
		bbox: bbox,
		radius : $("#spatialFilter").val(),
		start: $("#filterStartTime").val(),
		end: $("#filterEndTime").val(),		
		minrating: $("#ratingFilter").val(),
		metadata : $('#includeMetadata').is(':checked'),
		comment: commentId
	};
}

/**
 * Selects a map marker by it's id in the comment view.
 * @param {int} commentId
 */
function selectMapMarker(commentId) {
	if (ModalView.active instanceof CommentsShowView) {
		ModalView.active.selectFeatureById(commentId);
	}
}

/**
 * Selects a map marker by it's id in the map view.
 * @param {int} geodataId
 */
function hoverGeodataBbox(geodataId) {
	if (ContentView.active instanceof MapView) {
		ContentView.active.selectFeatureById(geodataId);
	}
}