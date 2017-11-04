export class Navbar
{
	verifier ()
	{
		if ($('a[data-toggle="tab"]').length)
		{
			$('a[data-toggle="tab"]').on('click', this.OnClick)
			let lastTab = localStorage.getItem('lastTab')

			if (lastTab)
			{
				if ($('a[href="' + lastTab + '"]').length)
				{
					$('a[href="' + lastTab + '"]').trigger('click')
				}
				else
				{
					localStorage.removeItem('lastTab')
				}
			}
		}
	}
	OnClick (event)
	{
		let ul = $(this).closest('ul')

		if ($(ul).attr('data-nolocalstorage') === undefined)
		{
			localStorage.setItem('lastTab', $(event.target).attr('href'))
		}
	}

	NavTAbsAOnClick (event)
	{
		if ($($(this).attr('href')).length !== 0)
		{
			event.preventDefault()
			$(this).tab('show')
		}
	}
	prevNext ()
	{
		$('.NavPrev').on('click',
			function()
			{
				let li = $(this).closest('.nav-tabs').find('li')
				let nouveau

				$(li).each(
					function(iteration)
					{
						if (!$(this).hasClass('NavPrev') && !$(this).hasClass('NavNext'))
						{
							if ($(this).hasClass('active') && nouveau === undefined)
							{
								nouveau = iteration - 1
							}
						}
					}
				)
				if ($($(li).get(nouveau)) !== undefined)
				{
					if (!$($(li).get(nouveau)).hasClass('NavPrev'))
					{
						$($(li).get(nouveau)).find('a').trigger('click')
					}
				}
			}
		)
		$('.NavNext').on('click',
			function()
			{
				let li = $(this).closest('.nav-tabs').find('li')
				let nouveau

				$(li).each(
					function(iteration)
					{
						if (!$(this).hasClass('NavPrev') && !$(this).hasClass('NavNext'))
						{
							if ($(this).hasClass('active') && nouveau === undefined)
							{
								nouveau = iteration + 1
							}
						}
					}
				)
				if ($($(li).get(nouveau)) !== undefined)
				{
					if (!$($(li).get(nouveau)).hasClass('NavNext'))
					{
						$($(li).get(nouveau)).find('a').trigger('click')
					}
				}
			}
		)
	}
	constructor ()
	{
		this.verifier()
		this.prevNext()
		$('.nav-tabs').find('a').on('click', this.NavTAbsAOnClick)
	}
}
