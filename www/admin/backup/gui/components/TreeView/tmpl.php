<script type="text/html" id="template-treeView">
	<li style="clear: both;list-style: none;font-size: 15px;" data-bind="css: { 'disabled': disabled }">
		<span style="float: left;width: 25px;height: 25px;font-size: 15px;">
			<i style="cursor: pointer;" class="fa " data-bind="visible: hasChildren, click: toggleChildren, css: { 'fa-chevron-right': !childrenVisible(), 'fa-chevron-down': childrenVisible }"></i>
		</span>
		<span class="toggleCheck" data-bind="visible: tree.selectable, component: new CheckBox(selected, disabled)"></span>
		
		<span style="cursor: default;" data-bind="text: name, click: toggleChildren"></span>
		
		<!-- ko if: childrenVisible -->
		<ul style="font-size: 15px;" data-bind="template: { name: 'template-treeView', foreach: children }"></ul>
		<!-- /ko -->
	</li>
</script>

<ul class="TreeView" data-bind="template: { name: 'template-treeView', foreach: data }"></ul>