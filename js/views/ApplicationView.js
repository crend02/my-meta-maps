/**
 * View for whole content 
 * All views that extend this view, will shown in this view
 * The "el" property references the DOM object created in the browser. 
 * Every Backbone.js view has an "el" property, and if it is not defined, 
 * Backbone.js will construct its own, which is an empty div element.
 * @namespace
 */
ContentView = Backbone.View.extend({
	el: $('#content'),
	templateCache: [],
	
	/**
	 * Constructor of this view
	 * Call function configure()
	 * @param {Object} options
	 * @memberof ContentView
	 */
	constructor: function (options) {
		this.configure(options || {});
		Backbone.View.prototype.constructor.apply(this, arguments);
	},
	
	/**
	 * Configure what happens in the constructor
	 * @param {Object} options
	 * @memberof ContentView
	 */
	configure: function (options) {
		if (this.options) {
			options = _.extend({}, _.result(this, 'options'), options);
		}
		this.options = options;
	},
	
	/**
	 * Called if this view is initialized
	 * Call method render
	 *  
	 * @memberof ContentView
	 */
	initialize: function () {
		this.render();
	},
	
	/**
	 * Abstract function
	 * Called if this view is loaded 
	 * @memberof ContentView
	 */
	onLoaded: function () {
	},
	
	/**
	 * Return false
	 * 
	 * @return {boolean} false
	 * @memberof ContentView
	 */
	noCache: function(url) {
		return false;
	},
	
	/**
	 * Try to get template for the view
	 * 
	 * @param {String} url
	 * @param {Object} callback 
	 * @memberof ContentView
	 */
	loadTemplate: function (url, callback) {
		if (typeof (this.templateCache[url]) == 'string' && !this.noCache(url)) {
			callback(this.templateCache[url]);
		}
		else {
			var that = this;
			$.get(url, function(data) {
				that.templateCache[url] = data;
				callback(data);
			}, 'html');
		}
		
	},
	
	/**
	 * Render methods loadTemplate(), getPageTemplate(), getPageContent() and onLoaded() from this class
	 * @memberof ContentView
	 */
	render: function () {
		var that = this;
		this.loadTemplate(this.getPageTemplate(), function (data) {
			template = _.template(data);
			var vars = {
				data: that.getPageContent(),
				config: config,
				ViewUtils: ViewUtils
			};
			that.$el.html(template(vars));
			that.onLoaded();
		});
	},
	
	/**
	 * Abstract method 
	 * @return null
	 * @memberof ContentView
	 */
	getPageTemplate: function () {
		Debug.log('Error: Called abstract method!');
		return null;
	},
	
	/**
	 * Remove callbacks, events, listeners, etc.
	 * 
	 * Call methods stopListening(), undelegateEvents() and unbind()
	 * @memberof ContentView
	 */
	close: function () {
		// Normally we should remove the content from the DOM, but this is delayed for some reasons
		// and destroys our cached and "fast" templates. Therefore we skip this as the DOM node 
		// content is replaced anyway.
		// this.$el.html('');

		// Remove callbacks, events, listeners etc.
		this.stopListening();
		this.undelegateEvents();
		this.unbind();
	},
	
	/**
	 * Abstract method
	 * @return {Object} '{}'
	 * @memberof ContentView
	 */
	getPageContent: function () {
		return {};
	}
});

// Statics
ContentView.active = null;
ContentView.register = function (view) {
	if (ContentView.active !== null) {
		ContentView.active.close();
	}
	ContentView.active = view;
};

/**
 * View for modals
 * All views that extend this view, will shown in this view
 * @extends ContentView
 * @namespace
 */
ModalView = ContentView.extend({
	el: $('#modal'),
	
	/**
	 * Called after modal is loaded (and not opened yet)
	 * Call methods modal(), showProgress() and onOpend from this class
	 * 
	 * @override
	 * @memberof ModalView
	 */
	onLoaded: function () {
		ModalView.active = this;
		this.on('hidden.bs.modal', function () {
			ModalView.active = null;
		});
		this.modal();
		this.showProgress();
		this.onOpened();
	},
	
	/**
	 * Called after modal is opened
	 * @memberof ModalView
	 */
	onOpened: function () {

	},
	
	/**
	 * Show a certain modal 
	 * @memberof ModalView
	 */
	modal: function () {
		var modal = $('#modal').find('.modal');
		modal.modal('show');
		// If we opened the modal without having a content view loaded (e.g. after opening a 
		// permalink), we are redirecting the user to the frontpage.
		modal.on('hidden.bs.modal', function() {
			if (ContentView.active === null) {
				router.navigate('/', true);
			}
		});
	},
	
	/**
	 * Show a modal for progress from helpers.js 
	 * 
	 * @memberof ModalView
	 */
	showProgress: function () {
		Progress.show('.modal-progress');
	}
});
ModalView.active = null;

