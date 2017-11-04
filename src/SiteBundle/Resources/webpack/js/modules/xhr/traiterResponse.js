function traiterResponse (response)
{
	let $boutonclose = $('#BoutonSaveAndClose')
	let boutonclosevalue = $($boutonclose).attr('data-close')
	let etat = 0

	if ($boutonclose.length === 0 || boutonclosevalue ===0)
	{
		etat = 1
	}
	else if ($('#BoutonReturn').length === 0)
	{
		etat = 1
	}
	else
	{
		etat = 2
	}
	if (etat === 2)
	{
		document.location = $('#BoutonReturn').attr('href')
	}
	else
	{
		let id

		$('.modal').each(
			function()
			{
				$(this).modal('hide')
			}
		)
		if (response.supprimer !== undefined)
		{
			if (response.supprimer === 2)
			{
				if (response.message !== undefined)
				{
					$('#EmplacementMessageError').html(response.message)
				}
				if ($('#PopupErrorSupprimer').length)
				{
					$('#PopupErrorSupprimer').modal('show')
				}
			}
			else
			{
				document.location.reload()
			}
		}
		else if (response.ajouter !== undefined && response.ajouter === 1 || response.modifier !== undefined && response.modifier === 1)
		{
			id = 'PopupEnregistrement'
			$('#PopupEnregistrement').on(
				'hidden.bs.modal',
				function()
				{
					if (response.url !== undefined)
					{
						document.location = response.url
					}
					else
					{
						document.location.reload()
					}
				}
			)
			$('#' + id).find('a[data-rel=close]').on(
				'click',
				function()
				{
					if (response.url !== undefined)
					{
						document.location = response.url
					}
					else
					{
						document.location.reload()
					}
				}
			)
			$('#' + id).find('.close').on(
				'click',
				function()
				{
					if (response.url !== undefined)
					{
						document.location = response.url
					}
					else
					{
						document.location.reload()
					}
				}
			)
		}
		else
		{
			id = 'PopupErreur'
			$('#' + id).find('#PopupErreurListing').html(response.errors)
			$('#' + id).find('a[data-rel=close]').on(
				'click',
				function()
				{
					$('#' + id).modal('show')
				}
			)
			$('#' + id).find('.close').on(
				'click',
				function()
				{
					$('#' + id).modal('show')
				}
			)
		}
		$('#' + id).modal('show')
	}
}
export {traiterResponse}
