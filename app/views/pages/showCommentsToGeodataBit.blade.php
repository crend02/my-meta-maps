<div class="list-group-item">
	<div class="row clearfix">
		<dd><pre><%= ViewUtils.parseComment(comment.text) %></pre></dd>
	</div>
	<div class="row clearfix text-right metadata-comment">
		<% if (_.isEmpty(comment.user)) { %>
			<span class="badge alert-default pull-left">
				<span class="glyphicon glyphicon-user"></span>&nbsp;<span>@lang('misc.anonym')</span>
			</span>
		<% } else { %>
			<span class="badge alert-info pull-left">
				<span class="glyphicon glyphicon-user"></span>&nbsp;<span><%- comment.user.name %></span>
			</span>
		<% } %>
		<% if (1 == 1 || !_.isEmpty(comment.time.geometry)) { %>
		<span class="badge alert-default" title="Geodaten vorhanden">
			<span class="glyphicon glyphicon-map-marker"></span>
		</span>
		<% } if (!_.isEmpty(comment.time.start) || !_.isEmpty(comment.time.end)) { %>
		<a href="#" class="badge alert-default" title="Zeitraum" role="button" data-toggle="popover" 
		   data-content="Anfangsdatum: <%- comment.time.start ? comment.time.start : 'Keine Angabe' %>&lt;br /&gt;Enddatum: <%- comment.time.end ? comment.time.end : 'Keine Angabe' %>">
			<span class="glyphicon glyphicon-time"></span>
		</a>
		<% } %>
		<a href="#" class="badge alert-default" title="Permalink" role="button" data-toggle="popover" 
		   data-content="&lt;a href='<%- comment.permalink %>' target='_blank'&gt;<%- comment.permalink %>&lt;/a&gt;">
			<span class="glyphicon glyphicon-share-alt"></span>
		</a>
		<span class="badge alert-default" title="Bewertung: <%- comment.rating %> Sterne">
			<% for (i = 1; i <= 5; i++) {  %>
			<span class="glyphicon <%= (i <= comment.rating) ? 'glyphicon-star' : 'glyphicon-star-empty' %>"></span>
			<% } %>
		</span>
	</div>
</div>