/**
 * View for the map, the filters and the list of geodata 
 * @namespace
 */
MapView = ContentView.extend({
	// OpenLayers/Map
	map: null,
	polyLayer: null,
	externalHover: null,
	selectMouseMove: null,
	mapSearchExecuted: true,
	// Default options for filters
	options: {
		searchHash: null,
        q: '',
        bbox: null,
        radius: null,
        minrating: null,
        metadata: false,
        time: {
            start: '',
            end: ''
        }
	},
	
	/**
	 * Initialize main-map
	 * @override
	 * @memberof MapView
	 */
	onLoaded: function () {
		// this for the callbacks
		var that = this;
		
		var view = Mapping.getDefaultView();
		// When the map view changes we need to search again
		view.on('change:center', function() { that.onExtentChanged(); });
		view.on('change:resolution', function() { that.onExtentChanged(); });
		view.on('change:rotation', function() { that.onExtentChanged(); });

		// Layer with the bounding boxes
		this.polyLayer = Mapping.getBBoxLayer(Mapping.getBBoxStyle(true));

		this.map = new ol.Map({
			layers: Mapping.getBasemps([this.polyLayer]),
			target: 'map',
			controls: Mapping.getControls(),
			view: view
		});

		// Hovering the links of the geodata should lead to a highlighted bbox
		this.externalHover = new ol.interaction.Select();
		this.map.addInteraction(this.externalHover);
		// highlight geometry on mousemouve
		this.selectMouseMove = new ol.interaction.Select({
			condition: ol.events.condition.mouseMove
		});
		this.selectMouseMove.getFeatures().on('change:length', function (e) {
			if (e.target.getArray().length === 0) {
				//no features selected
				$('.geodata-highlighter').removeClass('geodata-highlighter');
			} else {
				// highlight the comments
				$('#GeodataLink'+e.target.item(0).getId()).addClass('geodata-highlighter');
			}
		});
		this.map.addInteraction(this.selectMouseMove);
		// select geometry on mouseclick and open CommentView
		var select = new ol.interaction.Select({
			style: Mapping.getBBoxStyle(true)
		});
		select.getFeatures().on('change:length', function (e) {
			if (e.target.getArray().length === 0) {
				//no features selected
			} else {
				//open CommentView of the feature
				router.geodata(e.target.item(0).getId());
			}
		});
		this.map.addInteraction(select);
		
		// The basic page is now loaded. Now we set the default data depending on the context.
		if (this.options.searchHash) {
			// We have a search permalink and need to get the stored parameters.
			var model = new PermalinkLoad();
			model.id = this.options.searchHash;
			model.fetch({
				before: function() {
					Progress.start('.filter-progress');
				},
				success: function(model, response) {
					Progress.stop('.filter-progress');
					that.inititlizeData(response.permalink);
				},
				error: function() {
					Progress.stop('.filter-progress');
					MessageBox.addError(Lang.t('paramNoLoad'));
					that.inititlizeData();
				}
			});
		}
		else {
			// Default map view without any preset filters.
			this.inititlizeData();
		}
	},
	
	/**
	 * Initialize data for the main-map
	 * @param {Object} params 
	 * @memberof MapView
	 */
	inititlizeData: function(params) {
		// Override the given params in this.options
		this.configure(params);
		
		// Set the keywords
		$('#SearchTerms').val(this.options.q);

		// Set the bbox
		var view = this.map.getView();
		if (this.options.bbox) {
			// fit the extent to the given bbox
			var geom = Mapping.fromWkt(this.options.bbox, this.map);
			if (geom) {
				view.fitExtent(geom.getExtent(), this.map.getSize());
			}
		}
		else {
			Mapping.geolocate(view);
		}

		// Check the "Include metadata" checkbox
		$('#includeMetadata').prop('checked', this.options.metadata);


		// Set the start and end time
		this.updateDatePicker("#filterStartTime", this.options.time.start);
		this.updateDatePicker("#filterEndTime", this.options.time.end);

		// Set the radius und rating
		$('#spatialFilter').barrating({
			initialRating: this.options.radius,
			showValues: true,
			showSelectedRating: false,
			onSelect: executeSearch,
			onClear: executeSearch
		});
		$('#ratingFilter').barrating({
			initialRating: this.options.minrating,
			showSelectedRating: false,
			onSelect: executeSearch,
			onClear: executeSearch
		});

		// Execute the search
		this.doSearch();
	},
	
	/**
	 * Update the datePicker to a new format
	 * @memberof MapView
	 */
	updateDatePicker: function(selector, dateIso) {
		if (_.isEmpty(dateIso)) {
			return;
		}
		var regexp = /^(\d{4})-(\d\d)-(\d\d)/g;
		var matches = regexp.exec(dateIso);
		if (matches) {
			var value = config.datepicker.format;
			value = value.replace(/yy(yy)?/i, matches[1]);
			value = value.replace(/m(m)?/i, matches[2]);
			value = value.replace(/d(d)?/i, matches[3]);
			$(selector).val(value);
		}
	},
	
	/**
	 * Call method executeSearch from commentController.js if mapSearchExecuted is not true
	 * @memberof MapView
	 */
	onExtentChanged: function() {
		// When multiple events occur in a certain time span (500ms) then only search once.
		this.mapSearchExecuted = false;
		var that = this;
		window.setTimeout(function() {
			if (!that.mapSearchExecuted) {
				executeSearch();
				that.mapSearchExecuted = true;
			}
		}, 500);
	},
	
	/**
	 * Search geodata
	 * Initialize a 'geodataShowController' from file 'commentView.js'
	 * In successfull case show geodata in the main-map
	 * In failed case show a message-box
	 * @memberof MapView
	 */
	doSearch: function () {
		var that = this;
		geodataShowController({
			before: function () {
				Progress.start('.geodata-progress');
			},
			success: function (model, response) {
				new GeodataShowView(response);
				Progress.stop('.geodata-progress');
				that.addGeodataToMap(response);
			},
			error: function (model, response) {
				MessageBox.addError(Lang.t('noLoad'));
				Progress.stop('.geodata-progress');
			},
			skipped: function () {
				Progress.stop('.geodata-progress');
			}
		});
	},
	
	/**
	 * Reset search
	 * Reset all inputs and do a new search with empty inputs 
	 * @memberof MapView
	 */
	resetSearch: function (form) {
		form.reset();
		// Remove visible feedback of barrating.
		$('#spatialFilter').barrating('clear');
		$('#ratingFilter').barrating('clear');
		this.doSearch();
	},
	
	/**
	 * Calculates the current bounding box of the map and returns it as an WKt String
	 * @return a bounding box
	 * @memberof MapView
	 */
	getBoundingBox: function () {
		var mapbbox = this.map.getView().calculateExtent(this.map.getSize());
		var geom = new ol.geom.Polygon([[new ol.extent.getBottomLeft(mapbbox), new ol.extent.getBottomRight(mapbbox), new ol.extent.getTopRight(mapbbox), new ol.extent.getTopLeft(mapbbox), new ol.extent.getBottomLeft(mapbbox)]]);
		return Mapping.toWkt(geom, this.map);
	},
	
	/**
	 * Add the bboxes from the Geodata to the map
	 * @memberof MapView
	 */
	addGeodataToMap: function (data) {
		this.polyLayer.getSource().clear();
		// Clear the selection handler aswell or there will remain a marked bbox
		this.selectMouseMove.getFeatures().clear();
		this.externalHover.getFeatures().clear();
		// gets each bbox(wkt format), transforms it into a geometry and adds it to the vector source 
		for (var index = 0; index < data.geodata.length; index++) {
			Mapping.addWktToLayer(this.map, this.polyLayer, data.geodata[index].metadata.bbox, false, data.geodata[index].id);
		}
	},
	
	/**
	 * Return the url for the map-template
	 * @return {String} url for the map-template
	 * @memberof MapView
	 */
	getPageTemplate: function () {
		return '/api/internal/doc/map';
	},
	
	/**
	 * Adds an Feature from a selected Comment to the Collection of the ol.interaction
	 * @param {int} id
	 * @pa
	 * @memberof CommentsShowView
	 */
	selectFeatureById: function(id){
		Mapping.selectFeatureById(id, this.polyLayer, this.externalHover);
	}

});

/**
 * View for imprint site
 * @extends ContentView
 * @namespace
 */
AboutView = ContentView.extend({
	
	/**
	 * Return url for the template of the imprint
	 * @return {String} url for the template of the imprint
	 * @memberof AboutView
	 */
	getPageTemplate: function () {
		return 'api/internal/doc/about';
	}
});

/**
 * View for help site 
 * @extends ContentView
 * @namespace
 */
HelpView = ContentView.extend({
	
	/**
	 * Return url for the template of the help-site
	 * @return {String} url for the template of the help-site
	 * @memberof HelpView
	 */
	getPageTemplate: function () {
		return 'api/internal/doc/help';
	}
});