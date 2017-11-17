import tmpl from 'blueimp-tmpl'
export class Upload
{
	uploadFile (IdDiv)
	{
		let option = {
			'uploadTemplateId'  : 'template-upload',
			'downloadTemplateId': 'template-download',
			'dataType'          : 'json',
			'autoUpload'        : true,
			'url'               : $('#' + IdDiv).attr('data-url')
		}

		$('#' + IdDiv).fileupload(option)
		// $('#' + IdDiv).fileupload(
		// 	'option',
		// 	'redirect',
		// 	window.location.href.replace(
		// 		/\/[^\/]*$/,
		// 		$('#' + IdDiv).attr('data-cors') + '?%s'
		// 	)
		// )
		$('#' + IdDiv).addClass('fileupload-processing')
		$.ajax(
			{
				'url'     : $('#' + IdDiv).fileupload('option', 'url'),
				'dataType': 'json',
				'context' : $('#' + IdDiv)[0]
			}
		).always(
			function()
			{
				$(this).removeClass('fileupload-processing')
			}
		).done(
			function(result)
			{
				$('#' + IdDiv).fileupload('option', 'done')
				let html = tmpl('template-download', result)

				$('#' + IdDiv).find('.files').html(html)
			}
		)
	}
	constructor ()
	{
		if ($.browser !== undefined && $.browser.mobile === false)
		{
			$('.LienTel').each(
				function()
				{
					$(this).attr('href', '#')
				}
			)
		}
		if ($('.EmplacementUpload').length)
		{
			let parent = this

			$(document).ready(
				function()
				{
					window.setInterval(
						function()
						{
							$('.EmplacementUpload').each(
								function()
								{
									let visible = $(this).is(':visible')

									if (visible && $(this).attr('data-visible') === '0' && $(this).attr('data-url') !== undefined)
									{
										$(this).attr('data-visible', 1)
										parent.uploadFile($(this).attr('id'))
									}
								}
							)
						},
						1000
					)
				}
			)
		}
	}
}
