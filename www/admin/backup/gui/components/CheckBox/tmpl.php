<span class="CheckBox fa " data-bind="
	click: toggle,
	css: {
		'fa-check-square-o': checked() == true,
		'fa-square-o': checked() === false,
		'fa-square': checked() === null,
		'disabled': disabled
	}
"
style="-webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -o-user-select: none; user-select: none;"></span>