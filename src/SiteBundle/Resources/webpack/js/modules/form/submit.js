export class Submit
{
	constructor ()
	{
		$('input,select').on(
			'keypress',
			function(event)
			{
				if (event.which === 13)
				{
					$(this).blur()
					event.preventDefault()
				}
			}
		)
	}
}
