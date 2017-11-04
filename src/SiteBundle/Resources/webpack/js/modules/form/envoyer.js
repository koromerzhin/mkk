import tinyMCE from 'tinymce'
function formEnvoyer (nomformulaire)
{
	$(nomformulaire).find('*[type=submit]').attr('data-actifbouton', 0)
	let $form = $(nomformulaire)
	let required = 0
	let champstropgrand = 0

	$form.find('input[required=\'required\']').each(
		function()
		{
			let name = $(this).attr('name')
			let type = $(this).attr('type')
			let classe = $(this).attr('class')

			if (classe !== undefined && classe.indexOf('select2-offscreen') > -1)
			{
				if ($(this).select2('val') === '')
				{
					required = 1
				}
			}
			else if (type === 'checked')
			{
				if ($(this).attr('checked') !== 'checked')
				{
					required = 1
				}
			}
			else if (type === 'radio')
			{
				if ($('input[name=\'' + name + '\']:checked').length === 0)
				{
					required = 1
				}
			}
			else if (type === 'password' || type === 'text')
			{
				if ($(this).val() === '')
				{
					required = 1
				}
			}
		}
	)
	$form.find('select[required=\'required\']').each(
		function()
		{
			if ($(this).attr('data-select2') !== 'non')
			{
				if ($(this).select2('val') === '')
				{
					required = 1
				}
			}
			else if ($(this).val() === '')
			{
				required = 1
			}
		}
	)
	$form.find('textarea').each(
		function()
		{
			if ($(this).hasClass('mceEditor') || $(this).hasClass('mceMiniEditor'))
			{
				let id = $(this).attr('id')

				$(this).val(tinyMCE.get(id).getContent())
			}
			if ($(this).attr('required') === 'required' && $(this).val() === '')
			{
				required = 1
			}
		}
	)
	$form.find('textarea').each(
		function()
		{
			let id = $(this).attr('id')

			if (typeof tinyMCE !== undefined)
			{
				if ($(this).hasClass('mceEditor') || $(this).hasClass('mceMiniEditor'))
				{
					let $champstinymce = $(tinyMCE.get(id).getContainer())

					if ($($champstinymce).find('.mce-lettercount').length && $($champstinymce).find('.mce-lettercount').hasClass('negatif')
					)
					{
						champstropgrand = 1
					}
				}
			}
		}
	)
	if (required === 1)
	{
		$('#PopupRequired').modal('toggle')
		$('#BoutonSaveAndClose').attr('data-close', 0)
		return false
	}

	if (champstropgrand === 1)
	{
		$('#PopupTinymceLetter').modal('show')
		return false
	}
	$(nomformulaire).find('*[type=submit]').attr('data-actifbouton', 1).trigger('click')
	$(nomformulaire).trigger('submit')
	return true
}
export {formEnvoyer}
