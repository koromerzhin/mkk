export class RevolutionSlider
{
	constructor ()
	{
		$('.rev_slider').each(
			function()
			{
				if ($(this).data('param') !== undefined)
				{
					$(this).revolution(JSON.parse($(this).data('param')))
				}
			}
		)
	}
}
