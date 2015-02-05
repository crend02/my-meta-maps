<!-- Headline of userinfo -->
<h1>@lang('misc.headline')</h1>
<!-- End of headline -->

<div class="row clearfix">
	<div class="col-md-6 column">
		<h2>@lang('misc.whatIsMMMTitle')</h2>
			<div class='pos_left'>
				@lang('misc.whatIsMMM')
			</div>
		<!-- Beginning howto registration -->
		<h2>@lang('misc.howtoReg')</h2>
			<div class='pos_left'>
				@lang('misc.buttonReg') <a href="javascript:router.register();" class="btn btn-primary btn-xs" id="registerBtn">@lang('misc.register')&nbsp;<span class="glyphicon glyphicon-edit"></span></a> 
			</div>
		<!-- End of howto registration -->
		<!-- Beginning howto sign in -->
		<h2>@lang('misc.howtoLogin')</h2>
			<div class='pos_left'>
				@lang('misc.buttonLogin') <a href="javascript:router.loginout();" class="btn btn-primary btn-xs" id="loginBtn"><span id="logBtnText">@lang('misc.login')</span>&nbsp;<span class="glyphicon glyphicon-log-in" id="loginBtnIcon"></span></a>
			</div>
			<h3>@lang('misc.howtoLoginViaOAuth')</h3>
				<div class='pos_left'>
					@lang('misc.loginViaOAuth')<br>
				</div>
		<!-- End of howto sign in -->
		<!-- Beginning howto change user data -->
		<h2>@lang('misc.howtoChangeUserdata')</h2>
			<h3>@lang('misc.howtoChangeGeneral')</h3>
				<div class='pos_left'>
					@lang('misc.changeGeneral')<br>
				</div>
			<h3>@lang('misc.howtoChangePassword')</h3>
				<div class='pos_left'>
					@lang('misc.changePassword')<br>
				</div>
		<!-- End of howto change user data -->
		<!-- Beginning howto comment -->
		<h2>@lang('misc.howtoComm')</h2>
			<div class='pos_left'>
				@lang('misc.buttonComment') <a href="javascript:router.addComment();" class="btn btn-primary btn-xs" id="commentBtn">@lang('misc.addComment')&nbsp;<span class="glyphicon glyphicon-plus-sign"></span></a><br><br>
				@lang('misc.noRegNec')<br>
				<br>
				@lang('misc.addCommentSteps')<br>
				<ol>
					<li>@lang('misc.addCommentStepOne')</li>
					<li>@lang('misc.addCommentStepTwo')</li>
				</ol>
				@lang('misc.addCommentNote')<br>
				<br>@lang('misc.addCommentTipp')<br>
				<br>@lang('misc.acceptedFormats') 
				<a href="http://www.opengeospatial.org/standards/kml" target="_blank">KML</a>,
				<a href="http://microformats.org/wiki/microformats-2" target="_blank">microformats2</a>,
				<a href="http://www.opengeospatial.org/standards/cat" target="_blank">OGC Catalogue Service</a>,
				<a href="http://www.opengeospatial.org/standards/wcs" target="_blank">OGC WCS</a>,
				<a href="http://www.opengeospatial.org/standards/wfs" target="_blank">OGC WFS</a>,
				<a href="http://www.opengeospatial.org/standards/sos" target="_blank">OGC SOS</a>,
				<a href="http://www.opengeospatial.org/standards/wms" target="_blank">OGC WMS</a>,
				<a href="http://www.opengeospatial.org/standards/wmts" target="_blank">OGC WMTS</a>
				<br>
				<!-- Beginning format-list -->
				
				<!-- Ending format-list -->
			</div>
		<!-- End of howto comment -->
	</div>
	
	<div class="col-md-6 column">
		<!-- Beginning howto filter -->
		<h2>@lang('misc.whichFilter')</h2>
			<h3>@lang('misc.filterInfoTitle')</h3>
				<div class='pos_left'>
					@lang('misc.filterInfo')<br>
				</div>
			<!-- Beginning spatial filter -->
			<h3>@lang('misc.spatialFilter')</h3>
				<div class='pos_left'>
					@lang('misc.surrounding')<br>
					@lang('misc.searchDist')
				</div>
			<!-- End of spatial filter -->
			<!-- Beginning time filter -->
			<h3>@lang('misc.timeFilter')</h3>
				<div class='pos_left'>
					@lang('misc.timeFiltDef')<br>
					@lang('misc.timeStartEnd')
				</div>
			<!-- End of time filter -->
			<!-- Beginning rate-filter -->
			<h3>@lang('misc.rateFilter')</h3>
				<div class='pos_left'>
					@lang('misc.rateDef')<br>
					@lang('misc.rateScale') 
				</div>
			<!-- End of rate-filter -->
			<!-- Begin of keyword-search -->	
			<h3>@lang('misc.keywordSearch')</h3>
				<div class='pos_left'>
					@lang('misc.keyDef')
				</div>
			<!-- End of keyword-search -->
		<!-- End of howto filter -->
		<!-- Beginning howto see comments-->
		<h2>@lang('misc.howtoSeeComments')</h2>
			<div class='pos_left'>
				@lang('misc.seeComments')<br>
			</div>
			<h3>@lang('misc.commentsFurtherInfosTitle')</h3>
				<div class='pos_left'>
					@lang('misc.commentsFurtherInfos')<br>
				</div>
		<!-- End of howto see comments-->
		<!-- Beginning howto share-->
		<h2>@lang('misc.howtoShare')</h2>
			<div class='pos_left'>
				@lang('misc.shareMMM') <a class="btn btn-default btn-xs disabled">@lang('misc.share')&nbsp;<span class="glyphicon glyphicon-share-alt"></span></a><br>
				@lang('misc.shareMMMFurtherInfos')
			</div>
		<!-- End of howto share-->
	</div>
</div>

<div class="row clearfix"><br></div>