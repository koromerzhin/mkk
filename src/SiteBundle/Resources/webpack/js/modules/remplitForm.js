function remplitForm (Emplacement, response)
{
	$(Emplacement).find('input').each(
		function()
		{
			let name = $(this).attr('id')

			if (name !== undefined)
			{
				if (name.indexOf('langue') > -1)
				{
					name = name.replace('langue', '')
					let tab = name.split('_')
					let langue = tab[0]
					let code = $(this).attr('id').replace('langue' + langue + '_', '')

					if (response.translates[langue] !== undefined && response.translates[langue][code] !== undefined)
					{
						$(this).val(response.translates[langue][code])
					}
					else if (response[code] !== undefined)
					{
						$(this).val(response[code])
					}
				}
				else
				{
					let tab = name.split('_')
					let code = tab[1]

					if (response[code] !== undefined)
					{
						$(this).val(response[code])
					}
				}
			}
		}
	)
}
export {remplitForm}
