<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Client Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines are send to the client as JSON file to 
	| be used as javascript language phrases at client-side.
	|
	*/

	//variables for frontpage.blade.php
	'register' => 'Register',
	'addComment' => 'Add comment',
	'profilChange' => 'Edit profil',
	'pwchange' => 'Change password',
	'guest' => 'Guest',
	'login' => 'Login',
	'imprint' => 'Imprint',
	'help' => 'Help',
	'userinfo' => 'User Guide',
	'clicktop' => 'If you are new to My Meta Maps and are wondering how to get started click ',
	'furtherInfo' => '.',

	//variables for \app\views\pages\help.blade.php
	'headline' => 'The help contains the FAQ and how to use My Meta Maps',
	'whatIsMMMTitle' => 'What is My Meta Maps?',
	'whatIsMMM' => 'My meta maps is a web directory that allows easy retrieval of geodata based on aggregated metadata and user reviews.',
	'howtoReg' => 'How to register?',
	'howtoLogin' => 'How to login?',
	'howtoComm' => 'How to add a comment?',
	'howtoChangeUserdata' => 'How do I change my data?',
	'whichFilter' => 'Which filters are available?',
	'howtoSeeComments' => 'How can I see the comments to a geodata?',
	'howtoShare' => 'Share My Meta Maps with other people',
	'howtoLoginViaOAuth' => 'Login via a third-party vendor',
	'howtoChangeGeneral' => 'How do I change my profile',
	'howtoChangePassword' => 'How do I change my password',
	'filterInfoTitle' => 'Informations about the filters',
	'filterInfo' => 'Basically, the filters refer to the comments to spatial data sets. But if you want to include the metadata in a keyword search, you can do this using the appropriate check box.',
	'spatialFilter' => 'Spatial filter',
	'timeFilter' => 'Filter by time',
	'rateFilter' => 'Filter by rating',
	'keywordSearch' => 'Search for keywords',
	'commentsFurtherInfosTitle' => 'Was sehe ich nun?',
	'buttonReg' => 'In order to register on My Meta Maps you just have to click the button:',
	'buttonLogin' => 'After the registration you can login via the following button on the upper right side:',
	'loginViaOAuth' => 'Alternatively you can register both via Facebook, GitHub, Google and Twitter. Automatically an account for my meta maps will be created for you.',
	'changeGeneral' => 'In the upper right side is a button with your profile name. There you can go to a view to change the data in your profile. 
	 You can both change your user name and your email address and select your preferred language.',
	'changePassword' => 'In the upper right side is a button with your profile name. There you can go to a view to change your password.',
	'buttonComment' => 'In the upper right side you can find the button for adding a comment:',
	'noRegNec' => 'It is not necessary to be registrated or logged in to add a comment.',
	'addCommentSteps' => 'Adding a comment is made in two steps:',
	'addCommentStepOne' => 'Enter the URL of a geodata and select the convenient data format. If it comes to problems here, the problems will be described to you.',
	'addCommentStepTwo' => 'Here you can set a title for the geodata, if there are no comments yet on this, you can select a layer, if available, enter a text, create a geometry,
	 set a timerange and a rating.',
	'addCommentNote' => 'Note: The text is mandatory. When you add a geometry, you can choose between point, line and polygon, but yo can only add one geometry.',
	'addCommentTipp' => 'Tip: In the view to comments of a geodata you can add a commenty directly and so you avoid the first step.',
	'acceptedFormats' => 'My Meta Maps accepts the following data-formats:',
	'surrounding' => 'The spatial filter allows you to select datasets within a radius arround the center of the map',
	'searchDist' => 'The search is possible in predefined steps from 5 km to 500 km.',
	'timeFiltDef' => 'The timefilter allows you to select datasets within defined timeranges.',
	'timeStartEnd' => 'To define the timerange you have to set a starting date and an ending date.',
	'rateDef' => 'The rating-filter allows you to select datasets with a defined rating.',
	'rateScale' => 'The ratings can reach from 1 to 5 stars.',
	'keyDef' => 'The keyword-search allows you to search for words that are contained in comments.',
	'seeComments' => 'In the lower right side you can see a list with geodata that - convenient to the filters - have comments. By a click you will come to a view with the comments.
	 You will shown how much comments there are to this geodata. If the filters are activated, this number will conform and in the view with the comments there will be only shown the selected comments.',
	'commentsFurtherInfos' => 'You will see a list with general comments and to the respective layers.
	 By click on the respective element you can see the respective comments. Further you will see from which one the comment is, the rating and the timerange.
	 On the rigth side you can see general and metadata and on a map the bounding box to the geodata.',
	'shareMMM' => 'In the list with the geodata and in the view with the comments to a geodata you will see this symbol',
	'shareMMMFurtherInfos' => 'With it you can share your filtered list of geodata, the list of comments to a certain geodata and a single comment.',

	//variables for \app\views\pages\about.blade.php
	'imprint' => 'Imprint',
	'license' => 'License',
	'contact' => 'Contact',
	'intro' => 'My Meta Maps has been developed by students of the institute for geoinformatics of the WWU Münster.',
	'team' => 'The team consists of',
	'pubAdress' => 'Link of the public data interface',
	'libs' => 'Used libraries',

	//variables for \app\views\pages\addCommentFirstStep.blade.php
	'url' => 'URL',
	'createComm' => 'Create comment',
	'dataFormat' => 'Data format',
	'chooseFormat' => 'Please choose data format',
	'create' => 'Create',

	//variables for \app\views\pages\addCommentSecondStep.blade.php
	'enterData' => 'Enter data',
	'commNoLay' => 'Don´t allocate comment to a Layer',
	'title' => 'Title',
	'freetext' => 'Your comment',
	'spatial' => 'Spatial allocation of the comment',
	'timerange' => 'Timerange',
	'rating' => 'Rating',
	'addMeta' => 'Additional metadata',
	'lang' => 'Language',
	'explane' => 'Explanation',
	'tags' => 'Tags',
	'copyright' => 'Copyright',

	//variables for \app\views\pages\login.blade.php
	'mailname' => 'Email address / Username',
	'pw' => 'Password',
	'stay' => 'Stay logged in?',

	//variables for \app\views\pages\map.blade.php
	'setFilter' => 'Set filter',
	'reset' => 'Reset',
	'metaUse' => 'Include metadata for search',
	'search' => 'Search keyword',
	'searchTerm' => 'Search term(s)',
	'startEnd' => 'Choose start and endpoint',
	'buffer' => 'Set a radius in km',
	'rateHigh' => 'Rating higher than or equal to ...?',
	'geodata' => 'Geodatasets',
	'share' => 'Share',

	//variables for \app\views\pages\password.blade.php
	'oldpw' => 'Old password', 
	'newpw' => 'New password',
	'pwagain' => 'Repeat new password',
	'save' => 'Save',
	'loginAgain' => 'You are not logged in. Please log in again to change your password.',
	
	//variables for \app\views\pages\register.blade.php
	'user' => 'Username',
	'mail' => 'Email address',
	
	//variables for \app\views\pages\userAccount.blade.php
	'lang' => 'Language',
	'loginAgainAcc' => 'You are no longer logged in. Please log in again to change your account data.',
	
	//variables for \app\views\pages\showCommentsToGeodata.blade.php
	'noComm' => 'There are no general comments',
	'noCommLayer' => 'There are no comments to this layer.',
	'adress' => 'Address',
	'dataFormatComm' => 'Data format',
	'comments' => 'Comments',
	'total' => 'total',
	'map' => 'Map',
	'metadata' => 'Metadata',
	'description' => 'Description',
	'startingDate' => 'Beginning',
	'endingDate' => 'Ending',
	'author' => 'Author',
	'generalData' => 'General data',
	'layer' => 'Layer:',
	'permlink' => 'Permanent link',
	'unknown' => 'Unknown',

	//variables for \app\views\pages\showCommentsToGeodataBit.blade.php
	'anonym' => 'Anonym',
	'rate' => 'Rating:',
	'stars' => 'Stars',
	'notSpec' => 'Not specified',
	'geoData' => 'Geodata available',

	//variables for \app\views\pages\show GeodataBit.blade.php
	'noSearch' => 'No data matches your search.',

	//variables for \app\views\emails\auth\reminder.blade.php
	'pwReset' => 'Password Reset',
	'resetForm' => 'To reset your password, complete this form:',
	'expire' => 'This link will expire in',
	'minutes' => 'minutes',

	//variables for \app\views\oauth-alert.de.blade.php
	'hint' => 'Note:',
	'extAuth' => 'You authentificated via an external provider. For that case we created a My Meta Maps account for you. You can change your account data here. Your data at the external provider stays untouched.',
);
