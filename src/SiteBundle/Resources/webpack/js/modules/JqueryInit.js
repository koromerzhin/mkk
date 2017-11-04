export class JqueryInit
{
	reset ()
	{
		$.fn.reset = function()
		{
			return this.each(
				function()
				{
					let type = this.type
					let tag = this.tagName.toLowerCase()

					if (tag === 'form')
					{
						return $(':input', this).reset()
					}
					if (type === 'text' || type === 'password' || tag === 'textarea' || type === 'email')
					{
						this.value = ''
					}
					else if (type === 'checkbox' || type === 'radio')
					{
						this.checked = false
					}
					else if (tag === 'select')
					{
						this.selectedIndex = 0
					}
				}
			)
		}
		$.fn.serializeForm = function()
		{
			let $form = $(this)
			let datapost = {}
			let type
			let name
			let val

			$form.find('input').each(
				function()
				{
					name = $(this).attr('name')
					if (name !== undefined)
					{
						type = $(this).attr('type')
						if (type === 'radio')
						{
							datapost[name] = $('input[name=\'' + name + '\']:checked').val()
						}
						else if (type !== 'submit' && type !== 'file')
						{
							if ($form.find('input[name=\'' + name + '\']').length === 1)
							{
								if (type === 'checkbox')
								{
									if ($(this).is(':checked'))
									{
										datapost[name] = $(this).val()
									}
									else
									{
										datapost[name] = 0
									}
								}
								else if (type !== 'submit' && type !== 'button')
								{
									datapost[name] = $(this).val()
								}
							}
							else
							{
								datapost[name] = new Array()
								$form.find('input[name=\'' + name + '\']').each(
									function()
									{
										type = $(this).attr('type')
										if (type === 'checkbox')
										{
											if ($(this).is(':checked'))
											{
												datapost[name][datapost[name].length] = $(this).val()
											}
										}
										else if (type === 'radio')
										{
											if ($(this).is(':checked'))
											{
												datapost[name] = $(this).val()
											}
										}
										else if (type !== 'submit' && type !== 'button')
										{
											datapost[name][datapost[name].length] = $(this).val()
										}
									}
								)
							}
						}
					}
				}
			)
			$form.find('select').each(
				function()
				{
					name = $(this).attr('name')
					if (name !== undefined)
					{
						if ($form.find('select[name=\'' + name + '\']').length === 1)
						{
							if ($(this).hasClass('select2-offscreen'))
							{
								datapost[name] = $(this).select2('val')
							}
							else
							{
								datapost[name] = $(this).val()
							}
						}
						else
						{
							datapost[name] = new Array()
							$form.find('select[name=\'' + name + '\']').each(
								function()
								{
									if ($(this).hasClass('select2-offscreen'))
									{
										datapost[name][datapost[name].length] = $(this).select2('val')
									}
									else
									{
										datapost[name][datapost[name].length] = $(this).val()
									}
								}
							)
						}
					}
				}
			)
			$form.find('textarea').each(
				function()
				{
					name = $(this).attr('name')
					if (name !== undefined)
					{
						if ($form.find('textarea[name=\'' + name + '\']').length === 1)
						{
							val = $(this).val()
							datapost[name] = val
						}
						else
						{
							datapost[name] = new Array()
							$form.find('textarea[name=\'' + name + '\']').each(
								function()
								{
									val = $(this).val()
									datapost[name][datapost[name].length] = val
								}
							)
						}
					}
				}
			)
			return datapost
		}
	}
	constructor ()
	{
		this.reset()
	}
}
