<% _.each(data, function(row) { %>
	<a class="list-group-item" href="javascript:router.geodata(<%= row.id %>)" onmouseover="hoverGeodataBbox (<%= row.id %>)" onmouseout="hoverGeodataBbox()" id="GeodataLink<%= row.id %>"><%- row.metadata.title %>
		<span class="comment-<%= row.id %>-progress"></span>
		<span class="badge"><%= row.comments %></span>
	</a>
<% }); %>
<% if (_.isEmpty(data)) { %>
	<span class="list-group-item">@lang('misc.noSearch')</span>
<% } %>