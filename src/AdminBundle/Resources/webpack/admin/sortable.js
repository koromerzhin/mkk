import {postXHRJson} from 'mkksite/js/modules/xhr/postXHRJson'
export class Sortable
{
	constructor ()
	{
		$('.sortable').sortable()
		if ($('.sortable').length !== 0)
		{
			$('#BoutonSave').on('click', this.BoutonSave.bind(this))
		}
	}

	async executer (position)
	{
		let datapost = {
			'position': position
		}

		await postXHRJson($('#BoutonSave').attr('href'), datapost, 1)
		document.location.reload()
	}

	BoutonSave (event)
	{
		event.preventDefault()
		let position = {}

		$('.sortable').each(
			function()
			{
				let texte = ''

				$(this).find('li').each(
					function()
					{
						let id = $(this).attr('data-rel')

						if (texte !== '')
						{
							texte = texte + ','
						}

						texte = texte + id
					}
				)
				let rel = $(this).attr('data-rel')

				position[rel] = texte
			}
		)
		this.executer(position)
	}
}
