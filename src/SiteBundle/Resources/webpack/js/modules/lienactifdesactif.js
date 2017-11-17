import {getXHRJson} from 'mkksite/js/modules/xhr/getXHRJson'
export class LienActifDesactif
{
	constructor (tableau)
	{
		let parent = this

		$(tableau).find('span').each(
			function()
			{
				$(this).on('click', parent.SpanOnclick.bind(parent))
			}
		)
	}

	SpanOnclick (event)
	{
		this.send($(event.currentTarget).attr('data-rel'), $(this).closest('table'))
	}
	async send (url, tableau)
	{
		let response = await getXHRJson(url)

		$(tableau).find('span').each(
			function()
			{
				if (!$(this).hasClass('btn-nochange'))
				{
					let id = $(this).attr('id')
					let classe = $(this).attr('class')
					let texte

					if ($('#' + id).attr('data-action') === 'all')
					{
						texte = 'info'
					}
					else
					{
						texte = 'danger'
					}
					if (classe.indexOf('btn-min') > -1)
					{
						$(this).attr('class', 'btn btn-mini btn-' + texte)
					}
					else
					{
						$(this).attr('class', 'btn btn-xs btn-' + texte)
					}
				}
			}
		)
		$(response).each(
			function(iterator)
			{
				let id = response[iterator]
				let classe = $('#' + id).attr('class')

				if (!$('#' + id).hasClass('btn-nochange'))
				{
					let texte

					if ($('#' + id).attr('data-action') === 'all')
					{
						texte = 'info'
					}
					else
					{
						texte = 'success'
					}
					if (classe !== undefined)
					{
						let classtext

						if (classe.indexOf('btn-min') > -1)
						{
							classtext = 'btn btn-mini btn-' + texte
						}
						else
						{
							classtext = 'btn btn-xs btn-' + texte
						}
						$('#' + id).attr('class', classtext)
					}
				}
			}
		)
	}
}
